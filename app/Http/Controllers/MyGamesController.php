<?php

namespace App\Http\Controllers;

use App\Models\TransactionItem;
use Illuminate\Support\Facades\Auth;

class MyGamesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $ownedGames = TransactionItem::query()
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->join('games', 'transaction_items.game_id', '=', 'games.id')
            ->where('transactions.user_id', $user->id)
            ->where('transactions.status', 'completed')
            ->select('games.*', 'transactions.created_at as purchased_at')
            ->distinct()
            ->orderBy('purchased_at', 'desc')
            ->get()
            ->map(function ($game) {
                $game->purchased_at = \Carbon\Carbon::parse($game->purchased_at);
                return $game;
            });

        return view('user.my-games', ['games' => $ownedGames]);
    }
}
