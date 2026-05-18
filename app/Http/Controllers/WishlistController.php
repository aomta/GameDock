<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Wishlist;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WishlistController extends Controller
{
    public function index(): View
    {
        $wishlist = Wishlist::where('user_id', auth()->id())
            ->with('game')
            ->latest()
            ->get();

        return view('wishlist.index', compact('wishlist'));
    }

    public function toggle(Game $game): RedirectResponse
    {
        $existing = Wishlist::where('user_id', auth()->id())
            ->where('game_id', $game->id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Wishlist::create([
                'user_id' => auth()->id(),
                'game_id' => $game->id,
            ]);
        }

        return back()->with('status', $existing ? 'Removed from wishlist' : 'Added to wishlist');
    }
}
