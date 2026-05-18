@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">USERS</h1>
    <p class="text-sm text-slate-400">Manage user accounts and roles</p>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Country</th>
                    <th class="text-center w-28">Role</th>
                    <th class="w-24 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full border border-[#4b76c4] overflow-hidden flex-shrink-0">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4b76c4&color=fff&size=32" alt="" class="w-full h-full object-cover">
                            </div>
                            <span class="text-sm font-semibold text-white">{{ $user->name }}</span>
                        </div>
                    </td>
                    <td class="text-sm text-slate-400">{{ $user->email }}</td>
                    <td class="text-sm text-slate-400">{{ $user->country ?? '-' }}</td>
                    <td class="text-center">
                        <span class="genre-tag {{ $user->isAdmin() ? 'bg-[#4b76c4]/20 text-[#4b76c4] border-[#4b76c4]/30' : '' }}">{{ ucfirst($user->role) }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.edit', $user) }}" class="steam-btn-sm">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
