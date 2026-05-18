@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">EDIT USER</h1>
    <p class="text-sm text-slate-400">Update role for <span class="text-[#4b76c4] font-semibold">{{ $user->name }}</span></p>
</div>

<div class="dark-panel max-w-lg">
    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="steam-label">Name</label>
            <input type="text" value="{{ $user->name }}" disabled class="steam-input opacity-50 cursor-not-allowed">
        </div>

        <div>
            <label class="steam-label">Email</label>
            <input type="text" value="{{ $user->email }}" disabled class="steam-input opacity-50 cursor-not-allowed">
        </div>

        <div>
            <label class="steam-label">Role <span class="text-red-400">*</span></label>
            <select name="role" required class="steam-select">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            @error('role')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-white/10">
            <button type="submit" class="steam-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Update Role
            </button>
            <a href="{{ route('admin.users.index') }}" class="steam-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
