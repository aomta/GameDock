@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">EDIT GAME</h1>
    <p class="text-sm text-slate-400">Update details for <span class="text-[#4b76c4] font-semibold">{{ $game->title }}</span></p>
</div>

<div class="dark-panel max-w-3xl">
    <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="steam-label">Game Title <span class="text-red-400">*</span></label>
                <input type="text" name="title" value="{{ old('title', $game->title) }}" required class="steam-input @error('title') border-red-400/60 @enderror">
                @error('title')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="steam-label">Genre</label>
                <input type="text" name="genre" value="{{ old('genre', $game->genre) }}" class="steam-input">
                @error('genre')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="steam-label">Developer</label>
                <input type="text" name="developer" value="{{ old('developer', $game->developer) }}" class="steam-input">
                @error('developer')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="steam-label">Publisher</label>
                <input type="text" name="publisher" value="{{ old('publisher', $game->publisher) }}" class="steam-input">
                @error('publisher')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label class="steam-label">Price (IDR) <span class="text-red-400">*</span></label>
                <input type="number" name="price" value="{{ old('price', $game->price) }}" required min="0" class="steam-input @error('price') border-red-400/60 @enderror">
                @error('price')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="steam-label">Release Date</label>
                <input type="date" name="release_date" value="{{ old('release_date', $game->release_date?->format('Y-m-d')) }}" class="steam-input">
                @error('release_date')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="steam-label">Description <span class="text-red-400">*</span></label>
            <textarea name="description" required class="steam-textarea @error('description') border-red-400/60 @enderror" rows="4">{{ old('description', $game->description) }}</textarea>
            @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="steam-label">Cover Image</label>
            @if($game->image)
                <div class="mb-3">
                    <img src="{{ Storage::url('games/'.$game->image) }}" alt="Current" class="h-32 w-56 rounded-lg object-cover border border-white/10">
                    <p class="text-xs text-slate-500 mt-1">Current cover image</p>
                </div>
            @endif
            <input type="file" name="image" accept="image/*" class="steam-input file:mr-4 file:rounded-md file:border-0 file:bg-[#4b76c4]/20 file:px-3 file:py-1 file:text-sm file:font-semibold file:text-[#4b76c4] hover:file:bg-[#4b76c4]/30">
            @error('image')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="pt-4 border-t border-white/10">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#4b76c4]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                System Requirements
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="steam-label text-amber-400">Minimum — OS</label>
                    <input type="text" name="os_minimum" value="{{ old('os_minimum', $game->os_minimum) }}" class="steam-input" placeholder="e.g. Windows 10 64-bit">
                </div>
                <div>
                    <label class="steam-label text-green-400">Recommended — OS</label>
                    <input type="text" name="os_recommended" value="{{ old('os_recommended', $game->os_recommended) }}" class="steam-input" placeholder="e.g. Windows 11 64-bit">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="steam-label text-amber-400">Minimum — Processor</label>
                    <input type="text" name="processor_minimum" value="{{ old('processor_minimum', $game->processor_minimum) }}" class="steam-input" placeholder="e.g. Intel Core i5-8400">
                </div>
                <div>
                    <label class="steam-label text-green-400">Recommended — Processor</label>
                    <input type="text" name="processor_recommended" value="{{ old('processor_recommended', $game->processor_recommended) }}" class="steam-input" placeholder="e.g. Intel Core i7-10700">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="steam-label text-amber-400">Minimum — Memory</label>
                    <input type="text" name="memory_minimum" value="{{ old('memory_minimum', $game->memory_minimum) }}" class="steam-input" placeholder="e.g. 8 GB RAM">
                </div>
                <div>
                    <label class="steam-label text-green-400">Recommended — Memory</label>
                    <input type="text" name="memory_recommended" value="{{ old('memory_recommended', $game->memory_recommended) }}" class="steam-input" placeholder="e.g. 16 GB RAM">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                <div>
                    <label class="steam-label text-amber-400">Minimum — Graphics</label>
                    <input type="text" name="graphics_minimum" value="{{ old('graphics_minimum', $game->graphics_minimum) }}" class="steam-input" placeholder="e.g. NVIDIA GTX 1060 6GB">
                </div>
                <div>
                    <label class="steam-label text-green-400">Recommended — Graphics</label>
                    <input type="text" name="graphics_recommended" value="{{ old('graphics_recommended', $game->graphics_recommended) }}" class="steam-input" placeholder="e.g. NVIDIA RTX 2070">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="steam-label text-amber-400">Minimum — Storage</label>
                    <input type="text" name="storage_minimum" value="{{ old('storage_minimum', $game->storage_minimum) }}" class="steam-input" placeholder="e.g. 50 GB available space">
                </div>
                <div>
                    <label class="steam-label text-green-400">Recommended — Storage</label>
                    <input type="text" name="storage_recommended" value="{{ old('storage_recommended', $game->storage_recommended) }}" class="steam-input" placeholder="e.g. 50 GB SSD">
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="hidden" name="active" value="0">
                <input type="checkbox" name="active" value="1" {{ old('active', $game->active) ? 'checked' : '' }} class="sr-only peer">
                <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#4b76c4]"></div>
            </label>
            <span class="text-sm font-semibold text-slate-300">Active</span>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
            <button type="submit" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Update Game
            </button>
            <a href="{{ route('admin.games.index') }}" class="steam-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
