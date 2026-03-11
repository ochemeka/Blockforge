<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Transaction;

class MiningController extends Controller
{
    // Mining amount per 24-hour cycle
    const MINING_REWARD = 2400;
    const MINING_COOLDOWN_HOURS = 24;

    /**
     * Get mining status for the authenticated user
     */
    public function status()
    {
        $user = Auth::user();
        
        $now = Carbon::now();
        $nextAvailable = $user->next_mining_available_at ? Carbon::parse($user->next_mining_available_at) : null;
        
        // Check if mining is available
        $canMine = false;
        $countdown = null;
        
        if (!$nextAvailable || $now->gte($nextAvailable)) {
            $canMine = true;
            $countdown = 0;
        } else {
            // Calculate remaining time
            $countdown = $now->diffInSeconds($nextAvailable);
        }
        
        return response()->json([
            'success' => true,
            'mining_balance' => (float) $user->mining_balance,
            'total_mined' => (float) $user->total_mined,
            'can_mine' => $canMine,
            'countdown' => $countdown,
            'last_mined_at' => $user->last_mined_at ? Carbon::parse($user->last_mined_at)->toIso8601String() : null,
            'next_mining_available_at' => $nextAvailable ? $nextAvailable->toIso8601String() : null,
            'mining_reward' => self::MINING_REWARD,
        ]);
    }

    /**
     * Process mining action
     */
    public function mine(Request $request)
    {
        $user = Auth::user();
        
        $now = Carbon::now();
        $nextAvailable = $user->next_mining_available_at ? Carbon::parse($user->next_mining_available_at) : null;
        
        // Check if user can mine
        if ($nextAvailable && $now->lt($nextAvailable)) {
            $remaining = $now->diffForHumans($nextAvailable, true);
            return response()->json([
                'success' => false,
                'message' => "Mining not available yet. Please wait {$remaining}.",
            ], 422);
        }
        
        // Process mining reward
        $user->mining_balance += self::MINING_REWARD;
        $user->total_mined += self::MINING_REWARD;
        $user->last_mined_at = $now;
        $user->next_mining_available_at = $now->addHours(self::MINING_COOLDOWN_HOURS);
        $user->save();
        
        // Create transaction record
        Transaction::create([
            'user_id' => $user->id,
            'type' => 'mining_reward',
            'amount' => self::MINING_REWARD,
            'status' => 'completed',
            'description' => 'Daily mining reward',
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Mining successful! You earned ' . self::MINING_REWARD . ' BFB',
            'mining_balance' => (float) $user->mining_balance,
            'total_mined' => (float) $user->total_mined,
            'can_mine' => false,
            'countdown' => self::MINING_COOLDOWN_HOURS * 3600, // 24 hours in seconds
            'last_mined_at' => $user->last_mined_at->toIso8601String(),
            'next_mining_available_at' => $user->next_mining_available_at->toIso8601String(),
        ]);
    }
}
