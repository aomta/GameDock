@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">PAYMENT INSTRUCTIONS</h1>
    <p class="text-sm text-slate-400">Transaction #{{ $transaction->id }} — {{ ucfirst($transaction->payment_method) }}</p>
</div>

@if(session('status'))
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300">{{ session('status') }}</div>
@endif

@if($transaction->status === 'pending')
<div class="mb-4 rounded-lg border border-amber-400/30 bg-amber-500/15 px-4 py-3 text-sm text-amber-300 flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span><strong>Awaiting Payment</strong> &mdash; Your payment is pending. Please complete the payment before the deadline.</span>
</div>
@elseif($transaction->status === 'paid')
<div class="mb-4 rounded-lg border border-blue-400/30 bg-blue-500/15 px-4 py-3 text-sm text-blue-300 flex items-center gap-3">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
    <span><strong>Payment Submitted</strong> &mdash; Your payment has been recorded. Waiting for admin confirmation.</span>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">

        @if($transaction->payment_method === 'bank_transfer')
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Bank Transfer Details</h2>
                <p class="text-xs text-slate-400 mt-0.5">Transfer to one of the following accounts</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Bank Central Asia (BCA)</p>
                            <p class="text-2xl font-black text-white mt-1 font-mono">{{ $transaction->payment_code }}</p>
                            <p class="text-sm text-slate-400 mt-1">a/n PT GameDock Indonesia</p>
                        </div>
                        <button onclick="copyCode('{{ $transaction->payment_code }}')" class="steam-btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                            Copy
                        </button>
                    </div>
                </div>

                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Bank Mandiri</p>
                            <p class="text-2xl font-black text-white mt-1 font-mono">8901-234-567-890</p>
                            <p class="text-sm text-slate-400 mt-1">a/n PT GameDock Indonesia</p>
                        </div>
                        <button onclick="copyCode('8901234567890')" class="steam-btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                            Copy
                        </button>
                    </div>
                </div>

                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">Bank Negara Indonesia (BNI)</p>
                            <p class="text-2xl font-black text-white mt-1 font-mono">0987-654-321-098</p>
                            <p class="text-sm text-slate-400 mt-1">a/n PT GameDock Indonesia</p>
                        </div>
                        <button onclick="copyCode('0987654321098')" class="steam-btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                            Copy
                        </button>
                    </div>
                </div>

                <div class="rounded-lg bg-amber-500/10 border border-amber-400/30 p-4 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <div>
                        <p class="text-sm text-amber-300 font-bold">Important</p>
                        <p class="text-xs text-amber-300/80 mt-1">Transfer the <strong>exact amount</strong> including the unique code. Payment will be verified automatically.</p>
                    </div>
                </div>
            </div>
        </div>

        @elseif($transaction->payment_method === 'ewallet')
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">E-Wallet Payment</h2>
                <p class="text-xs text-slate-400 mt-0.5">Send payment to the number below</p>
            </div>
            <div class="p-6 space-y-4">
                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-12 h-12 rounded-full bg-green-500/20 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm text-slate-400">Phone Number</p>
                            <p class="text-2xl font-black text-white font-mono">{{ $transaction->payment_code }}</p>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500">a/n PT GameDock Indonesia — Works with GoPay, OVO, Dana, ShopeePay</p>
                </div>

                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded bg-[#00AED6]/20 flex items-center justify-center"><span class="text-xs font-black text-[#00AED6]">Go</span></div>
                        <span class="text-sm font-bold text-white">GoPay</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded bg-[#4C3494]/20 flex items-center justify-center"><span class="text-xs font-black text-[#8B5CF6]">OVO</span></div>
                        <span class="text-sm font-bold text-white">OVO</span>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-8 h-8 rounded bg-[#108EE9]/20 flex items-center justify-center"><span class="text-xs font-black text-[#108EE9]">Dana</span></div>
                        <span class="text-sm font-bold text-white">Dana</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded bg-[#EE4D2D]/20 flex items-center justify-center"><span class="text-xs font-black text-[#EE4D2D]">SP</span></div>
                        <span class="text-sm font-bold text-white">ShopeePay</span>
                    </div>
                </div>

                <button onclick="copyCode('{{ $transaction->payment_code }}')" class="steam-btn w-full">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    Copy Phone Number
                </button>
            </div>
        </div>

        @elseif($transaction->payment_method === 'qris')
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">QRIS Payment</h2>
                <p class="text-xs text-slate-400 mt-0.5">Scan QR code with any Indonesian e-wallet app</p>
            </div>
            <div class="p-6 space-y-5">
                <div class="bg-white rounded-xl p-6 flex flex-col items-center max-w-xs mx-auto">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=256x256&data={{ urlencode('00020101021126570016COM.NOBUBANK.WWW01189360001500000' . $transaction->payment_code . '0215ID20230001030000152045812530336054' . number_format($transaction->total_amount, 2, '.', '') . '5802ID5913PT GameDock Indonesia6007JAKARTA62440540000000000000000000' . $transaction->payment_code . '00000000000' . $transaction->id) }}&color=000000&bgcolor=FFFFFF" alt="QRIS QR Code" class="w-64 h-64 rounded-lg mb-4">
                    <div class="text-center">
                        <p class="text-xs text-slate-500 font-bold uppercase tracking-wider">Scan with any QRIS app</p>
                        <p class="text-sm font-bold text-slate-800 mt-1">PT GameDock Indonesia</p>
                    </div>
                </div>

                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-500 uppercase tracking-wider font-bold">QRIS Code</p>
                            <p class="text-lg font-black text-white font-mono">{{ $transaction->payment_code }}</p>
                        </div>
                        <button onclick="copyCode('{{ $transaction->payment_code }}')" class="steam-btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                            Copy
                        </button>
                    </div>
                </div>

                <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-4 flex items-center gap-3">
                    <div class="flex gap-2 flex-wrap">
                        <span class="text-[10px] font-bold text-green-400 bg-green-500/15 px-2 py-1 rounded">GoPay</span>
                        <span class="text-[10px] font-bold text-purple-400 bg-purple-500/15 px-2 py-1 rounded">OVO</span>
                        <span class="text-[10px] font-bold text-blue-400 bg-blue-500/15 px-2 py-1 rounded">Dana</span>
                        <span class="text-[10px] font-bold text-orange-400 bg-orange-500/15 px-2 py-1 rounded">ShopeePay</span>
                        <span class="text-[10px] font-bold text-red-400 bg-red-500/15 px-2 py-1 rounded">BCA Mobile</span>
                        <span class="text-[10px] font-bold text-yellow-400 bg-yellow-500/15 px-2 py-1 rounded">Mandiri</span>
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

    <div>
        <div class="dark-panel p-6 sticky top-4">
            <div class="mb-5">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Payment expires in</p>
                <div id="countdown" class="bg-[#0f1f30] rounded-lg p-3 text-center border border-amber-400/20">
                    <div class="flex justify-center gap-2">
                        <div class="text-center">
                            <span id="cd-hours" class="block text-3xl font-black text-amber-400 font-mono">23</span>
                            <span class="text-[10px] text-slate-500 uppercase font-bold">Hours</span>
                        </div>
                        <span class="text-3xl font-black text-amber-400/60">:</span>
                        <div class="text-center">
                            <span id="cd-minutes" class="block text-3xl font-black text-amber-400 font-mono">59</span>
                            <span class="text-[10px] text-slate-500 uppercase font-bold">Mins</span>
                        </div>
                        <span class="text-3xl font-black text-amber-400/60">:</span>
                        <div class="text-center">
                            <span id="cd-seconds" class="block text-3xl font-black text-amber-400 font-mono">59</span>
                            <span class="text-[10px] text-slate-500 uppercase font-bold">Secs</span>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Order Summary</h3>
            <div class="space-y-3 mb-4">
                @foreach($transaction->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 truncate mr-2">{{ Str::limit($item->game->title, 25) }} × {{ $item->quantity }}</span>
                        <span class="text-white font-semibold whitespace-nowrap">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="pt-4 border-t border-white/10 flex justify-between items-center mb-6">
                <span class="text-sm font-bold text-white uppercase">Total</span>
                <span class="text-2xl font-black text-[#4b76c4]">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
            </div>

            <div class="mb-4 flex justify-between text-sm">
                <span class="text-slate-400">Status</span>
                <span class="status-{{ $transaction->status }} capitalize">
                    @if($transaction->status === 'pending') Awaiting Payment
                    @elseif($transaction->status === 'paid') Awaiting Confirmation
                    @else {{ ucfirst($transaction->status) }}
                    @endif
                </span>
            </div>
            <div class="mb-6 flex justify-between text-sm">
                <span class="text-slate-400">Method</span>
                <span class="text-white font-semibold capitalize">{{ str_replace('_', ' ', $transaction->payment_method) }}</span>
            </div>

            @if($transaction->status === 'pending')
            <button type="button" onclick="showModal('change-method-modal')" class="steam-btn-secondary w-full mb-3 text-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Change Payment Method
            </button>
            <button type="button" onclick="showModal('payment-confirm-modal')" class="steam-btn w-full">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                I've Made the Payment
            </button>
            @elseif($transaction->status === 'paid')
            <div class="rounded-lg bg-blue-500/10 border border-blue-400/30 p-4 text-center mb-4">
                <svg class="w-8 h-8 text-blue-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-bold text-blue-300">Awaiting Confirmation</p>
                <p class="text-xs text-blue-400/80 mt-1">Your payment has been submitted and is being reviewed by our team.</p>
            </div>
            @elseif($transaction->status === 'completed')
            <div class="rounded-lg bg-green-500/10 border border-green-400/30 p-4 text-center mb-4">
                <svg class="w-8 h-8 text-green-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm font-bold text-green-300">Payment Completed</p>
                <p class="text-xs text-green-400/80 mt-1">Your games are now available in My Games.</p>
            </div>
            <a href="{{ route('user.my-games') }}" class="steam-btn w-full text-center">
                Go to My Games
            </a>
            @endif

            <a href="{{ route('user.purchase-history.index') }}" class="steam-btn-secondary w-full text-center mt-3">
                View Purchase History
            </a>
        </div>
    </div>
</div>

@if($transaction->status === 'pending')
<div id="change-method-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="change-method-modal-content">
        <h3 class="text-lg font-bold text-white mb-1">Change Payment Method</h3>
        <p class="text-sm text-slate-400 mb-5">Select a new payment method for this transaction.</p>
        <form action="{{ route('payment.updateMethod', $transaction) }}" method="POST" class="space-y-3">
            @csrf @method('PATCH')
            <label class="pm-label @if($transaction->payment_method === 'bank_transfer') border-[#4b76c4]/50 bg-[#4b76c4]/10 @endif">
                <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" {{ $transaction->payment_method === 'bank_transfer' ? 'checked' : '' }}>
                <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                    <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">Bank Transfer</p>
                    <p class="text-xs text-slate-500">BCA, Mandiri, or BNI</p>
                </div>
            </label>
            <label class="pm-label @if($transaction->payment_method === 'ewallet') border-[#4b76c4]/50 bg-[#4b76c4]/10 @endif">
                <input type="radio" name="payment_method" value="ewallet" class="sr-only peer" {{ $transaction->payment_method === 'ewallet' ? 'checked' : '' }}>
                <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                    <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">E-Wallet</p>
                    <p class="text-xs text-slate-500">GoPay, OVO, Dana, ShopeePay</p>
                </div>
            </label>
            <label class="pm-label @if($transaction->payment_method === 'qris') border-[#4b76c4]/50 bg-[#4b76c4]/10 @endif">
                <input type="radio" name="payment_method" value="qris" class="sr-only peer" {{ $transaction->payment_method === 'qris' ? 'checked' : '' }}>
                <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                    <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                </div>
                <div>
                    <p class="text-sm font-semibold text-white">QRIS</p>
                    <p class="text-xs text-slate-500">Scan QR from any e-wallet</p>
                </div>
            </label>
            <div class="flex gap-3 justify-end pt-4">
                <button type="button" onclick="closeModal('change-method-modal')" class="steam-btn-secondary">Cancel</button>
                <button type="submit" class="steam-btn">Update Method</button>
            </div>
        </form>
    </div>
</div>

<div id="payment-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="payment-confirm-modal-content">
        <div class="text-center mb-5">
            <div class="w-16 h-16 rounded-full bg-amber-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <h3 class="text-lg font-bold text-white mb-1">Confirm Payment</h3>
            <p class="text-sm text-slate-400">Make sure you have completed the transfer before confirming. Once confirmed, your payment will be queued for verification by our team.</p>
        </div>
        <form action="{{ route('payment.verify', $transaction) }}" method="POST">
            @csrf
            <div class="flex gap-3">
                <button type="button" onclick="closeModal('payment-confirm-modal')" class="steam-btn-secondary flex-1">Cancel</button>
                <button type="submit" class="steam-btn flex-1">Yes, I've Paid</button>
            </div>
        </form>
    </div>
</div>

<style>
.pm-label { display: flex; align-items: center; gap: 12px; padding: 14px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: all 0.2s; }
.pm-label:hover { border-color: rgba(75,118,196,0.5); }
</style>
@endif

@if(session('copied'))
<div id="copied-toast" class="fixed bottom-6 right-6 bg-green-500/90 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg flex items-center gap-2">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    Copied to clipboard!
</div>
@endif

<script>
function copyCode(code) {
    navigator.clipboard.writeText(code).then(function() {
        var toast = document.createElement('div');
        toast.className = 'fixed bottom-6 right-6 bg-green-500/90 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg flex items-center gap-2 z-50';
        toast.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied to clipboard!';
        document.body.appendChild(toast);
        setTimeout(function() { toast.remove(); }, 2000);
    });
}

(function() {
    var remaining = {{ $timeRemaining }};
    if (remaining <= 0) {
        document.getElementById('countdown').classList.remove('border-amber-400/20');
        document.getElementById('countdown').classList.add('border-red-400/30', 'bg-red-500/10');
        document.getElementById('cd-hours').textContent = '00';
        document.getElementById('cd-minutes').textContent = '00';
        document.getElementById('cd-seconds').textContent = '00';
        document.getElementById('cd-hours').classList.remove('text-amber-400');
        document.getElementById('cd-hours').classList.add('text-red-400');
        document.getElementById('cd-minutes').classList.remove('text-amber-400');
        document.getElementById('cd-minutes').classList.add('text-red-400');
        document.getElementById('cd-seconds').classList.remove('text-amber-400');
        document.getElementById('cd-seconds').classList.add('text-red-400');
        return;
    }

    function updateCountdown() {
        if (remaining <= 0) return;
        remaining--;
        var h = Math.floor(remaining / 3600);
        var m = Math.floor((remaining % 3600) / 60);
        var s = remaining % 60;
        document.getElementById('cd-hours').textContent = String(h).padStart(2, '0');
        document.getElementById('cd-minutes').textContent = String(m).padStart(2, '0');
        document.getElementById('cd-seconds').textContent = String(s).padStart(2, '0');

        if (remaining <= 3600) {
            document.getElementById('countdown').classList.remove('border-amber-400/20');
            document.getElementById('countdown').classList.add('border-red-400/30');
            document.getElementById('cd-hours').classList.remove('text-amber-400');
            document.getElementById('cd-hours').classList.add('text-red-400');
            document.getElementById('cd-minutes').classList.remove('text-amber-400');
            document.getElementById('cd-minutes').classList.add('text-red-400');
            document.getElementById('cd-seconds').classList.remove('text-amber-400');
            document.getElementById('cd-seconds').classList.add('text-red-400');
        }
    }
    setInterval(updateCountdown, 1000);
})();
</script>
@endsection
