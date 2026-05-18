@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <a href="{{ route('user.purchase-history.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-400 hover:text-white transition mb-3">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 6-6 6 6 6"/><path d="M3 12h14"/></svg>
        Back to Purchase History
    </a>
    <h1 class="text-2xl font-black text-white">TRANSACTION DETAILS</h1>
    <p class="text-sm text-slate-400">Transaction #{{ $transaction->id }}</p>
</div>

@if(session('status'))
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        {{ session('status') }}
    </div>
@endif

@if(in_array($transaction->status, ['paid', 'completed']))
<div class="mb-6 rounded-xl bg-green-500/10 border border-green-400/30 p-6 flex items-center gap-4">
    <div class="w-14 h-14 rounded-full bg-green-500/20 flex items-center justify-center flex-shrink-0">
        <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <div>
        <h2 class="text-lg font-bold text-green-300">Payment Successful</h2>
        <p class="text-sm text-green-400/80">Your payment has been confirmed. The games are now available in your library.</p>
    </div>
</div>
@endif

@if($transaction->status === 'pending')
<div class="mb-6 rounded-xl bg-amber-500/10 border border-amber-400/30 p-6 flex items-center gap-4">
    <div class="w-14 h-14 rounded-full bg-amber-500/20 flex items-center justify-center flex-shrink-0">
        <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    </div>
    <div>
        <h2 class="text-lg font-bold text-amber-300">Awaiting Payment</h2>
        <p class="text-sm text-amber-400/80">Your payment is pending. Please complete the payment before the deadline.</p>
    </div>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Order Information</h2>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Transaction ID</span>
                    <span class="text-white font-mono">#{{ $transaction->id }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Date</span>
                    <span class="text-white">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Payment Method</span>
                    <span class="text-white font-semibold capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Payment Code</span>
                    <span class="text-white font-mono">{{ $transaction->payment_code ?? '—' }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Status</span>
                    <span class="status-{{ $transaction->status }} capitalize">{{ ucfirst($transaction->status) }}</span>
                </div>
                @if($transaction->status === 'paid' || $transaction->status === 'completed')
                <div class="flex justify-between text-sm">
                    <span class="text-slate-400">Paid At</span>
                    <span class="text-white">{{ $transaction->updated_at->format('d M Y, H:i') }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="dark-panel mt-6">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Purchased Items</h2>
                <p class="text-xs text-slate-400 mt-0.5">{{ $transaction->items->count() }} item(s)</p>
            </div>
            <div class="overflow-x-auto">
                <table class="steam-table">
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th class="text-center w-20">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaction->items as $item)
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
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-sm text-slate-500 py-8">No items found for this transaction.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="dark-panel p-6 sticky top-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Order Summary</h3>
            <div class="space-y-3 mb-6">
                @foreach($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 truncate mr-2">{{ Str::limit($item->game?->title ?? 'Game', 25) }} × {{ $item->quantity }}</span>
                        <span class="text-white font-semibold whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="pt-4 border-t border-white/10 flex justify-between items-center mb-6">
                <span class="text-sm font-bold text-white uppercase">Total</span>
                <span class="text-2xl font-black text-[#4b76c4]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>

            @if($transaction->status === 'pending')
                <a onclick="showModal('receipt-modal-pay')" class="steam-btn w-full text-center cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 12H3"/><path d="m11 18 6-6-6-6"/><path d="M21 5v14"/></svg>
                    Continue Payment
                </a>
            @endif

            @if($transaction->status === 'paid' || $transaction->status === 'completed')
                @php $receiptRoute = route('user.purchase-history.receipt', $transaction); @endphp
                <a onclick="showModal('receipt-modal-dl')" class="steam-btn w-full text-center cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Download Receipt (PDF)
                </a>
            @endif

            <a href="{{ route('user.purchase-history.index') }}" class="steam-btn-secondary w-full text-center mt-3">
                View All Transactions
            </a>
        </div>
    </div>
</div>

<div id="receipt-modal-dl" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="receipt-modal-dl-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Download Receipt</h3>
                <p class="text-sm text-slate-400 mt-1">Download a PDF receipt for transaction <span class="text-white font-semibold">#{{ $transaction->id }}</span>.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeModal('receipt-modal-dl')" class="steam-btn-secondary">Cancel</button>
            <a href="{{ route('user.purchase-history.receipt', $transaction) }}" onclick="closeModal('receipt-modal-dl')" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download Receipt
            </a>
        </div>
    </div>
</div>

<div id="receipt-modal-pay" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="receipt-modal-pay-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-amber-500/20 text-amber-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Continue Payment</h3>
                <p class="text-sm text-slate-400 mt-1">Proceed to payment for transaction <span class="text-white font-semibold">#{{ $transaction->id }}</span>.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeModal('receipt-modal-pay')" class="steam-btn-secondary">Cancel</button>
            <a href="{{ route('payment.show', $transaction) }}" onclick="closeModal('receipt-modal-pay')" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 12H3"/><path d="m11 18 6-6-6-6"/><path d="M21 5v14"/></svg>
                Continue
            </a>
        </div>
    </div>
</div>
@endsection
