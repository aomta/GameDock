<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\TransactionsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class AdminTransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::query();
        if ($request->input('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->input('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        if ($request->input('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
        $transactions = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.transactions.index', ['transactions' => $transactions]);
    }

    public function show(Transaction $transaction)
    {
        return view('admin.transactions.show', ['transaction' => $transaction]);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate(['status' => 'required|string']);
        $transaction->status = $request->input('status');
        $transaction->save();
        return redirect()->route('admin.transactions.index')->with('status', 'Transaction updated');
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('admin.transactions.index')->with('status', 'Transaction deleted');
    }

    public function exportPdf(Transaction $transaction)
    {
        $html = view('admin.transactions.pdf', ['transaction' => $transaction])->render();
        $pdf = PDF::loadHTML($html);
        return $pdf->download('transaction-'.$transaction->id.'.pdf');
    }

    public function exportAllPdf(Request $request)
    {
        $query = Transaction::query();
        if ($request->input('status')) $query->where('status', $request->input('status'));
        if ($request->input('from')) $query->whereDate('created_at', '>=', $request->input('from'));
        if ($request->input('to')) $query->whereDate('created_at', '<=', $request->input('to'));
        $transactions = $query->get();
        $pdf = PDF::loadView('admin.transactions.list-pdf', ['transactions' => $transactions]);
        return $pdf->download('transactions.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Transaction::query();
        if ($request->input('status')) $query->where('status', $request->input('status'));
        if ($request->input('from')) $query->whereDate('created_at', '>=', $request->input('from'));
        if ($request->input('to')) $query->whereDate('created_at', '<=', $request->input('to'));
        $transactions = $query->get();
        $export = new TransactionsExport($transactions);
        return Excel::download($export, 'transactions.xlsx');
    }
}
