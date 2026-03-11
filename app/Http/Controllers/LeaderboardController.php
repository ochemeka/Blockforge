<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LeaderboardController extends Controller
{
    /**
     * Display leaderboard page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get top miners ordered by total_mined
        $topMiners = User::orderBy('total_mined', 'desc')
            ->limit(100)
            ->get()
            ->map(function ($miner, $index) {
                return [
                    'rank' => $index + 1,
                    'id' => $miner->id,
                    'name' => $miner->name,
                    'total_mined' => (float) $miner->total_mined,
                    'mining_balance' => (float) $miner->mining_balance,
                ];
            });
        
        // Get current user's rank
        $userRank = User::where('total_mined', '>', $user->total_mined)->count() + 1;
        
        return view('leaderboard', [
            'user' => $user,
            'topMiners' => $topMiners,
            'userRank' => $userRank,
        ]);
    }
    
    /**
     * Get leaderboard data as JSON
     */
    public function data()
    {
        $user = Auth::user();
        
        $topMiners = User::orderBy('total_mined', 'desc')
            ->limit(50)
            ->get()
            ->map(function ($miner, $index) {
                return [
                    'rank' => $index + 1,
                    'id' => $miner->id,
                    'name' => $miner->name,
                    'total_mined' => (float) $miner->total_mined,
                    'mining_balance' => (float) $miner->mining_balance,
                ];
            });
        
        $userRank = User::where('total_mined', '>', $user->total_mined)->count() + 1;
        
        return response()->json([
            'success' => true,
            'top_miners' => $topMiners,
            'user_rank' => $userRank,
            'user_total_mined' => (float) $user->total_mined,
        ]);
    }
}
