<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\View\View;

class TrendingController extends Controller
{
    public function index(): View
    {
        $newGames = Game::where('active', true)->latest()->take(8)->get();
        
        $trendingGames = Game::where('active', true)->inRandomOrder()->take(8)->get();

        $ownedIds = [];
        if (auth()->check()) {
            $ownedIds = \App\Models\TransactionItem::whereHas('transaction', function ($q) {
                $q->where('user_id', auth()->id())->whereIn('status', ['paid', 'completed']);
            })->pluck('game_id')->toArray();
        }

        return view('trending.index', compact('newGames', 'trendingGames', 'ownedIds'));
    }
}
