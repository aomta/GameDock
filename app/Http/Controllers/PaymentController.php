<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function show(Transaction $transaction): View|RedirectResponse
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        if ($transaction->status === 'paid' || $transaction->status === 'completed') {
            return redirect()->route('user.purchase-history.detail', $transaction)->with('status', 'Payment already completed.');
        }

        $transaction->load('items.game');

        $expiryTime = $transaction->created_at->copy()->addHours(24);
        $timeRemaining = now()->lt($expiryTime) ? now()->diffInSeconds($expiryTime) : 0;

        return view('payment.show', compact('transaction', 'expiryTime', 'timeRemaining'));
    }

    public function updateMethod(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Cannot change payment method for completed transactions.');
        }

        $request->validate([
            'payment_method' => 'required|string|in:bank_transfer,ewallet,qris',
        ]);

        $transaction->update(['payment_method' => $request->payment_method, 'payment_code' => null]);

        return redirect()->route('payment.show', $transaction);
    }

    public function verify(Request $request, Transaction $transaction): RedirectResponse
    {
        abort_unless($transaction->user_id === auth()->id(), 403);

        if ($transaction->status === 'paid' || $transaction->status === 'completed') {
            return redirect()->route('user.my-games')->with('status', 'Payment already completed.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $file = $request->file('payment_proof');
        $filename = 'proof_' . $transaction->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/payments', $filename);

        $transaction->update([
            'status' => 'paid',
            'payment_proof' => $filename,
        ]);

        return back()->with('status', 'Payment proof submitted. Waiting for admin confirmation.');
    }
}
