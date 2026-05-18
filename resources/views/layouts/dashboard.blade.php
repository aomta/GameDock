<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - GameDock</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#05111a] text-white font-sans antialiased" x-data="{ sidebarOpen: false }">

    <div class="relative flex min-h-screen overflow-hidden">
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-30 bg-black/60 lg:hidden"
        style="display: none;"
    ></div>
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-40 w-64 bg-[#0b1b2b] border-r border-white/10 flex flex-col min-h-screen shadow-2xl transform transition-transform duration-300 lg:static lg:z-auto lg:w-56 lg:translate-x-0 xl:w-64"
    >
        <div class="h-16 flex items-center justify-center border-b border-white/10 px-6">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/gamedock-icon.svg') }}" alt="GameDock" class="h-7 w-7 object-contain drop-shadow-[0_0_8px_rgba(75,118,196,0.6)] group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300">
                <span class="text-lg font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-white via-white/70 to-gray-400">GAMEDOCK</span>
            </a>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">Admin Panel</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('admin.dashboard')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.games.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('admin.games.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
                    Manage Games
                </a>
                <a href="{{ route('admin.transactions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('admin.transactions.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Transactions
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('admin.users.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Users
                </a>
            @else
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest px-3 mb-2">Menu</p>

                <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('user.dashboard')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('games.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('games.index')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="6" x2="10" y1="11" y2="11"/><line x1="8" x2="8" y1="9" y2="13"/><line x1="15" x2="15.01" y1="12" y2="12"/><line x1="18" x2="18.01" y1="10" y2="10"/><path d="M17.32 5H6.68a4 4 0 0 0-3.978 3.59c-.006.052-.01.101-.017.152C2.604 9.416 2 14.456 2 16a3 3 0 0 0 3 3c1 0 1.5-.5 2-1l1.414-1.414A2 2 0 0 1 9.828 16h4.344a2 2 0 0 1 1.414.586L17 18c.5.5 1 1 2 1a3 3 0 0 0 3-3c0-1.545-.604-6.584-.685-7.258-.007-.05-.011-.1-.017-.151A4 4 0 0 0 17.32 5z"/></svg>
                    Catalogue
                </a>
                <a href="{{ route('cart.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('cart.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Cart
                </a>
                <a href="{{ route('user.my-games') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('user.my-games')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg>
                    My Games
                </a>
                <a href="{{ route('user.wishlist') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('user.wishlist')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    Wishlist
                </a>
                <a href="{{ route('user.purchase-history.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('user.purchase-history.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                    Purchase History
                </a>
            @endif

            <div class="pt-4 mt-4 border-t border-white/10">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold transition-all @if(request()->routeIs('profile.*')) bg-[#4b76c4]/20 text-[#4b76c4] border border-[#4b76c4]/30 @else text-slate-400 hover:bg-white/5 hover:text-white @endif">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
            </div>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <header class="h-16 bg-[#0b1b2b]/80 backdrop-blur-md border-b border-white/10 flex items-center gap-3 px-4 sm:px-6 flex-shrink-0">
            <button @click="sidebarOpen = true" class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 bg-[#202c40] text-slate-300 transition hover:bg-white/5 hover:text-white lg:hidden" aria-label="Open sidebar">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <form method="GET" action="{{ route('games.index') }}" class="relative w-full max-w-[220px] sm:max-w-[280px] lg:max-w-[320px]">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </span>
                <input type="text" name="search" placeholder="Search games..." class="w-full bg-[#202c40] border border-white/10 text-white rounded-lg py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-[#4b76c4] focus:ring-1 focus:ring-[#4b76c4] transition-all placeholder:text-slate-500">
            </form>
            <div x-data="{ open: false }" @click.outside="open = false" class="relative ml-auto">
                <div @click="open = !open" class="flex items-center gap-3 cursor-pointer">
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-[#4b76c4] font-semibold capitalize">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="h-9 w-9 rounded-full border-2 border-[#4b76c4] overflow-hidden flex-shrink-0">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=4b76c4&color=fff" alt="Avatar" class="w-full h-full object-cover">
                    </div>
                </div>
                <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="absolute right-0 top-full mt-2 w-48 bg-[#0f1f30] border border-white/10 rounded-lg shadow-2xl py-1.5 z-50" style="display: none;">
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-300 hover:text-white hover:bg-white/5 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Manage Account
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-white/5 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

    <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8 pb-24">
        @yield('content')
    </main>

    <footer class="bg-[#0b1b2b] border-t border-white/10 px-4 sm:px-6 py-4">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="text-[10px] text-slate-500">&copy; {{ date('Y') }} GameDock. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="{{ route('landing') }}" class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors">Home</a>
                <a href="{{ route('catalogue') }}" class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors">Catalogue</a>
                <a href="{{ route('news.index') }}" class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors">News</a>
            </div>
        </div>
    </footer>
</div>

<script>
function showModal(id) {
    var modal = document.getElementById(id);
    var content = document.getElementById(id + '-content');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(function() {
        modal.style.opacity = '1';
        content.classList.remove('scale-95', 'translate-y-4');
        content.classList.add('scale-100', 'translate-y-0');
    }, 10);
}
function closeModal(id) {
    var modal = document.getElementById(id);
    var content = document.getElementById(id + '-content');
    modal.style.opacity = '0';
    content.classList.remove('scale-100', 'translate-y-0');
    content.classList.add('scale-95', 'translate-y-4');
    setTimeout(function() {
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        content.classList.remove('scale-100', 'translate-y-0');
        content.classList.add('scale-95', 'translate-y-4');
    }, 200);
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id$="-modal"]').forEach(function(modal) {
            if (!modal.classList.contains('hidden')) closeModal(modal.id);
        });
    }
});
</script>

</body>
</html>
