@extends('layouts.dashboard')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-white">TRANSACTIONS</h1>
        <p class="text-sm text-slate-400">Manage and review all transactions</p>
    </div>
    <div class="flex gap-2">
        <button onclick="showModal('export-pdf-modal')" class="steam-btn-secondary text-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </button>
        <button onclick="showModal('export-excel-modal')" class="steam-btn-secondary text-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </button>
    </div>
</div>

@if(session('status'))
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300">
        {{ session('status') }}
    </div>
@endif

<div class="dark-panel mb-6 p-4">
    <form method="GET" action="{{ route('admin.transactions.index') }}" class="flex flex-wrap gap-3 items-end">
        <div>
            <label class="steam-label">Status</label>
            <select name="status" class="steam-select w-40">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="steam-label">From</label>
            <input type="date" name="from" value="{{ request('from') }}" class="steam-select w-40">
        </div>
        <div>
            <label class="steam-label">To</label>
            <input type="date" name="to" value="{{ request('to') }}" class="steam-select w-40">
        </div>
        <button type="submit" class="steam-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
            Filter
        </button>
    </form>
</div>

<div class="dark-panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="steam-table">
            <thead>
                <tr>
                    <th class="w-16">ID</th>
                    <th>User</th>
                    <th>Payment</th>
                    <th>Total</th>
                    <th class="w-28 text-center">Status</th>
                    <th class="w-36">Date</th>
                    <th class="w-36 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $t)
                <tr>
                    <td class="font-mono text-xs text-slate-500">#{{ $t->id }}</td>
                    <td>
                        <p class="font-semibold text-white text-sm">{{ $t->user?->name ?? 'User '.$t->user_id }}</p>
                        <p class="text-xs text-slate-500">{{ $t->user?->email ?? '-' }}</p>
                    </td>
                    <td class="text-slate-400 text-xs capitalize">{{ $t->payment_method ?? '-' }}</td>
                    <td><span class="text-green-400 font-bold text-sm">Rp {{ number_format($t->total_amount, 0, ',', '.') }}</span></td>
                    <td class="text-center">
                        <span class="status-{{ $t->status }}">{{ ucfirst($t->status) }}</span>
                    </td>
                    <td>
                        <p class="text-sm text-slate-300">{{ $t->created_at->format('d M Y') }}</p>
                        <p class="text-xs text-slate-500">{{ $t->created_at->format('H:i') }}</p>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.transactions.show', $t) }}" class="steam-btn-sm">
                            View
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-500">No transactions found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($transactions->hasPages())
    <div class="mt-4 dark-pagination flex justify-center gap-2">
        {{ $transactions->links() }}
    </div>
@endif

<div id="export-pdf-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="export-pdf-modal-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Export as PDF</h3>
                <p class="text-sm text-slate-400 mt-1">Download a PDF report of all transactions matching your current filters.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeModal('export-pdf-modal')" class="steam-btn-secondary">Cancel</button>
            <a href="{{ route('admin.transactions.exportPdfAll', request()->only(['status', 'from', 'to'])) }}" onclick="closeModal('export-pdf-modal')" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download PDF
            </a>
        </div>
    </div>
</div>

<div id="export-excel-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="export-excel-modal-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Export as Excel</h3>
                <p class="text-sm text-slate-400 mt-1">Download an Excel spreadsheet of all transactions matching your current filters.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button type="button" onclick="closeModal('export-excel-modal')" class="steam-btn-secondary">Cancel</button>
            <a href="{{ route('admin.transactions.exportExcel', request()->only(['status', 'from', 'to'])) }}" onclick="closeModal('export-excel-modal')" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Download Excel
            </a>
        </div>
    </div>
</div>
@endsection
