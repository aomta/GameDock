<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $latestTransactions = Transaction::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', [
            'totalGames' => Game::count(),
            'totalUsers' => User::count(),
            'adminUsers' => User::where('role', 'admin')->count(),
            'regularUsers' => User::where('role', 'user')->count(),
            'totalTransactions' => Transaction::count(),
            'latestUsers' => User::latest()->take(6)->get(),
            'totalRevenue' => Transaction::whereIn('status', ['paid', 'completed'])->sum('total_amount'),
            'pendingCount' => Transaction::where('status', 'pending')->count(),
            'completedCount' => Transaction::whereIn('status', ['paid', 'completed'])->count(),
            'latestTransactions' => $latestTransactions,
        ]);
    }
}
