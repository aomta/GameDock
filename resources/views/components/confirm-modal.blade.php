<div id="{{ $id ?? 'confirm-modal' }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#0b1b2b]" style="opacity: 0; transition: opacity 0.2s;">
    <div class="bg-[#0f1f30] border border-white/10 rounded-xl p-6 max-w-md w-full mx-4 transform transition-all scale-95 translate-y-4" id="{{ $id ?? 'confirm-modal' }}-content">
        <div class="flex items-start gap-4 mb-5">
            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $type === 'danger' ? 'bg-red-500/20 text-red-400' : 'bg-blue-500/20 text-blue-400' }}">
                @if($type === 'danger')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4.5c-.77-.833-2.694-.833-3.464 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                @endif
            </div>
            <div>
                <h3 class="text-lg font-bold text-white">{{ $title }}</h3>
                <p class="text-sm text-slate-400 mt-1">{{ $message }}</p>
            </div>
        </div>
        <form action="{{ $action }}" method="POST" id="{{ $id }}-form">
            @csrf
            @if($method && strtoupper($method) !== 'POST')
                @method($method)
            @endif
            @if(!empty($showPassword))
            <div class="mb-5">
                <label class="steam-label">Enter your password to confirm</label>
                <input type="password" name="password" required class="steam-input" placeholder="Your password">
            </div>
            @endif
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeModal('{{ $id ?? 'confirm-modal' }}')" class="steam-btn-secondary">Cancel</button>
                <button type="submit" class="{{ $type === 'danger' ? 'steam-btn-danger' : 'steam-btn' }}">{{ $confirmText ?? 'Confirm' }}</button>
            </div>
        </form>
    </div>
</div>
