@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">MY WISHLIST</h1>
    <p class="text-sm text-slate-400">Games you've saved for later</p>
</div>

@if($wishlist->count())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @foreach($wishlist as $item)
    <a href="{{ route('games.show', $item->game->slug) }}" class="steam-card block animate-fade-up opacity-0" style="animation-delay: {{ $loop->index * 50 }}ms">
        @if($item->game->image)
            <div class="relative h-36 overflow-hidden bg-[#05111a] flex items-center justify-center">
                <img src="{{ Storage::url('games/'.$item->game->image) }}" alt="{{ $item->game->title }}" class="w-full h-full object-contain transform group-hover:scale-110 transition duration-700">
            </div>
        @else
            <div class="h-36 bg-gradient-to-br from-[#202c40] to-[#2c3a52] flex items-center justify-center">
                <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
            </div>
        @endif
        <div class="steam-card-body">
            <div class="flex flex-wrap gap-1.5 mb-2">
                @if($item->game->genre)
                    @foreach(explode(' ', $item->game->genre) as $tag)
                        <span class="genre-tag">{{ $tag }}</span>
                    @endforeach
                @endif
            </div>
            <h3 class="font-bold text-white text-sm truncate">{{ $item->game->title }}</h3>
            @if($item->game->developer)
                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $item->game->developer }}</p>
            @endif
            <div class="mt-3 flex items-center justify-between">
                <span class="price-tag">Rp {{ number_format($item->game->price, 0, ',', '.') }}</span>
                <span class="text-[10px] text-slate-500">Saved {{ $item->created_at->diffForHumans() }}</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@else
<div class="dark-panel p-16 text-center">
    <svg class="w-20 h-20 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
    <p class="text-lg font-semibold text-slate-400">Your wishlist is empty</p>
    <p class="text-sm text-slate-600 mt-1">Browse the catalogue and save games you're interested in!</p>
    <a href="{{ route('games.index') }}" class="steam-btn inline-flex mt-6">Browse Games</a>
</div>
@endif
@endsection

<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>
