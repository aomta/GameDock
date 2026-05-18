<x-guest-layout>
    <main class="auth-cover auth-page">
        <section class="auth-stage">
            <div class="auth-panel max-w-xl w-full mx-auto text-center">
                <div class="mx-auto mb-5 w-16 h-16 rounded-full bg-sky-500/15 flex items-center justify-center">
                    <svg class="w-8 h-8 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-6a2 2 0 012-2h14a2 2 0 012 2v6m-18 0a3 3 0 013-3h12a3 3 0 013 3m-18 0l2.5-3.5m-13 0L5 19m9 0l2-4m-2 4l-2-4"/>
                    </svg>
                </div>

                <h1 class="auth-heading text-center">Verify Your Email</h1>

                <p class="text-slate-400 text-sm leading-relaxed mb-6">
                    Thanks for signing up! We've sent a verification link to your email. Click the link to activate your GameDock account. If you don't see it, check your spam folder.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-6 rounded-lg border border-green-400/30 bg-green-500/15 px-4 py-3 text-sm text-green-300 font-semibold">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <form method="POST" action="{{ route('verification.send') }}" class="flex flex-col items-center gap-4">
                    @csrf
                    <button type="submit" class="auth-button">RESEND VERIFICATION EMAIL</button>
                </form>

                <div class="mt-8 pt-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-slate-300 underline hover:text-white">
                            Log Out
                        </button>
                    </form>
                    <span class="text-slate-600 hidden sm:block">|</span>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 underline hover:text-white">
                        Back to Sign In
                    </a>
                </div>
            </div>
        </section>
    </main>
</x-guest-layout>
