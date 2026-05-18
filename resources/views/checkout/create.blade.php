@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">CHECKOUT</h1>
    <p class="text-sm text-slate-400">Complete your purchase</p>
</div>

@if(session('error'))
    <div class="mb-4 rounded-lg border border-red-400/30 bg-red-500/15 px-4 py-3 text-sm text-red-300">
        {{ session('error') }}
    </div>
@endif

<div id="checkout-steps">
    <div class="max-w-2xl">
        <div class="flex items-center gap-4 mb-8">
            <div id="step1-indicator" class="flex items-center gap-2 text-[#4b76c4]">
                <div id="step1-circle" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-[#4b76c4] text-white transition-all duration-300">1</div>
                <span id="step1-label" class="text-sm font-semibold hidden sm:inline transition-all duration-300">Details</span>
            </div>
            <div id="connector" class="flex-1 h-px bg-slate-800 overflow-hidden">
                <div id="connector-fill" class="h-full bg-[#4b76c4] w-0 transition-all duration-500"></div>
            </div>
            <div id="step2-indicator" class="flex items-center gap-2 text-slate-600">
                <div id="step2-circle" class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-slate-700 transition-all duration-300">2</div>
                <span id="step2-label" class="text-sm font-semibold hidden sm:inline transition-all duration-300">Confirmation</span>
            </div>
        </div>

        <div id="step1">
            <div class="dark-panel p-6 mb-6">
                <h2 class="text-lg font-bold text-white mb-4">Order Summary</h2>
                <div class="space-y-3">
                    @foreach($items as $item)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($item['game']->image)
                                    <img src="{{ Storage::url('games/'.$item['game']->image) }}" alt="" class="h-10 w-14 rounded object-cover bg-slate-700">
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-white">{{ $item['game']->title }}</p>
                                    <p class="text-xs text-slate-500">{{ $item['quantity'] }} × Rp {{ number_format($item['game']->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                            <span class="text-sm font-bold text-white">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center">
                    <span class="text-sm font-bold text-white uppercase">Total</span>
                    <span class="text-2xl font-black text-[#4b76c4]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="dark-panel p-6">
                <h2 class="text-lg font-bold text-white mb-4">Payment Method</h2>
                <div class="space-y-3">
                    <label class="pm-label">
                        <input type="radio" name="payment_method" value="bank_transfer" class="sr-only peer" onchange="selectPayment(this)">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                            <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">Bank Transfer</p>
                            <p class="text-xs text-slate-500">Transfer via BCA, Mandiri, or BNI</p>
                        </div>
                    </label>

                    <label class="pm-label">
                        <input type="radio" name="payment_method" value="ewallet" class="sr-only peer" onchange="selectPayment(this)">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                            <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">E-Wallet</p>
                            <p class="text-xs text-slate-500">GoPay, OVO, Dana, ShopeePay</p>
                        </div>
                    </label>

                    <label class="pm-label">
                        <input type="radio" name="payment_method" value="qris" class="sr-only peer" onchange="selectPayment(this)">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-600 flex items-center justify-center peer-checked:border-[#4b76c4] peer-checked:bg-[#4b76c4] transition">
                            <div class="w-2 h-2 rounded-full bg-white opacity-0 peer-checked:opacity-100"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white">QRIS</p>
                            <p class="text-xs text-slate-500">Scan QR from any Indonesian e-wallet</p>
                        </div>
                    </label>
                </div>

                <div class="mt-6 pt-4 border-t border-white/10 flex items-center gap-3 justify-between">
                    <a href="{{ route('cart.index') }}" class="steam-btn-secondary">Back to Cart</a>
                    <button type="button" onclick="goToStep(2)" id="btn-continue" class="steam-btn opacity-50 cursor-not-allowed" disabled>
                        Continue
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 12H3"/><path d="m11 18 6-6-6-6"/><path d="M21 5v14"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="step2" style="display:none">
            <form action="{{ route('checkout.store') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" id="hidden-payment-method">

                <div class="dark-panel p-6 mb-6">
                    <h2 class="text-lg font-bold text-white mb-4">Confirm Your Order</h2>
                    <div class="rounded-lg bg-[#0f1f30] border border-white/10 p-5">
                        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-white/10">
                            <svg class="w-6 h-6 text-[#4b76c4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <p class="text-sm font-bold text-white">Review your purchase</p>
                                <p class="text-xs text-slate-400">Please verify all details before confirming</p>
                            </div>
                        </div>

                        <div class="space-y-3 mb-4">
                            @foreach($items as $item)
                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-3">
                                    @if($item['game']->image)
                                        <img src="{{ Storage::url('games/'.$item['game']->image) }}" alt="" class="h-8 w-12 rounded object-cover bg-slate-700">
                                    @endif
                                    <span class="text-white font-medium">{{ $item['game']->title }}</span>
                                </div>
                                <span class="text-slate-300">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="pt-4 border-t border-white/10 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-slate-400">Payment Method</span>
                                <span id="confirm-payment-method" class="text-white font-semibold capitalize"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-white font-bold uppercase text-sm">Total</span>
                                <span class="text-xl font-black text-[#4b76c4]">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 justify-between">
                    <button type="button" onclick="goToStep(1)" class="steam-btn-secondary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 6-6 6 6 6"/><path d="M3 12h14"/><path d="M21 19V5"/></svg>
                        Edit Order
                    </button>
                    <button type="button" onclick="openPaymentModal()" class="steam-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Confirm & Pay
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="payment-confirm-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="payment-confirm-modal-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Confirm Payment</h3>
                <p class="text-sm text-slate-400 mt-1" id="payment-confirm-message"></p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button onclick="closeModal('payment-confirm-modal')" class="steam-btn-secondary">Cancel</button>
            <form action="{{ route('checkout.store') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="payment_method" id="confirm-payment-hidden">
                <button type="submit" class="steam-btn">Yes, Pay Now</button>
            </form>
        </div>
    </div>
</div>

<div id="checkout-data" data-total="{{ $total }}" style="display:none"></div>

<script>
var selectedPayment = '';
var payLabels = { 'bank_transfer': 'Bank Transfer', 'ewallet': 'E-Wallet', 'qris': 'QRIS' };
var total = parseFloat(document.getElementById('checkout-data').dataset.total);

function selectPayment(radio) {
    document.querySelectorAll('.pm-label').forEach(function(label) {
        label.classList.remove('border-[#4b76c4]/50', 'bg-[#4b76c4]/10');
    });
    radio.closest('.pm-label').classList.add('border-[#4b76c4]/50', 'bg-[#4b76c4]/10');
    selectedPayment = radio.value;

    var btn = document.getElementById('btn-continue');
    btn.disabled = false;
    btn.classList.remove('opacity-50', 'cursor-not-allowed');
}

function goToStep(step) {
    document.getElementById('step1').style.display = step === 1 ? 'block' : 'none';
    document.getElementById('step2').style.display = step === 2 ? 'block' : 'none';

    var s1 = document.getElementById('step1-indicator');
    var s2 = document.getElementById('step2-indicator');
    var s1c = document.getElementById('step1-circle');
    var s2c = document.getElementById('step2-circle');
    var s1l = document.getElementById('step1-label');
    var s2l = document.getElementById('step2-label');
    var conn = document.getElementById('connector-fill');

    if (step === 1) {
        s1.className = 'flex items-center gap-2 text-[#4b76c4]';
        s1c.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-[#4b76c4] text-white transition-all duration-300';
        s1c.innerHTML = '1';
        s1l.innerHTML = 'Details';
        s2.className = 'flex items-center gap-2 text-slate-600';
        s2c.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-slate-700 transition-all duration-300';
        s2c.innerHTML = '2';
        s2l.innerHTML = 'Confirmation';
        conn.style.width = '0';
    } else {
        document.getElementById('hidden-payment-method').value = selectedPayment;
        document.getElementById('confirm-payment-method').textContent = payLabels[selectedPayment];

        s1.className = 'flex items-center gap-2 text-[#4b76c4]';
        s1c.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold bg-green-500 text-white transition-all duration-300';
        s1c.innerHTML = '✓';
        s1l.innerHTML = 'Completed';
        s2.className = 'flex items-center gap-2 text-[#4b76c4]';
        s2c.className = 'w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold border-2 border-[#4b76c4] text-[#4b76c4] animate-pulse transition-all duration-300';
        s2c.innerHTML = '2';
        s2l.innerHTML = 'Confirmation';
        conn.style.width = '100%';
    }
}

function openPaymentModal() {
    if (!selectedPayment) return;
    document.getElementById('payment-confirm-message').textContent = 'You are about to pay Rp ' + total.toLocaleString('id-ID') + ' via ' + payLabels[selectedPayment] + '. Are you sure?';
    document.getElementById('confirm-payment-hidden').value = selectedPayment;
    if (typeof showModal === 'function') {
        showModal('payment-confirm-modal');
    } else {
        var modal = document.getElementById('payment-confirm-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(function() { modal.style.opacity = '1'; }, 10);
    }
}
</script>

<style>
.pm-label { display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 10px; border: 1px solid rgba(255,255,255,0.1); cursor: pointer; transition: all 0.2s; }
.pm-label:hover { border-color: rgba(75,118,196,0.5); }
</style>
@endsection
