<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $transCount = Transaction::where('user_id', $user->id)->where('status', 'completed')->count();
        $transTotal = Transaction::where('user_id', $user->id)->where('status', 'completed')->sum('total_amount');
        $latestTransactions = Transaction::where('user_id', $user->id)->latest()->take(5)->get();

        return view('user.dashboard', [
            'transCount' => $transCount,
            'transTotal' => $transTotal,
            'latestTransactions' => $latestTransactions,
        ]);
    }
}
