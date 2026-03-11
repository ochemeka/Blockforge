<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;

class WalletController extends Controller
{
    /**
     * Display wallet page
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get user's transactions (deposits, withdrawals, mining rewards)
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();
        
        return view('wallet', [
            'user' => $user,
            'transactions' => $transactions,
        ]);
    }
    
    /**
     * Get wallet data as JSON
     */
    public function data()
    {
        $user = Auth::user();
        
        $transactions = Transaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($tx) {
                return [
                    'id' => $tx->id,
                    'type' => $tx->type,
                    'amount' => (float) $tx->amount,
                    'status' => $tx->status,
                    'description' => $tx->description,
                    'created_at' => $tx->created_at->toIso8601String(),
                ];
            });
        
        return response()->json([
            'success' => true,
            'balance' => (float) $user->mining_balance,
            'total_mined' => (float) $user->total_mined,
            'transactions' => $transactions,
        ]);
    }
}
