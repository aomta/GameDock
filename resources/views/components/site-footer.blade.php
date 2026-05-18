<footer class="bg-[#1b2536] border-t border-white/10 mt-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <img src="{{ asset('images/gamedock-icon.svg') }}" alt="GameDock" class="w-7 h-7 drop-shadow-[0_0_6px_rgba(75,118,196,0.5)]">
                    <span class="text-base font-black tracking-widest uppercase bg-clip-text text-transparent bg-gradient-to-b from-white to-gray-400">GAMEDOCK</span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed">Your ultimate destination for discovering and purchasing the best games.</p>
            </div>
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3">Store</h4>
                <ul class="space-y-1.5">
                    <li><a href="{{ route('catalogue') }}" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">Catalogue</a></li>
                    <li><a href="{{ route('trending') }}" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">New & Trending</a></li>
                    <li><a href="{{ route('categories.index') }}" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">Categories</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3">Company</h4>
                <ul class="space-y-1.5">
                    <li><a href="{{ route('news.index') }}" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">News</a></li>
                    <li><a href="#" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">About</a></li>
                    <li><a href="#" class="text-xs text-slate-400 hover:text-[#4b76c4] transition-colors">Support</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-3">Connect</h4>
                <div class="flex gap-3">
                    <a href="#" class="w-8 h-8 rounded-md bg-white/5 hover:bg-[#4b76c4]/20 flex items-center justify-center transition-colors group">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-instagram" viewBox="0 0 16 16">
                        <path d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.9 3.9 0 0 0-1.417.923A3.9 3.9 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.9 3.9 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.9 3.9 0 0 0-.923-1.417A3.9 3.9 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599s.453.546.598.92c.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.5 2.5 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.5 2.5 0 0 1-.92-.598 2.5 2.5 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233s.008-2.388.046-3.231c.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92s.546-.453.92-.598c.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92m-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217m0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334"/>
                        </svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-md bg-white/5 hover:bg-[#4b76c4]/20 flex items-center justify-center transition-colors group">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#4b76c4] transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-md bg-white/5 hover:bg-[#4b76c4]/20 flex items-center justify-center transition-colors group">
                        <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-[#4b76c4] transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="text-[10px] text-slate-500">&copy; {{ date('Y') }} GameDock. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors">Privacy Policy</a>
                <a href="#" class="text-[10px] text-slate-500 hover:text-slate-300 transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
