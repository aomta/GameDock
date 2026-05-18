<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\View\View;

class GameController extends Controller
{
    public function index(): View
    {
        $query = Game::where('active', true);

        if (request('search')) {
            $query->where('title', 'like', '%'.request('search').'%');
        }

        if (request('genre')) {
            $genres = (array) request('genre');
            $query->where(function ($q) use ($genres) {
                foreach ($genres as $genre) {
                    $q->orWhere('genre', 'like', '%'.$genre.'%');
                }
            });
        }

        $games = $query->oldest()->paginate(12)->withQueryString();
        $allGenreWords = Game::where('active', true)->pluck('genre')->filter()
            ->flatMap(fn ($g) => explode(' ', $g))
            ->unique()
            ->sort()
            ->values();

        $ownedIds = [];
        $wishlistIds = [];
        if (auth()->check()) {
            $ownedIds = \App\Models\TransactionItem::whereHas('transaction', function ($q) {
                $q->where('user_id', auth()->id())->whereIn('status', ['paid', 'completed']);
            })->pluck('game_id')->toArray();
            $wishlistIds = \App\Models\Wishlist::where('user_id', auth()->id())->pluck('game_id')->toArray();
        }

        return view('games.index', [
            'games' => $games,
            'genres' => $allGenreWords,
            'ownedIds' => $ownedIds,
            'wishlistIds' => $wishlistIds,
        ]);
    }

    public function show(Game $game): View
    {
        abort_unless($game->active, 404);

        $ownsGame = false;
        $onWishlist = false;
        if (auth()->check()) {
            $ownsGame = \App\Models\TransactionItem::whereHas('transaction', function ($q) {
                $q->where('user_id', auth()->id())->whereIn('status', ['paid', 'completed']);
            })->where('game_id', $game->id)->exists();
            $onWishlist = \App\Models\Wishlist::where('user_id', auth()->id())->where('game_id', $game->id)->exists();
        }

        return view('games.show', [
            'game' => $game,
            'ownsGame' => $ownsGame,
            'onWishlist' => $onWishlist,
        ]);
    }
}
