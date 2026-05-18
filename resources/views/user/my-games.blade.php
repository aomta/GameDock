@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">MY GAMES</h1>
    <p class="text-sm text-slate-400">Games you own from approved purchases</p>
</div>

@if($games->count())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    @foreach($games as $game)
    <a href="{{ route('games.show', $game->slug) }}" class="steam-card block">
        @if($game->image)
            <div class="relative h-36 overflow-hidden bg-[#05111a] flex items-center justify-center">
                <img src="{{ Storage::url('games/'.$game->image) }}" alt="{{ $game->title }}" class="w-full h-full object-contain">
            </div>
        @else
            <div class="h-36 bg-gradient-to-br from-[#202c40] to-[#2c3a52] flex items-center justify-center">
                <svg class="w-16 h-16 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
            </div>
        @endif
        <div class="steam-card-body">
            <div class="flex flex-wrap gap-1.5 mb-2">
                @if($game->genre)
                    @foreach(explode(' ', $game->genre) as $tag)
                        <span class="genre-tag">{{ $tag }}</span>
                    @endforeach
                @endif
                <span class="genre-tag bg-green-500/20 text-green-400 border-green-400/30">Owned</span>
            </div>
            <h3 class="font-bold text-white text-sm truncate">{{ $game->title }}</h3>
            @if($game->developer)
                <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $game->developer }}</p>
            @endif
            <div class="mt-3 flex items-center justify-between">
                <span class="text-xs text-slate-500">Purchased {{ \Carbon\Carbon::parse($game->purchased_at)->format('d M Y') }}</span>
            </div>
        </div>
    </a>
    @endforeach
</div>
@else
<div class="dark-panel p-16 text-center">
    <svg class="w-20 h-20 mx-auto mb-4 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
    <p class="text-slate-400 text-lg font-semibold">No games yet</p>
    <p class="text-slate-600 text-sm mt-1 mb-6">Purchase games from the catalogue to see them here</p>
    <a href="{{ route('games.index') }}" class="steam-btn">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
        Browse Catalogue
    </a>
</div>
@endif
@endsection
