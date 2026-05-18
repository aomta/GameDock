<x-guest-layout>
    <main class="auth-cover auth-page">
        <section class="auth-stage">
            <div class="grid w-full gap-8 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-center xl:grid-cols-[minmax(0,1fr)_360px]">
                <form method="POST" action="{{ route('password.email') }}" class="auth-panel max-w-2xl">
                    @csrf

                    <h1 class="auth-heading">Reset Password</h1>

                    <p class="mb-6 text-slate-400 text-sm leading-relaxed">
                        Forgot your password? No problem. Enter the email address linked to your GameDock account and we'll send you a link to reset it.
                    </p>

                    <x-auth-session-status class="mb-4 text-sm text-green-400 font-semibold" :status="session('status')" />

                    @if ($errors->any())
                        <div class="auth-error-summary">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <div>
                        <label for="email" class="auth-label text-sky-400 uppercase">Account Email Address</label>
                        <input id="email" class="auth-field @error('email') auth-field-error @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        @error('email')
                            <p class="mt-2 text-sm text-red-300" id="email-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mt-10 flex flex-col items-stretch gap-4 sm:max-w-md sm:items-start">
                        <button type="submit" class="auth-button">SEND RESET LINK</button>

                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 underline hover:text-white">
                            Back to Sign In
                        </a>
                    </div>
                </form>

                <aside class="hidden rounded-lg border border-white/10 bg-[#07172a]/70 px-6 py-8 text-center shadow-2xl shadow-black/30 backdrop-blur-md lg:block">
                    <div class="mx-auto mb-5 w-16 h-16 rounded-full bg-sky-500/15 flex items-center justify-center">
                        <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-extrabold uppercase text-sky-400 mb-3">Check Your Inbox</h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        We'll send a secure password reset link to your email. The link expires in 60 minutes.
                    </p>
                </aside>
            </div>
        </section>

        <section class="mx-auto mt-8 max-w-7xl rounded-lg border border-white/10 bg-[#07172a]/80 px-5 py-8 text-center shadow-2xl shadow-black/25 backdrop-blur-md sm:py-10">
            <h2 class="text-2xl font-black sm:text-3xl">Don't have an account?</h2>
            <a href="{{ route('register') }}" class="auth-button mt-7">Create an account</a>
            <p class="mx-auto mt-7 max-w-md text-xs leading-snug text-slate-400">
                It's free and easy. Discover thousands of games to play with millions of new friends.
                <a href="#" class="block underline">Learn more about GameDock</a>
            </p>
        </section>
    </main>
</x-guest-layout>
