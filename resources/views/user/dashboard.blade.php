@extends('layouts.dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-white">WELCOME BACK, {{ strtoupper(auth()->user()->name) }}</h1>
    <p class="text-slate-400 mt-1">Here's your gaming activity overview</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="group relative overflow-hidden bg-gradient-to-br from-[#1e3a5c] to-[#2d5a8c] rounded-xl p-5 shadow-xl">
        <div class="absolute top-0 right-0 mt-2 mr-4 opacity-10">
            <svg class="w-20 h-20 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="text-blue-200 text-xs font-bold uppercase tracking-widest">Total Purchases</p>
            </div>
            <p class="text-4xl font-black text-white">{{ $transCount ?? 0 }}</p>
        </div>
    </div>

    <div class="group relative overflow-hidden bg-gradient-to-br from-[#1e3a1c] to-[#2d5a2c] rounded-xl p-5 shadow-xl">
        <div class="absolute top-0 right-0 mt-2 mr-4 opacity-10">
            <svg class="w-20 h-20 text-green-200" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M7.954 1.372a1 1 0 0 1 1.414-.15l3.262 2.664a1 1 0 0 1 .25 1.245A3 3 0 0 0 12 5h-.3l.298-.34l-1.718-1.403l-1.417 1.744H7.574l1.931-2.376l-.77-.629L6.337 5h-1.28zM10.5 10a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zM3 5.5a.5.5 0 0 1 .5-.5h.558l.795-1H3.5A1.5 1.5 0 0 0 2 5.5v6A2.5 2.5 0 0 0 4.5 14H12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H3.5a.5.5 0 0 1-.5-.5m0 6V6.915q.236.084.5.085H12a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4.5A1.5 1.5 0 0 1 3 11.5"/></svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-green-300" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M7.954 1.372a1 1 0 0 1 1.414-.15l3.262 2.664a1 1 0 0 1 .25 1.245A3 3 0 0 0 12 5h-.3l.298-.34l-1.718-1.403l-1.417 1.744H7.574l1.931-2.376l-.77-.629L6.337 5h-1.28zM10.5 10a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zM3 5.5a.5.5 0 0 1 .5-.5h.558l.795-1H3.5A1.5 1.5 0 0 0 2 5.5v6A2.5 2.5 0 0 0 4.5 14H12a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H3.5a.5.5 0 0 1-.5-.5m0 6V6.915q.236.084.5.085H12a1 1 0 0 1 1 1v4a1 1 0 0 1-1 1H4.5A1.5 1.5 0 0 1 3 11.5"/></svg>
                <p class="text-green-200 text-xs font-bold uppercase tracking-widest">Total Spent</p>
            </div>
            <p class="text-2xl font-black text-white">Rp {{ isset($transTotal) ? number_format($transTotal, 0, ',', '.') : '0' }}</p>
        </div>
    </div>

    <a href="{{ route('games.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-[#3a2e1c] to-[#5a4e2c] rounded-xl p-5 shadow-xl hover:shadow-2xl transition cursor-pointer">
        <div class="absolute top-0 right-0 mt-2 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-20 h-20 text-yellow-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/></svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-yellow-300" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83z"/><path d="M2 12a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 12"/><path d="M2 17a1 1 0 0 0 .58.91l8.6 3.91a2 2 0 0 0 1.65 0l8.58-3.9A1 1 0 0 0 22 17"/></svg>
                <p class="text-yellow-200 text-xs font-bold uppercase tracking-widest">Browse Catalogue</p>
            </div>
            <p class="text-lg font-black text-white">Explore Games →</p>
        </div>
    </a>

    <a href="{{ route('cart.index') }}" class="group relative overflow-hidden bg-gradient-to-br from-[#2d1e5c] to-[#4d2d8c] rounded-xl p-5 shadow-xl hover:shadow-2xl transition cursor-pointer">
        <div class="absolute top-0 right-0 mt-2 mr-4 opacity-10 group-hover:opacity-20 transition-opacity">
            <svg class="w-20 h-20 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
        </div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 mb-2">
                <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                <p class="text-purple-200 text-xs font-bold uppercase tracking-widest">Your Cart</p>
            </div>
            <p class="text-lg font-black text-white">Checkout →</p>
        </div>
    </a>
</div>

@if(isset($latestTransactions) && $latestTransactions->count())
<div class="dark-panel overflow-hidden">
    <div class="dark-panel-header flex items-center justify-between">
        <div>
            <h2 class="text-lg font-black text-white">Recent Purchases</h2>
            <p class="text-xs text-slate-400 mt-0.5">Your latest transactions</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="steam-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th class="text-center">Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($latestTransactions as $tx)
                <tr>
                    <td class="font-mono text-xs text-slate-500">#{{ $tx->id }}</td>
                    <td><span class="text-green-400 font-bold text-sm">Rp {{ number_format($tx->total_amount, 0, ',', '.') }}</span></td>
                    <td class="text-center"><span class="status-{{ $tx->status }}">{{ ucfirst($tx->status) }}</span></td>
                    <td class="text-sm text-slate-300">{{ $tx->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
