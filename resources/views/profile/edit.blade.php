@extends('layouts.dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-black text-white">PROFILE SETTINGS</h1>
    <p class="text-sm text-slate-400">Manage your account information</p>
</div>

@if(session('status') === 'profile-updated')
    <div class="mb-4 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300 flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        Profile updated successfully.
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="dark-panel">
        <div class="dark-panel-header">
            <h2 class="text-lg font-bold text-white">Profile Information</h2>
            <p class="text-xs text-slate-400 mt-0.5">Update your account details</p>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" class="p-6 space-y-5">
            @csrf @method('PATCH')

            <div class="flex items-center gap-4 mb-2">
                <div class="h-16 w-16 rounded-full border-2 border-[#4b76c4] overflow-hidden">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4b76c4&color=fff&size=64" alt="" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-sm font-bold text-white">{{ $user->name }}</p>
                    <span class="genre-tag {{ $user->isAdmin() ? 'bg-[#4b76c4]/20 text-[#4b76c4] border-[#4b76c4]/30' : '' }}">{{ ucfirst($user->role) }}</span>
                </div>
            </div>

            <div>
                <label class="steam-label">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="steam-input @error('name') border-red-400/60 @enderror">
                @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="steam-label">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="steam-input @error('email') border-red-400/60 @enderror">
                @error('email')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="steam-label">Country</label>
                <input type="text" name="country" value="{{ old('country', $user->country) }}" class="steam-input" placeholder="e.g. Indonesia">
                @error('country')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                <button type="submit" class="steam-btn">Save Changes</button>
            </div>
        </form>
    </div>

    <div class="space-y-6">
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-white">Update Password</h2>
                <p class="text-xs text-slate-400 mt-0.5">Ensure your account uses a long, random password</p>
            </div>
            <form action="{{ route('password.update') }}" method="POST" class="p-6 space-y-5">
                @csrf @method('PUT')

                <div>
                    <label class="steam-label">Current Password</label>
                    <input type="password" name="current_password" required class="steam-input @error('current_password', 'updatePassword') border-red-400/60 @enderror">
                    @error('current_password', 'updatePassword')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="steam-label">New Password</label>
                    <input type="password" name="password" required class="steam-input @error('password', 'updatePassword') border-red-400/60 @enderror">
                    @error('password', 'updatePassword')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="steam-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="steam-input">
                </div>

                @if(session('status') === 'password-updated')
                    <p class="text-sm text-green-400">Password updated.</p>
                @endif

                <div class="flex items-center gap-3 pt-4 border-t border-white/10">
                    <button type="submit" class="steam-btn">Update Password</button>
                </div>
            </form>
        </div>

        @unless($user->isAdmin())
        <div class="dark-panel">
            <div class="dark-panel-header">
                <h2 class="text-lg font-bold text-red-400">Delete Account</h2>
                <p class="text-xs text-slate-400 mt-0.5">Permanently delete your account and data</p>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST" id="delete-account-form" class="p-6 space-y-5">
                @csrf @method('DELETE')

                <p class="text-sm text-slate-400">Once your account is deleted, all of its resources and data will be permanently deleted. Enter your password to confirm.</p>

                <div>
                    <label class="steam-label">Password</label>
                    <input type="password" name="password" required class="steam-input @error('password', 'userDeletion') border-red-400/60 @enderror" placeholder="Enter your password">
                    @error('password', 'userDeletion')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" onclick="showDeleteConfirm()" class="steam-btn-danger">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="delete-account-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="delete-account-modal-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full bg-red-500/20 text-red-400 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">Delete Account?</h3>
                <p class="text-sm text-slate-400 mt-1">This action cannot be undone. All your data, purchases, and games will be permanently removed.</p>
            </div>
        </div>
        <div class="flex gap-3 justify-end">
            <button onclick="closeModal('delete-account-modal')" class="steam-btn-secondary">Cancel</button>
            <button onclick="document.querySelector('#delete-account-form').submit()" class="steam-btn-danger">Yes, Delete My Account</button>
        </div>
    </div>
</div>

<script>
function showDeleteConfirm() {
    showModal('delete-account-modal');
}
document.addEventListener('DOMContentLoaded', function() {
    @if($errors->userDeletion->any())
        showDeleteConfirm();
    @endif
});
</script>
        @else
        <div class="dark-panel p-6 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <p class="text-sm text-slate-400">Admin accounts cannot be deleted for security reasons.</p>
        </div>
        @endif
    </div>
</div>
@endsection
