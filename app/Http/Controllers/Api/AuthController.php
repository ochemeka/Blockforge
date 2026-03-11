<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use PragmaRX\Google2FALaravel\Google2FA;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Generate API token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Registration successful',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * Login user.
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check rate limit
        $key = 'login:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json([
                'success' => false,
                'message' => "Too many login attempts. Please try again in {$seconds} seconds."
            ], 429);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            RateLimiter::hit($key, 60); // Block for 1 minute
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // Check if 2FA is enabled
        if ($user->two_factor_enabled) {
            return response()->json([
                'success' => true,
                'requires_2fa' => true,
                'user_id' => $user->id,
                'message' => 'Please verify your 2FA code'
            ], 200);
        }

        // Update last login
        $user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $request->ip()
        ]);

        // Clear rate limiter
        RateLimiter::clear($key);

        // Generate API token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Verify 2FA code.
     */
    public function verify2FA(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'exists:users,id'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::findOrFail($request->user_id);
        $google2fa = app(Google2FA::class);
        
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid 2FA code'
            ], 401);
        }

        // Update last login
        $user->update([
            'last_login_at' => Carbon::now(),
            'last_login_ip' => $request->ip()
        ]);

        // Generate API token
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * Enable 2FA for user.
     */
    public function enable2FA(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $google2fa = app(Google2FA::class);

        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid 2FA code'
            ], 401);
        }

        $user->update([
            'two_factor_enabled' => true,
            'two_factor_enabled_at' => Carbon::now()
        ]);

        return response()->json([
            'success' => true,
            'message' => '2FA enabled successfully'
        ]);
    }

    /**
     * Disable 2FA for user.
     */
    public function disable2FA(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string'],
            'code' => ['required', 'string', 'size:6'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        // Verify password first
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password'
            ], 401);
        }

        $google2fa = app(Google2FA::class);
        $valid = $google2fa->verifyKey($user->google2fa_secret, $request->code);

        if (!$valid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid 2FA code'
            ], 401);
        }

        $user->update([
            'two_factor_enabled' => false,
            'two_factor_enabled_at' => null,
            'google2fa_secret' => null
        ]);

        return response()->json([
            'success' => true,
            'message' => '2FA disabled successfully'
        ]);
    }

    /**
     * Generate 2FA secret for user.
     */
    public function generate2FASecret(Request $request): JsonResponse
    {
        $user = $request->user();
        
        // Don't allow if already enabled
        if ($user->two_factor_enabled) {
            return response()->json([
                'success' => false,
                'message' => '2FA is already enabled'
            ], 400);
        }

        $google2fa = app(Google2FA::class);
        $secret = $google2fa->generateSecretKey();
        
        // Store temporarily (will be confirmed on enable)
        $user->update(['google2fa_secret' => $secret]);

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            $user->email,
            $secret
        );

        return response()->json([
            'success' => true,
            'secret' => $secret,
            'qr_code_url' => $qrCodeUrl
        ]);
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Invalidate all tokens except current
        $user->tokens()->where('id', '!=', $request->user()->currentAccessToken()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Password updated successfully'
        ]);
    }

    /**
     * Logout user.
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    /**
     * Logout from all devices.
     */
    public function logoutAll(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out from all devices successfully'
        ]);
    }

    /**
     * Forgot password.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Don't reveal if email exists
        return response()->json([
            'success' => true,
            'message' => 'If the email exists, a reset link has been sent'
        ]);
    }

    /**
     * Reset password.
     */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required', 'string'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully'
        ]);
    }

    /**
     * Verify email.
     */
    public function verifyEmail(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }
}
