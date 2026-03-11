<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\MiningController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ReferralController;
use App\Http\Controllers\LeaderboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Google Authentication Routes
Route::get('auth/google', [GoogleAuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Mining Routes (requires authentication)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mining/status', [MiningController::class, 'status'])->name('mining.status');
    Route::post('/mining/mine', [MiningController::class, 'mine'])->name('mining.mine');
    
    // Wallet Routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet');
    Route::get('/wallet/data', [WalletController::class, 'data']);
    
    // Referral Routes
    Route::get('/referrals', [ReferralController::class, 'index'])->name('referrals');
    Route::get('/referrals/data', [ReferralController::class, 'data']);
    
    // Leaderboard Routes
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::get('/leaderboard/data', [LeaderboardController::class, 'data']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
