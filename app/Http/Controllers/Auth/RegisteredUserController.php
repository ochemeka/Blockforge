<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'size:2'],
            'state' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['nullable', 'string', 'max:255'],
            'terms' => ['required', 'accepted'],
        ]);

        // Find referrer if referral code provided
        $referredBy = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            $referredBy = $referrer ? $referrer->id : null;
        }

        // Generate unique referral code for new user
        $userReferralCode = $this->generateReferralCode();

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'country' => $request->country,
            'state' => $request->state,
            'password' => Hash::make($request->password),
            'referral_code' => $userReferralCode,
            'referred_by' => $referredBy,
        ]);

        // Send welcome email
        try {
            Mail::to($user->email)->send(new WelcomeMail($user));
        } catch (\Exception $e) {
            // Log error but don't fail registration
            Log::error('Welcome email failed: ' . $e->getMessage());
        }

        event(new Registered($user));

        // Redirect to login with email pre-filled and success message
        return redirect()->route('login')
            ->with('email', $request->email)
            ->with('success', 'Account created successfully! A welcome email has been sent to your email address. Please login with your credentials.');
    }

    /**
     * Generate a unique referral code
     */
    private function generateReferralCode(): string
    {
        do {
            $code = strtoupper(substr(md5(uniqid(rand(), true)), 0, 8));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}
