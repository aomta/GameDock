<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class UserPurchaseHistoryController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->with('items.game')
            ->latest()
            ->paginate(10);
        return view('user.purchase-history', ['transactions' => $transactions]);
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction->load('items.game');

        return view('user.purchase-history-detail', compact('transaction'));
    }

    public function receipt(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        $html = view('user.receipt-pdf', ['transaction' => $transaction])->render();
        return Pdf::loadHTML($html)->download('struk-belanja-'.$transaction->id.'.pdf');
    }
}
