<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update existing user with Google ID if not set
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            } else {
                // Create new user
                $userReferralCode = $this->generateReferralCode();
                
                $user = User::create([
                    'name' => $googleUser->name,
                    'username' => $this->generateUsername($googleUser->name),
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(uniqid()),
                    'email_verified_at' => now(),
                    'referral_code' => $userReferralCode,
                ]);
            }

            // Log in the user
            Auth::login($user);

            return redirect()->intended('/dashboard')->with('success', 'Welcome back! You have logged in with Google.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Unable to login with Google. Please try again.');
        }
    }

    /**
     * Generate unique referral code
     */
    private function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Generate unique username from name
     */
    private function generateUsername(string $name): string
    {
        $baseUsername = strtolower(str_replace(' ', '', $name));
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
