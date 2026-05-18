<x-guest-layout>
    <main class="auth-cover auth-page">
        <section class="auth-stage">
            <form method="POST" action="{{ route('password.confirm') }}" class="auth-panel max-w-xl w-full mx-auto">
                @csrf

                <h1 class="auth-heading">Confirm Password</h1>

                <p class="mb-6 text-slate-400 text-sm leading-relaxed">
                    This is a secure area. Please confirm your password before continuing.
                </p>

                @if ($errors->any())
                    <div class="auth-error-summary">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
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
                    @error('password')
                        <p class="mt-2 text-sm text-red-300" id="password-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-10 flex flex-col items-stretch gap-4 sm:max-w-md sm:items-start">
                    <button type="submit" class="auth-button">CONFIRM</button>
                </div>
            </form>
        </section>
    </main>
</x-guest-layout>
