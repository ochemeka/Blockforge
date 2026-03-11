<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class ReferralController extends Controller
{
    /**
     * Display referrals page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's referral code if not exists
        if (!$user->referral_code) {
            $user->referral_code = Str::upper(Str::random(8));
            $user->save();
        }
        
        // Get referred users
        $referrals = User::where('referred_by', $user->referral_code)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate referral bonuses (10% of mining rewards)
        $totalReferralEarnings = 0;
        foreach ($referrals as $referral) {
            $totalReferralEarnings += $referral->total_mined * 0.10;
        }
        
        return view('referrals', [
            'user' => $user,
            'referrals' => $referrals,
            'totalReferralEarnings' => $totalReferralEarnings,
            'referralLink' => url('/register?ref=' . $user->referral_code),
        ]);
    }
    
    /**
     * Get referrals data as JSON
     */
    public function data()
    {
        $user = Auth::user();
        
        if (!$user->referral_code) {
            $user->referral_code = Str::upper(Str::random(8));
            $user->save();
        }
        
        $referrals = User::where('referred_by', $user->referral_code)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($ref) {
                return [
                    'id' => $ref->id,
                    'name' => $ref->name,
                    'email' => $ref->email,
                    'mining_balance' => (float) $ref->mining_balance,
                    'total_mined' => (float) $ref->total_mined,
                    'earnings' => (float) $ref->total_mined * 0.10,
                    'joined_at' => $ref->created_at->toIso8601String(),
                ];
            });
        
        $totalEarnings = $referrals->sum('earnings');
        
        return response()->json([
            'success' => true,
            'referral_code' => $user->referral_code,
            'referral_link' => url('/register?ref=' . $user->referral_code),
            'referrals' => $referrals,
            'total_referrals' => $referrals->count(),
            'total_earnings' => $totalEarnings,
        ]);
    }
}
