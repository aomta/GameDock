@extends('layouts.dashboard')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-black text-white">GAMES</h1>
        <p class="text-sm text-slate-400">Manage your game catalogue</p>
    </div>
    <a href="{{ route('admin.games.create') }}" class="steam-btn">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Game
    </a>
</div>

@if(session('status'))
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300">
        {{ session('status') }}
    </div>
@endif

<div class="dark-panel overflow-hidden">
    <div class="overflow-x-auto">
        <table class="steam-table">
            <thead>
                <tr>
                    <th class="w-16">#</th>
                    <th>Game</th>
                    <th>Genre</th>
                    <th>Developer</th>
                    <th>Price</th>
                    <th class="w-24 text-center">Status</th>
                    <th class="w-36 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($games as $game)
                <tr>
                    <td class="text-slate-500 font-mono text-xs">{{ $game->id }}</td>
                    <td>
                        <div class="flex items-center gap-3">
                            @if($game->image)
                                <img src="{{ Storage::url('games/'.$game->image) }}" alt="" class="h-10 w-14 rounded object-cover bg-slate-700">
                            @else
                                <div class="h-10 w-14 rounded bg-[#202c40] flex items-center justify-center">
                                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold text-white text-sm">{{ $game->title }}</p>
                                <p class="text-xs text-slate-500 truncate max-w-[200px]">{{ Str::limit($game->description, 50) }}</p>
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($game->genre)
                            <div class="flex flex-wrap gap-1">
                                @foreach(explode(' ', $game->genre) as $tag)
                                    <span class="genre-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-600">-</span>
                        @endif
                    </td>
                    <td class="text-slate-400 text-xs">{{ $game->developer ?? '-' }}</td>
                    <td><span class="price-tag">Rp {{ number_format($game->price, 0, ',', '.') }}</span></td>
                    <td class="text-center">
                        @if($game->active)
                            <span class="status-completed">Active</span>
                        @else
                            <span class="status-cancelled">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.games.edit', $game) }}" class="steam-btn-sm" title="Edit">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Edit
                            </a>
                            <button onclick="showModal('game-del-modal-{{ $game->id }}')" class="steam-btn-danger" title="Delete">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            @include('components.confirm-modal', [
                                'id' => 'game-del-modal-' . $game->id,
                                'title' => 'Delete Game?',
                                'message' => 'Delete "' . $game->title . '" permanently? This action cannot be undone.',
                                'action' => route('admin.games.destroy', $game),
                                'method' => 'DELETE',
                                'type' => 'danger',
                                'confirmText' => 'Delete Game'
                            ])
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-12 text-slate-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        No games yet. <a href="{{ route('admin.games.create') }}" class="text-[#4b76c4] hover:underline">Add your first game</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
