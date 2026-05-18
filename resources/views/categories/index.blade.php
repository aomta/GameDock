<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDock Categories - Browse by Genre</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #1b2536; }
        ::-webkit-scrollbar-thumb { background: #2c3a52; border-radius: 5px; border: 2px solid #1b2536; }
        ::-webkit-scrollbar-thumb:hover { background: #4b76c4; }
        .bg-gamedock-dark { background-color: #202c40; }
        .bg-gamedock-darker { background-color: #1b2536; }
        .bg-gamedock-blue { background-color: #4b76c4; }
        .hover-gamedock-blue:hover { background-color: #3b62a8; }
        .bg-gamedock-card { background-color: #2c3a52; }
    </style>
</head>
<body class="bg-gamedock-dark text-white font-sans antialiased overflow-x-hidden selection:bg-gamedock-blue selection:text-white">

    <nav x-data="{ mobileOpen: false }" class="sticky top-0 w-full flex items-center justify-between px-4 sm:px-8 py-4 border-b border-white/5 z-50 bg-gamedock-dark/85 backdrop-blur-xl shadow-lg">
        <div class="flex items-center gap-3">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/gamedock-icon.svg') }}" alt="GameDock Icon" class="w-8 h-8 sm:w-10 sm:h-10 group-hover:scale-110 transition-transform duration-300 drop-shadow-[0_0_8px_rgba(75,118,196,0.6)]">
                <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-white to-gray-400">GAMEDOCK</span>
            </a>
        </div>

        <button @click="mobileOpen = !mobileOpen" class="sm:hidden text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-white/5 transition">
            <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="hidden sm:flex gap-5 items-center">
            <a href="{{ route('landing') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition-colors duration-200">Home</a>
            <a href="/login" class="text-sm font-semibold text-gray-300 hover:text-white transition-colors duration-200">Sign In</a>
            <a href="/register" class="relative inline-flex items-center justify-center px-7 py-2.5 text-sm font-bold text-white bg-gamedock-blue rounded-md shadow-[0_0_15px_rgba(75,118,196,0.3)] hover:shadow-[0_0_25px_rgba(75,118,196,0.6)] transition-all duration-300">
                <span class="relative">Sign Up</span>
            </a>
        </div>

        <div x-show="mobileOpen" x-transition class="absolute top-full left-0 right-0 bg-gamedock-dark border-b border-white/10 px-4 py-4 flex flex-col gap-3 sm:hidden z-50" style="display: none;">
            <a href="{{ route('landing') }}" class="text-sm font-semibold text-gray-300 hover:text-white transition py-2">Home</a>
            <a href="/login" class="text-sm font-semibold text-gray-300 hover:text-white transition py-2">Sign In</a>
            <a href="/register" class="text-sm font-bold text-white bg-gamedock-blue rounded-md px-4 py-2.5 text-center">Sign Up</a>
        </div>
    </nav>

    <div class="bg-gamedock-darker/90 py-3 border-b border-white/5 flex justify-center overflow-x-auto">
        <ul class="flex gap-4 sm:gap-8 text-xs md:text-sm font-semibold text-gray-400 tracking-wide px-4 whitespace-nowrap">
            <li><a href="{{ route('landing') }}" class="hover:text-white transition">GameDock</a></li>
            <li><a href="{{ route('trending') }}" class="hover:text-white transition">New & Trending</a></li>
            <li><a href="{{ route('categories.index') }}" class="text-white hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.8)] transition">Categories</a></li>
            <li><a href="{{ route('news.index') }}" class="hover:text-white transition">News</a></li>
        </ul>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12">
        <div class="mb-10">
            <h1 class="text-3xl sm:text-4xl font-black tracking-widest uppercase text-white drop-shadow-md">Browse by Category</h1>
            <div class="h-1 w-32 bg-gamedock-blue mt-3 rounded-full shadow-[0_0_10px_rgba(75,118,196,0.8)]"></div>
            <p class="mt-4 text-gray-400 text-lg">Find games that match your favorite genres.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
            <a href="{{ $category['url'] }}" class="bg-gamedock-card rounded-xl p-6 border border-white/5 hover:border-gamedock-blue/50 transition-all duration-300 group text-center shadow-lg hover:shadow-[0_0_20px_rgba(75,118,196,0.2)] hover:-translate-y-1">
                <div class="w-16 h-16 mx-auto mb-4 bg-gamedock-blue/20 rounded-full flex items-center justify-center group-hover:bg-gamedock-blue/30 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gamedock-blue"><rect x="2" y="6" width="20" height="12" rx="2"/><path d="M6 12h4m-2-2v4m9-2h.01M17 12h.01"/></svg>
                </div>
                <h3 class="text-lg font-bold uppercase tracking-wide group-hover:text-gamedock-blue transition-colors truncate">{{ $category['name'] }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ $category['count'] }} {{ Str::plural('game', $category['count']) }}</p>
            </a>
            @endforeach
        </div>
    </main>

    @include('components.site-footer')

</body>
</html>
