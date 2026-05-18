<x-guest-layout>
    <main class="auth-cover auth-page">
        <section class="auth-stage">
            <div class="grid w-full gap-8 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-center xl:grid-cols-[minmax(0,1fr)_360px]">
                <form method="POST" action="{{ route('login') }}" class="auth-panel max-w-2xl">
                    @csrf

                    <h1 class="auth-heading">Sign In</h1>

                    <x-auth-session-status class="mb-4 text-sm text-sky-300" :status="session('status')" />

                    @if ($errors->any())
                        <div class="auth-error-summary">
                            Please check the highlighted fields and try again.
                        </div>
                    @endif

                    <div>
                        <label for="email" class="auth-label text-sky-400 uppercase">Sign in with account game</label>
                        <input id="email" class="auth-field @error('email') auth-field-error @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        <x-input-error id="email-error" :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div class="mt-8">
                        <label for="password" class="auth-label uppercase">Password</label>
                        <div x-data="{ showPassword: false }" class="relative">
                            <input id="password" class="auth-field pr-12 @error('password') auth-field-error @enderror" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
                            <button type="button" class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-sky-100/80 transition hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-sky-300" x-on:click="showPassword = ! showPassword" :aria-label="showPassword ? 'Hide password' : 'Show password'">
                                <svg x-show="! showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z" />
                                    <circle cx="12" cy="12" r="3" />
                                </svg>
                                <svg x-cloak x-show="showPassword" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path d="M3 3l18 18" />
                                    <path d="M10.6 10.6A2 2 0 0012 14a2 2 0 001.4-.6" />
                                    <path d="M9.9 4.2A10.5 10.5 0 0112 4c6.5 0 10 8 10 8a17.8 17.8 0 01-3.1 4.4" />
                                    <path d="M6.5 6.8C3.6 8.8 2 12 2 12s3.5 8 10 8a9.7 9.7 0 004.5-1.1" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error id="password-error" :messages="$errors->get('password')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <label for="remember_me" class="mt-8 inline-flex items-center gap-2 text-sm uppercase text-slate-300">
                        <input id="remember_me" type="checkbox" class="h-4 w-4 rounded-sm border-white/70 bg-white text-sky-500 focus:ring-sky-400" name="remember">
                        <span>Remember me</span>
                    </label>

                    <div class="mt-10 flex flex-col items-stretch gap-4 sm:max-w-md sm:items-start lg:mt-12">
                        <button type="submit" class="auth-button">SIGN IN</button>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-semibold text-slate-300 underline hover:text-white" href="{{ route('password.request') }}">
                                Help, I can't sign in
                            </a>
                        @endif
                    </div>
                </form>

                <aside class="hidden rounded-lg border border-white/10 bg-[#07172a]/70 px-6 py-8 text-center shadow-2xl shadow-black/30 backdrop-blur-md lg:block">
                    <h2 class="mb-6 text-lg font-extrabold uppercase text-sky-400">Or sign in with QR</h2>
                    <div class="mx-auto flex h-[300px] w-[300px] items-center justify-center rounded-md bg-white p-5 shadow-2xl">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=260x260&data={{ urlencode(url()->current()) }}&color=15171c&bgcolor=FFFFFF" alt="QR Code" class="w-full h-full">
                    </div>
                    <p class="mt-7 text-sm text-slate-300">Use the <a href="#" class="underline">GameDock Mobile App</a> to sign in via QR Code</p>
                </aside>
            </div>
        </section>

        <section class="mx-auto mt-8 max-w-7xl rounded-lg border border-white/10 bg-[#07172a]/80 px-5 py-8 text-center shadow-2xl shadow-black/25 backdrop-blur-md sm:py-10">
            <h2 class="text-2xl font-black sm:text-3xl">New to GameDock?</h2>
            <a href="{{ route('register') }}" class="auth-button mt-7">Create an account</a>
            <p class="mx-auto mt-7 max-w-md text-xs leading-snug text-slate-400">
                It's free and easy. Discover thousands of games to play with millions of new friends.
                <a href="#" class="block underline">Learn more about GameDock</a>
            </p>
        </section>
    </main>
</x-guest-layout>
