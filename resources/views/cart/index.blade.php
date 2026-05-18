@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">YOUR CART</h1>
    <p class="text-sm text-slate-400">{{ count($items) }} item(s) in your cart</p>
</div>

@if(session('added_game'))
    @php $ag = session('added_game'); @endphp
    <div id="added-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
        <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-sm w-full mx-4 transform transition-all scale-95 translate-y-4 relative" id="added-modal-content">
            <button onclick="closeAddedModal()" class="absolute top-3 right-3 text-slate-500 hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="text-center">
                <div class="w-12 h-12 mx-auto mb-4 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                @if($ag['image'])
                    <img src="{{ Storage::url('games/'.$ag['image']) }}" alt="{{ $ag['title'] }}" class="w-full h-32 rounded-lg object-contain bg-slate-700 mb-4">
                @endif
                <h3 class="text-lg font-bold text-white mb-1">{{ $ag['title'] }}</h3>
                <p class="text-sm text-slate-400 mb-1">Added to cart!</p>
                <p class="text-xl font-black text-[#4b76c4]">Rp {{ number_format($ag['price'], 0, ',', '.') }}</p>
            </div>
            <div class="mt-5 flex gap-3">
                <button onclick="closeAddedModal(); window.location.href='{{ route('games.index') }}'" class="steam-btn-secondary flex-1 text-center text-sm">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
                    Continue Shopping
                </button>
                <a href="{{ route('checkout.create') }}" class="steam-btn flex-1 text-center text-sm">
                    Checkout
                </a>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="mb-4 rounded-lg border border-red-400/30 bg-red-500/15 px-4 py-3 text-sm text-red-300">
        {{ session('error') }}
    </div>
@endif

@if(count($items))
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="dark-panel overflow-hidden">
            <div class="overflow-x-auto">
                <table class="steam-table">
                    <thead>
                        <tr>
                            <th>Game</th>
                            <th class="text-center w-28">Quantity</th>
                            <th class="text-right">Subtotal</th>
                            <th class="w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    @if($item['game']->image)
                                        <img src="{{ Storage::url('games/'.$item['game']->image) }}" alt="" class="h-14 w-20 rounded object-cover bg-slate-700">
                                    @endif
                                    <div>
                                        <a href="{{ route('games.show', $item['game']) }}" class="text-sm font-semibold text-white hover:text-[#4b76c4] transition">{{ $item['game']->title }}</a>
                                        <p class="text-xs text-slate-500">Rp {{ number_format($item['game']->price, 0, ',', '.') }} each</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('cart.update', $item['game']) }}" method="POST" class="flex items-center justify-center gap-1">
                                    @csrf @method('PATCH')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="10" class="w-14 steam-input text-center py-1 px-2 text-sm" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td class="text-right">
                                <span class="text-green-400 font-bold text-sm">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <button onclick="showModal('remove-modal-{{ $item['game']->id }}')" class="steam-btn-danger" title="Remove">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                @include('components.confirm-modal', [
                                    'id' => 'remove-modal-' . $item['game']->id,
                                    'title' => 'Remove from Cart?',
                                    'message' => 'Remove "' . $item['game']->title . '" from your cart?',
                                    'action' => route('cart.destroy', $item['game']),
                                    'method' => 'DELETE',
                                    'type' => 'info',
                                    'confirmText' => 'Remove'
                                ])
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div>
        <div class="dark-panel p-6 sticky top-4">
            <h3 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Order Summary</h3>
            <div class="space-y-3 mb-6">
                @foreach($items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-slate-400 truncate">{{ Str::limit($item['game']->title, 25) }} × {{ $item['quantity'] }}</span>
                        <span class="text-white font-semibold ml-2">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
            <div class="pt-4 border-t border-white/10 flex justify-between items-center mb-6">
                <span class="text-sm font-bold text-white uppercase">Total</span>
                <span class="text-2xl font-black text-[#4b76c4]">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
            <a href="{{ route('checkout.create') }}" class="steam-btn w-full">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 12H3"/><path d="m11 18 6-6-6-6"/><path d="M21 5v14"/></svg>
                Proceed to Checkout
            </a>
            <div class="mt-3 flex gap-2">
                <a href="{{ route('games.index') }}" class="steam-btn-secondary flex-1 text-center text-xs">
                    <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
                    Browse Catalogue
                </a>
                <button onclick="showModal('clear-cart-modal')" class="steam-btn-danger flex-1 text-center text-sm px-5 py-2.5">Clear Cart</button>
            </div>
        </div>
    </div>
</div>
@include('components.confirm-modal', [
    'id' => 'clear-cart-modal',
    'title' => 'Clear Cart?',
    'message' => 'This will remove all items from your cart. Are you sure?',
    'action' => route('cart.clear'),
    'method' => 'POST',
    'type' => 'danger',
    'confirmText' => 'Clear Cart'
])
@else
<div class="dark-panel p-16 text-center">
    <svg class="w-20 h-20 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
    <p class="text-slate-400 text-lg font-semibold">Your cart is empty</p>
    <p class="text-slate-600 text-sm mt-1 mb-6">Browse our catalogue to find something you like</p>
    <a href="{{ route('games.index') }}" class="steam-btn">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
        Browse Catalogue
    </a>
</div>
@endif

@if(session('added_game'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        var modal = document.getElementById('added-modal');
        var content = document.getElementById('added-modal-content');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(function() {
            modal.style.opacity = '1';
            content.classList.remove('scale-95', 'translate-y-4');
            content.classList.add('scale-100', 'translate-y-0');
        }, 10);
    }, 300);
});
function closeAddedModal() {
    var modal = document.getElementById('added-modal');
    var content = document.getElementById('added-modal-content');
    modal.style.opacity = '0';
    content.classList.remove('scale-100', 'translate-y-0');
    content.classList.add('scale-95', 'translate-y-4');
    setTimeout(function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }, 200);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        var m = document.getElementById('added-modal');
        if (!m.classList.contains('hidden')) closeAddedModal();
    }
});
</script>
@endif

@endsection
