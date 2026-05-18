@extends('layouts.dashboard')

@section('content')
@if(session('status'))
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300">
        {{ session('status') }}
    </div>
@endif

<div class="dark-panel overflow-hidden">
    <div class="flex flex-col lg:flex-row">
        <div class="lg:w-2/5">
            @if($game->image)
                <div class="w-full h-72 lg:h-full lg:max-h-[500px] bg-[#05111a] flex items-center justify-center overflow-hidden">
                    <img src="{{ Storage::url('games/'.$game->image) }}" alt="{{ $game->title }}" class="w-full h-full object-contain">
                </div>
            @else
                <div class="w-full h-72 lg:h-full bg-gradient-to-br from-[#202c40] to-[#2c3a52] flex items-center justify-center">
                    <svg class="w-24 h-24 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                </div>
            @endif
        </div>

        <div class="lg:w-3/5 p-6 lg:p-8">
            @if($game->genre)
                <div class="flex flex-wrap gap-1.5 mb-3">
                    @foreach(explode(' ', $game->genre) as $tag)
                        <span class="genre-tag">{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            <h1 class="text-3xl font-black text-white mt-2">{{ $game->title }}</h1>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Developer</p>
                    <p class="text-sm text-slate-300 mt-0.5">{{ $game->developer ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Publisher</p>
                    <p class="text-sm text-slate-300 mt-0.5">{{ $game->publisher ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Release Date</p>
                    <p class="text-sm text-slate-300 mt-0.5">{{ $game->release_date?->format('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-white/10">
                <p class="text-sm text-slate-400 leading-relaxed">{{ $game->description }}</p>
            </div>

            <div class="mt-8 flex items-center justify-between flex-wrap gap-4">
                <div>
                    <p class="text-xs text-slate-500 uppercase font-bold tracking-wider">Price</p>
                    <p class="text-3xl font-black text-[#4b76c4] mt-1">Rp {{ number_format($game->price, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @if($ownsGame)
                        <div class="inline-flex items-center gap-2 rounded-lg bg-green-500/15 border border-green-400/30 px-5 py-2.5 text-sm font-bold text-green-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            Already Owned
                        </div>
                    @else
                        <form action="{{ route('cart.store', $game) }}" method="POST">
                            @csrf
                            <button type="submit" class="steam-btn">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                                Add to Cart
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('wishlist.toggle', $game) }}">
                        @csrf
                        <button type="submit" class="p-2.5 rounded-lg bg-white/5 border border-white/10 hover:border-red-400/40 transition-colors {{ $onWishlist ? 'text-red-400 bg-red-500/10 border-red-400/30' : 'text-slate-400 hover:text-red-300' }}">
                            <svg class="w-5 h-5" fill="{{ $onWishlist ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mt-6">
    <a href="{{ route('games.index') }}" class="steam-btn-secondary">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left-from-line-icon lucide-arrow-left-from-line"><path d="m9 6-6 6 6 6"/><path d="M3 12h14"/><path d="M21 19V5"/></svg>
        Back to Catalogue
    </a>
</div>

@if($game->os_minimum || $game->processor_minimum || $game->memory_minimum || $game->graphics_minimum || $game->os_recommended || $game->processor_recommended || $game->memory_recommended || $game->graphics_recommended)
<div class="dark-panel mt-6 overflow-hidden">
    <div class="dark-panel-header flex items-center gap-2">
        <svg class="w-5 h-5 text-[#4b76c4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <h2 class="text-lg font-bold text-white">System Requirements</h2>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 divide-y md:divide-y-0 md:divide-x divide-white/10">
        <div class="p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                <h3 class="text-sm font-black text-amber-400 uppercase tracking-wider">Minimum</h3>
            </div>
            <div class="space-y-3">
                @if($game->os_minimum)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">OS</span>
                    <span class="text-sm text-slate-300">{{ $game->os_minimum }}</span>
                </div>
                @endif
                @if($game->processor_minimum)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Processor</span>
                    <span class="text-sm text-slate-300">{{ $game->processor_minimum }}</span>
                </div>
                @endif
                @if($game->memory_minimum)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Memory</span>
                    <span class="text-sm text-slate-300">{{ $game->memory_minimum }}</span>
                </div>
                @endif
                @if($game->graphics_minimum)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Graphics</span>
                    <span class="text-sm text-slate-300">{{ $game->graphics_minimum }}</span>
                </div>
                @endif
                @if($game->storage_minimum)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Storage</span>
                    <span class="text-sm text-slate-300">{{ $game->storage_minimum }}</span>
                </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            <div class="flex items-center gap-2 mb-4">
                <span class="w-2 h-2 rounded-full bg-green-400"></span>
                <h3 class="text-sm font-black text-green-400 uppercase tracking-wider">Recommended</h3>
            </div>
            <div class="space-y-3">
                @if($game->os_recommended)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">OS</span>
                    <span class="text-sm text-slate-300">{{ $game->os_recommended }}</span>
                </div>
                @endif
                @if($game->processor_recommended)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Processor</span>
                    <span class="text-sm text-slate-300">{{ $game->processor_recommended }}</span>
                </div>
                @endif
                @if($game->memory_recommended)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Memory</span>
                    <span class="text-sm text-slate-300">{{ $game->memory_recommended }}</span>
                </div>
                @endif
                @if($game->graphics_recommended)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Graphics</span>
                    <span class="text-sm text-slate-300">{{ $game->graphics_recommended }}</span>
                </div>
                @endif
                @if($game->storage_recommended)
                <div class="flex gap-3">
                    <span class="text-xs font-bold text-slate-500 uppercase w-24 flex-shrink-0 pt-0.5">Storage</span>
                    <span class="text-sm text-slate-300">{{ $game->storage_recommended }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
