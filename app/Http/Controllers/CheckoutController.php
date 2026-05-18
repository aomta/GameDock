<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        $games = Game::whereIn('id', array_keys($cart))->where('active', true)->get()->keyBy('id');

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

        return view('checkout.create', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string|in:bank_transfer,ewallet,qris',
        ]);

        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $games = Game::whereIn('id', array_keys($cart))->where('active', true)->get()->keyBy('id');

        DB::beginTransaction();
        try {
            $total = 0;
            $orderItems = [];

            foreach ($cart as $gameId => $qty) {
                if ($games->has($gameId)) {
                    $game = $games->get($gameId);
                    $subtotal = $game->price * $qty;
                    $total += $subtotal;
                    $orderItems[] = [
                        'game_id' => $game->id,
                        'quantity' => $qty,
                        'price' => $game->price,
                    ];
                }
            }

            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
            ]);

            foreach ($orderItems as $item) {
                $transaction->items()->create($item);
            }

            $uniqueCode = rand(100, 999);
            $paymentCode = match($request->payment_method) {
                'bank_transfer' => '8801' . $transaction->id . str_pad($uniqueCode, 3, '0', STR_PAD_LEFT),
                'ewallet' => '0812-3456-7890',
                'qris' => 'ID1029000' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) . $uniqueCode,
            };

            $transaction->update(['payment_code' => $paymentCode]);

            session()->forget('cart');

            DB::commit();

            return redirect()->route('payment.show', $transaction);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }
}
