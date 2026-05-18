<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameDock - Your Ultimate Gaming Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Custom Scrollbar bergaya Steam */
        ::-webkit-scrollbar { width: 10px; }
        ::-webkit-scrollbar-track { background: #1b2536; }
        ::-webkit-scrollbar-thumb { background: #2c3a52; border-radius: 5px; border: 2px solid #1b2536; }
        ::-webkit-scrollbar-thumb:hover { background: #4b76c4; }

        /* CSS Animasi Marquee */
        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            width: 100%;
        }
        .marquee-content {
            display: inline-flex;
            animation: marquee 35s linear infinite; /* Diperlambat sedikit agar lebih jelas dibaca */
        }
        .marquee-content:hover {
            animation-play-state: paused;
        }
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        
        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
        .animate-float { animation: float 5s ease-in-out infinite; }
        
        @keyframes slideUpFade {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide-up { animation: slideUpFade 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards; }

        /* Tema Warna Khusus GameDock */
        .bg-gamedock-dark { background-color: #202c40; }
        .bg-gamedock-darker { background-color: #1b2536; }
        .bg-gamedock-blue { background-color: #4b76c4; }
        .hover-gamedock-blue:hover { background-color: #3b62a8; }
        .bg-gamedock-card { background-color: #2c3a52; }
    </style>
</head>
<body class="bg-gamedock-dark text-white font-sans antialiased overflow-x-hidden selection:bg-gamedock-blue selection:text-white">

    <nav x-data="{ mobileOpen: false }" class="sticky top-0 w-full flex items-center justify-between px-4 sm:px-8 py-4 border-b border-white/5 z-50 bg-gamedock-dark/85 backdrop-blur-xl shadow-lg transition-all duration-300">
        <div class="flex items-center gap-3 cursor-pointer group">
            <img src="{{ asset('images/gamedock-icon.svg') }}" alt="GameDock Icon" class="w-8 h-8 sm:w-10 sm:h-10 group-hover:scale-110 group-hover:rotate-3 transition-transform duration-300 drop-shadow-[0_0_8px_rgba(75,118,196,0.6)]">
            
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-white via-black-200 to-gray-400">
                GAMEDOCK
            </span>
        </div>

        <button @click="mobileOpen = !mobileOpen" class="sm:hidden text-slate-400 hover:text-white p-1.5 rounded-lg hover:bg-white/5 transition">
            <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="hidden sm:flex gap-5 items-center">
            <a href="/login" class="text-sm font-semibold text-gray-300 hover:text-white transition-colors duration-200">Sign In</a>
            <a href="/register" class="relative inline-flex items-center justify-center px-7 py-2.5 text-sm font-bold text-white bg-gamedock-blue rounded-md overflow-hidden group shadow-[0_0_15px_rgba(75,118,196,0.3)] hover:shadow-[0_0_25px_rgba(75,118,196,0.6)] transition-all duration-300">
                <span class="absolute w-0 h-0 transition-all duration-500 ease-out bg-white rounded-full group-hover:w-56 group-hover:h-56 opacity-10"></span>
                <span class="relative">Sign Up</span>
            </a>
        </div>

        <div x-show="mobileOpen" x-transition class="absolute top-full left-0 right-0 bg-gamedock-dark border-b border-white/10 px-4 py-4 flex flex-col gap-3 sm:hidden" style="display: none;">
            <a href="/login" class="text-sm font-semibold text-gray-300 hover:text-white transition py-2">Sign In</a>
            <a href="/register" class="text-sm font-bold text-white bg-gamedock-blue rounded-md px-4 py-2.5 text-center">Sign Up</a>
        </div>
    </nav>

    <div class="bg-gamedock-darker/90 py-3 border-b border-white/5 flex justify-center z-40 relative overflow-x-auto">
        <ul class="flex gap-4 sm:gap-8 text-xs md:text-sm font-semibold text-gray-400 tracking-wide px-4 whitespace-nowrap">
            <li><a href="{{ route('landing') }}" class="hover:text-white hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.8)] transition">GameDock</a></li>
            <li><a href="{{ route('trending') }}" class="hover:text-white hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.8)] transition">New & Trending</a></li>
            <li><a href="{{ route('categories.index') }}" class="hover:text-white hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.8)] transition">Categories</a></li>
            <li><a href="{{ route('news.index') }}" class="hover:text-white hover:drop-shadow-[0_0_5px_rgba(255,255,255,0.8)] transition">News</a></li>
        </ul>
    </div>

    <section class="relative w-full min-h-[75vh] sm:min-h-[80vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center opacity-30 mix-blend-luminosity scale-105" 
            style="background-image: url('/images/heroBackImage_desktop.webp');">
        </div>
        
        <div class="absolute inset-0 bg-gradient-to-t from-gamedock-darker via-gamedock-dark/70 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-gamedock-darker via-transparent to-gamedock-darker opacity-90"></div>

        <div class="relative z-10 text-center px-4 max-w-4xl mx-auto mt-4 animate-slide-up">
            <span class="inline-block py-1 px-3 rounded bg-white/10 text-gamedock-blue font-bold text-xs uppercase tracking-widest mb-4 border border-gamedock-blue/30 shadow-[0_0_10px_rgba(75,118,196,0.2)]">
                Welcome to the Next Level
            </span>
            <h1 class="text-3xl sm:text-5xl md:text-7xl font-extrabold mb-6 drop-shadow-2xl tracking-tight text-white animate-float leading-tight">
                DISCOVER YOUR <br><span class="bg-clip-text text-transparent bg-gradient-to-r from-white via-blue-100 to-blue-300">NEXT GAME</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-300 mb-10 max-w-2xl mx-auto font-light leading-relaxed drop-shadow-md">
                Join with another million players. Discover thousands of exciting games, play with friends, and start your adventure on GameDock.
            </p>
            <a href="/catalogue" class="relative inline-flex items-center justify-center bg-gamedock-blue hover-gamedock-blue text-white font-bold text-sm sm:text-lg py-3 sm:py-4 px-8 sm:px-12 rounded-lg shadow-[0_0_20px_rgba(75,118,196,0.5)] transition-all transform hover:-translate-y-1 hover:shadow-[0_10px_30px_rgba(75,118,196,0.7)] overflow-hidden group">
                <span class="absolute inset-0 w-full h-full -mt-1 rounded-lg opacity-30 bg-gradient-to-b from-transparent via-transparent to-black"></span>
                <span class="relative">BROWSE CATALOGUE</span>
            </a>
        </div>
    </section>

    <section class="py-16 bg-gamedock-darker relative z-20 shadow-[0_-15px_30px_rgba(27,37,54,1)]">
        <div class="px-4 sm:px-8 lg:px-12 mb-8 flex flex-col gap-4 sm:flex-row sm:justify-between sm:items-end">
           <div>
               <h2 class="text-xl sm:text-2xl font-black tracking-widest uppercase text-white drop-shadow-md">Featured & Recommended</h2>
               <div class="h-1 w-24 bg-gamedock-blue mt-2 rounded-full shadow-[0_0_10px_rgba(75,118,196,0.8)]"></div>
           </div>
           <a href="/catalogue" class="text-sm font-semibold text-gamedock-blue hover:text-white transition flex items-center gap-1 group">
               See All <span class="group-hover:translate-x-1 transition-transform">-&gt;</span>
           </a>
        </div>
        
        <div class="marquee-container py-4">
            <div class="marquee-content gap-6 px-6">
                @foreach($marqueeGames as $game)
                <a href="{{ route('games.show', $game->slug) }}" class="w-80 h-48 bg-gamedock-card rounded-lg shadow-xl flex-shrink-0 flex items-end p-0 relative group cursor-pointer border border-transparent hover:border-gamedock-blue transition-all duration-300 overflow-hidden hover:shadow-[0_0_25px_rgba(75,118,196,0.3)]">
                    @if($game->image)
                    <div class="absolute inset-0 bg-contain bg-center opacity-80 group-hover:scale-110 group-hover:opacity-100 transition-all duration-700" style="background-image: url('{{ asset('storage/games/'.$game->image) }}');"></div>
                    @else
                    <div class="absolute inset-0 bg-slate-700 opacity-80 group-hover:scale-110 transition-all duration-700"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0b1b2b] via-[#0b1b2b]/60 to-transparent opacity-90 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative z-10 w-full p-5 flex flex-col justify-end h-full">
                        <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <span class="font-black text-xl truncate mb-2 block text-white drop-shadow-md">{{ $game->title }}</span>
                            <div class="flex justify-between items-center w-full mt-2">
                                <div class="flex gap-2">
                                    @if($game->genre)
                                        @foreach(explode(' ', $game->genre) as $tag)
                                            <span class="text-[10px] font-bold text-gray-200 bg-black/50 border border-white/10 px-2 py-1 rounded shadow-sm backdrop-blur-md">{{ $tag }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <span class="text-sm font-black text-gamedock-blue bg-white/10 px-2 py-1 rounded">Rp {{ number_format($game->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

                @foreach($marqueeGames as $game)
                <a href="{{ route('games.show', $game->slug) }}" class="w-80 h-48 bg-gamedock-card rounded-lg shadow-xl flex-shrink-0 flex items-end p-0 relative group cursor-pointer border border-transparent hover:border-gamedock-blue transition-all duration-300 overflow-hidden hover:shadow-[0_0_25px_rgba(75,118,196,0.3)]">
                    @if($game->image)
                    <div class="absolute inset-0 bg-contain bg-center opacity-80 group-hover:scale-110 group-hover:opacity-100 transition-all duration-700" style="background-image: url('{{ asset('storage/games/'.$game->image) }}');"></div>
                    @else
                    <div class="absolute inset-0 bg-slate-700 opacity-80 group-hover:scale-110 transition-all duration-700"></div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0b1b2b] via-[#0b1b2b]/60 to-transparent opacity-90 group-hover:opacity-100 transition duration-300"></div>
                    <div class="relative z-10 w-full p-5 flex flex-col justify-end h-full">
                        <div class="transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <span class="font-black text-xl truncate mb-2 block text-white drop-shadow-md">{{ $game->title }}</span>
                            <div class="flex justify-between items-center w-full mt-2">
                                <div class="flex gap-2">
                                    @if($game->genre)
                                        @foreach(explode(' ', $game->genre) as $tag)
                                            <span class="text-[10px] font-bold text-gray-200 bg-black/50 border border-white/10 px-2 py-1 rounded shadow-sm backdrop-blur-md">{{ $tag }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <span class="text-sm font-black text-gamedock-blue bg-white/10 px-2 py-1 rounded">Rp {{ number_format($game->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('components.site-footer')

</body>
</html>
