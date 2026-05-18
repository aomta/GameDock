@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">TRANSACTION #{{ $transaction->id }}</h1>
    <p class="text-sm text-slate-400">Transaction details and items</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Transaction Info</h2>
            </div>
            <div class="dark-panel-body space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">User</p>
                        <p class="text-sm font-semibold text-white">{{ $transaction->user?->name ?? 'User '.$transaction->user_id }}</p>
                        <p class="text-xs text-slate-400">{{ $transaction->user?->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Payment Method</p>
                        <p class="text-sm font-semibold text-white capitalize">{{ $transaction->payment_method ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Date</p>
                        <p class="text-sm text-slate-300">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Status</p>
                        <div class="mt-1">
                            <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST" class="flex gap-2 items-center">
                                @csrf @method('PUT')
                                <select name="status" class="steam-select w-32 text-xs py-1.5">
                                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $transaction->status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <button type="submit" class="steam-btn-sm">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Items ({{ $transaction->items->count() }})</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="steam-table">
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaction->items as $item)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($item->game?->image)
                                        <img src="{{ Storage::url('games/'.$item->game->image) }}" alt="" class="h-10 w-14 rounded object-cover bg-slate-700">
                                    @endif
                                    <span class="text-sm font-semibold text-white">{{ $item->game?->title ?? 'Game #'.$item->game_id }}</span>
                                </div>
                            </td>
                            <td class="text-center text-sm">{{ $item->quantity }}</td>
                            <td class="text-right text-sm text-slate-400">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td class="text-right text-sm font-bold text-white">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="dark-panel p-6 text-center">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wider mb-2">Total Amount</p>
            <p class="text-3xl font-black text-green-400">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
        </div>

        <div class="dark-panel p-6 space-y-3">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider">Actions</h3>
            <a href="{{ route('admin.transactions.exportPdf', $transaction) }}" class="steam-btn-secondary w-full text-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                Download PDF
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="steam-btn-secondary w-full text-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-from-line-icon lucide-arrow-left-from-line"><path d="m9 6-6 6 6 6"/><path d="M3 12h14"/><path d="M21 19V5"/></svg>
                Back to List
            </a>
            <button onclick="showModal('tx-del-modal')" class="steam-btn-danger w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Delete Transaction
            </button>
        </div>
    </div>
</div>
@include('components.confirm-modal', [
    'id' => 'tx-del-modal',
    'title' => 'Delete Transaction?',
    'message' => 'Delete transaction #' . $transaction->id . ' permanently? This action cannot be undone.',
    'action' => route('admin.transactions.destroy', $transaction),
    'method' => 'DELETE',
    'type' => 'danger',
    'confirmText' => 'Delete Transaction'
])
@endsection
