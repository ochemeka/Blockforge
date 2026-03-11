<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes for React Native Mobile App
|--------------------------------------------------------------------------
|
| These routes are rate-limited for security. They provide API endpoints
| for the React Native mobile application with maximum security.
|
*/

// Rate limiting configuration
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});

// Auth rate limiting (stricter for login/register)
RateLimiter::for('auth', function (Request $request) {
    return Limit::perMinute(5)->by($request->ip());
});

/*
|--------------------------------------------------------------------------
| Public API Routes (Rate Limited)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    // Registration
    Route::post('/register', [AuthController::class, 'register'])
        ->name('api.register');
    
    // Login
    Route::post('/login', [AuthController::class, 'login'])
        ->name('api.login');
    
    // Password Reset
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
        ->name('api.password.forgot');
    
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('api.password.reset');
    
    // Verify email
    Route::get('/verify-email/{id}/{hash}', [AuthController::class, 'verifyEmail'])
        ->name('api.email.verify');
});

/*
|--------------------------------------------------------------------------
| Protected API Routes (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    // User profile
    Route::get('/user', [UserController::class, 'show'])
        ->name('api.user.show');
    
    Route::put('/user', [UserController::class, 'update'])
        ->name('api.user.update');
    
    // Password update
    Route::put('/password', [AuthController::class, 'updatePassword'])
        ->name('api.password.update');
    
    // Two-Factor Authentication
    Route::post('/2fa/enable', [AuthController::class, 'enable2FA'])
        ->name('api.2fa.enable');
    
    Route::post('/2fa/disable', [AuthController::class, 'disable2FA'])
        ->name('api.2fa.disable');
    
    Route::post('/2fa/verify', [AuthController::class, 'verify2FA'])
        ->name('api.2fa.verify');
    
    // Logout (invalidate all tokens)
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('api.logout');
    
    // Invalidate all other sessions
    Route::post('/logout-all', [AuthController::class, 'logoutAll'])
        ->name('api.logout.all');
});
