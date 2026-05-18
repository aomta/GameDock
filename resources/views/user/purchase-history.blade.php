@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">PURCHASE HISTORY</h1>
    <p class="text-sm text-slate-400">Your past transactions and receipts</p>
</div>

@forelse($transactions as $t)
<div class="steam-card p-5 mb-4 transition-all duration-300">
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <div class="flex items-center gap-3 mb-1">
                <p class="text-blue-400 font-semibold">Transaksi #{{ $t->id }}</p>
                <span class="status-{{ $t->status }} px-2 py-0.5 rounded text-xs font-semibold">{{ ucfirst($t->status) }}</span>
            </div>
            <p class="text-slate-400 text-sm">{{ $t->created_at->format('d M Y H:i') }} — <span class="capitalize">{{ str_replace('_', ' ', $t->payment_method) }}</span></p>
            <div class="mt-2 space-y-1">
                @foreach($t->items as $item)
                <p class="text-sm">{{ $item->game?->title ?? 'Game #'.$item->game_id }} — Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                @endforeach
            </div>
        </div>
        <div class="text-right ml-4 flex flex-col items-end gap-2">
            <p class="font-bold text-lg">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</p>
            <a href="{{ route('user.purchase-history.detail', $t) }}" class="text-xs text-blue-400 hover:text-blue-300 transition">View Details →</a>
            @if(in_array($t->status, ['paid', 'completed']))
            <a onclick="showModal('receipt-dl-{{ $t->id }}')" class="text-xs text-slate-400 hover:text-white transition cursor-pointer">
                <svg class="w-3 h-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download Receipt
            </a>
            @endif
        </div>
    </div>
</div>

<div id="receipt-dl-{{ $t->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="receipt-dl-{{ $t->id }}-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Download Receipt</h3>
                <p class="text-sm text-slate-400 mt-1">Download a PDF receipt for transaction <span class="text-white font-semibold">#{{ $t->id }}</span>.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeModal('receipt-dl-{{ $t->id }}')" class="steam-btn-secondary">Cancel</button>
            <a href="{{ route('user.purchase-history.receipt', $t) }}" onclick="closeModal('receipt-dl-{{ $t->id }}')" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download Receipt
            </a>
        </div>
    </div>
</div>
@empty
<div class="dark-panel p-16 text-center text-slate-400">
    <svg class="w-16 h-16 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    <p class="text-lg font-semibold">No Purchase History Yet.</p>
    <a href="{{ route('games.index') }}" class="steam-btn mt-4 inline-block">Browse Catalogue</a>
</div>
@endforelse

@if($transactions->hasPages())
<div class="mt-6 flex justify-center">
    {{ $transactions->links() }}
</div>
@endif
@endsection
