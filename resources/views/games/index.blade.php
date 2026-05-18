@extends('layouts.dashboard')

@section('content')
<style>
    @keyframes fadeUp {
        0% { opacity: 0; transform: translateY(20px); }
        100% { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
</style>

<div class="mb-6">
    <h1 class="text-2xl font-black text-white">GAME CATALOGUE</h1>
    <p class="text-sm text-slate-400">Browse our collection of games</p>
</div>

<form method="GET" action="{{ route('games.index') }}" class="mb-6" x-data="{ filterOpen: false, selectedGenres: @js(array_values((array) request('genre', []))) }">
    <div class="flex flex-wrap gap-3">
        <div class="flex-1 min-w-[200px]">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search games..." class="steam-input">
        </div>
        <button type="button" @click="filterOpen = true" class="steam-btn relative">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
            Filter
            <span x-show="selectedGenres.length" x-text="selectedGenres.length" class="ml-1.5 px-1.5 py-0.5 text-[10px] font-bold bg-[#4b76c4] text-white rounded-full"></span>
        </button>
        <button type="submit" class="steam-btn">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Search
        </button>
        @if(request('search') || request('genre'))
            <a href="{{ route('games.index') }}" class="steam-btn bg-red-600/80 text-white border-red-500 hover:bg-red-600 shadow-[0_0_10px_rgba(220,38,38,0.3)]">
                Clear
            </a>
        @endif
    </div>

    <div x-cloak x-show="filterOpen" class="fixed inset-0 z-50 flex items-center justify-center" @keydown.escape.window="filterOpen = false">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="filterOpen = false"></div>
        <div class="relative bg-[#0f1f30] border border-white/10 rounded-xl shadow-2xl p-6 w-full max-w-md mx-4 max-h-[80vh] overflow-y-auto">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-white">Filter by Genre</h3>
                <button type="button" @click="filterOpen = false" class="text-gray-500 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="flex flex-col gap-2">
                @foreach($genres as $g)
                <label class="flex items-center gap-3 px-3 py-2 rounded-lg bg-[#0b1b2b] border border-white/5 cursor-pointer hover:border-[#4b76c4]/40 transition-colors text-sm text-gray-300 has-[:checked]:border-[#4b76c4] has-[:checked]:bg-[#4b76c4]/10 has-[:checked]:text-white">
                    <input type="checkbox" name="genre[]" value="{{ $g }}" {{ in_array($g, (array) request('genre', [])) ? 'checked' : '' }} class="accent-[#4b76c4] rounded">
                    {{ $g }}
                </label>
                @endforeach
            </div>
            <div class="flex gap-3 mt-6">
                <button type="submit" class="steam-btn flex-1 justify-center" @click="filterOpen = false">
                    Apply Filters
                </button>
                <button type="button" @click="filterOpen = false" class="px-4 py-2 rounded-md bg-white/5 text-gray-400 hover:text-white border border-white/10 hover:border-white/20 transition-colors">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</form>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @forelse($games as $game)
    <a href="{{ route('games.show', $game) }}" class="steam-card block animate-fade-up opacity-0" style="animation-delay: {{ $loop->index * 50 }}ms">
        <div class="relative">
            @if($game->image)
                <div class="h-36 overflow-hidden bg-[#05111a] flex items-center justify-center">
                    <img src="{{ Storage::url('games/'.$game->image) }}" alt="{{ $game->title }}" class="w-full h-full object-contain transform group-hover:scale-110 transition duration-700">
                </div>
            @else
                <div class="h-36 bg-gradient-to-br from-[#202c40] to-[#2c3a52] flex items-center justify-center">
                    <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
            @endif
        </div>
        <div class="steam-card-body">
            <div class="flex flex-wrap gap-1.5 mb-2">
                @if($game->genre)
                    @foreach(explode(' ', $game->genre) as $tag)
                        <span class="genre-tag">{{ $tag }}</span>
                    @endforeach
                @endif
                @if(in_array($game->id, $ownedIds ?? []))
                    <span class="genre-tag bg-green-500/20 text-green-400 border-green-400/30">Owned</span>
                @endif
            </div>
            <h3 class="font-bold text-white text-sm truncate">{{ $game->title }}</h3>
            @if($game->developer)
                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $game->developer }}</p>
            @endif
            <div class="mt-3 flex items-center justify-between">
                <span class="price-tag">Rp {{ number_format($game->price, 0, ',', '.') }}</span>
                <form method="POST" action="{{ route('wishlist.toggle', $game) }}" class="inline">
                    @csrf
                    <button type="submit" onclick="event.stopPropagation()" class="p-1.5 rounded-full transition-colors {{ in_array($game->id, $wishlistIds ?? []) ? 'text-red-400' : 'text-slate-500 hover:text-red-300' }}">
                        <svg class="w-4 h-4" fill="{{ in_array($game->id, $wishlistIds ?? []) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </a>
    @empty
    <div class="col-span-full text-center py-16">
        <svg class="w-16 h-16 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
        <p class="text-slate-500 text-lg font-semibold">No games found</p>
        <p class="text-slate-600 text-sm mt-1">Try a different search or filter</p>
    </div>
    @endforelse
</div>

@if($games->hasPages())
    {{ $games->links('vendor.pagination.steam') }}
@endif
@endsection
