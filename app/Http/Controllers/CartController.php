<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $games = Game::whereIn('id', array_keys($cart))->get()->keyBy('id');

        $items = [];
        $total = 0;

        foreach ($cart as $gameId => $qty) {
            if ($games->has($gameId)) {
                $game = $games->get($gameId);
                $subtotal = $game->price * $qty;
                $total += $subtotal;
                $items[] = [
                    'game' => $game,
                    'quantity' => $qty,
                    'subtotal' => $subtotal,
                ];
            }
        }

        return view('cart.index', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request, Game $game)
    {
        abort_unless($game->active, 404);

        $user = auth()->user();
        if ($user && \App\Models\TransactionItem::whereHas('transaction', function ($q) use ($user) {
            $q->where('user_id', $user->id)->whereIn('status', ['paid', 'completed']);
        })->where('game_id', $game->id)->exists()) {
            return redirect()->route('cart.index')->with('error', 'You already own this game!');
        }

        $cart = session('cart', []);
        if (isset($cart[$game->id])) {
            return redirect()->route('cart.index')->with('error', 'Game is already in your cart!');
        }
        $cart[$game->id] = 1;
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with([
            'status' => 'Added to cart!',
            'added_game' => [
                'title' => $game->title,
                'price' => $game->price,
                'image' => $game->image,
            ]
        ]);
    }

    public function update(Request $request, Game $game)
    {
        $cart = session('cart', []);
        $qty = (int) $request->input('quantity', 1);

        if ($qty <= 0) {
            unset($cart[$game->id]);
        } else {
            $cart[$game->id] = $qty;
        }

        session(['cart' => $cart]);
        return redirect()->route('cart.index');
    }

    public function destroy(Game $game)
    {
        $cart = session('cart', []);
        unset($cart[$game->id]);
        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('status', 'Item removed from cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('status', 'Cart cleared');
    }
}
