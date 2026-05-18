<x-guest-layout>
    <main class="auth-cover auth-page">
        <section class="auth-stage">
            <form method="POST" action="{{ route('register') }}" class="auth-panel">
                @csrf

                <h1 class="auth-heading">Create Your Account</h1>

                @if ($errors->any())
                    <div class="auth-error-summary">
                        Please check the highlighted fields and try again.
                    </div>
                @endif

                <div class="grid gap-x-16 gap-y-6 lg:grid-cols-2">
                    <div>
                        <label for="email" class="auth-label text-sky-400">Email Address</label>
                        <input id="email" class="auth-field @error('email') auth-field-error @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" @error('email') aria-invalid="true" aria-describedby="email-error" @enderror>
                        <x-input-error id="email-error" :messages="$errors->get('email')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="email_confirmation" class="auth-label">Confirm your Email Address</label>
                        <input id="email_confirmation" class="auth-field @error('email_confirmation') auth-field-error @enderror" type="email" name="email_confirmation" value="{{ old('email_confirmation') }}" required autocomplete="email" @error('email_confirmation') aria-invalid="true" aria-describedby="email_confirmation-error" @enderror>
                        <x-input-error id="email_confirmation-error" :messages="$errors->get('email_confirmation')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password" class="auth-label uppercase">Password</label>
                        <div x-data="{ showPassword: false }" class="relative">
                            <input id="password" class="auth-field pr-12 @error('password') auth-field-error @enderror" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
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

                    <div>
                        <label for="country" class="auth-label">Country of Residence</label>
                        <select id="country" class="auth-field @error('country') auth-field-error @enderror" name="country" required @error('country') aria-invalid="true" aria-describedby="country-error" @enderror>
                            @foreach (['Indonesia', 'Malaysia', 'Singapore', 'Thailand', 'Philippines', 'Vietnam'] as $country)
                                <option value="{{ $country }}" @selected(old('country', 'Indonesia') === $country)>{{ $country }}</option>
                            @endforeach
                        </select>
                        <x-input-error id="country-error" :messages="$errors->get('country')" class="mt-2 text-sm text-red-300" />
                    </div>

                    <div>
                        <label for="password_confirmation" class="auth-label uppercase">Confirm Password</label>
                        <div x-data="{ showPassword: false }" class="relative">
                            <input id="password_confirmation" class="auth-field pr-12 @error('password_confirmation') auth-field-error @enderror" :type="showPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" @error('password_confirmation') aria-invalid="true" aria-describedby="password_confirmation-error" @enderror>
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
                        <x-input-error id="password_confirmation-error" :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-300" />
                    </div>
                </div>

                <label for="terms" class="mt-8 flex items-start gap-3 text-sm text-slate-300 sm:text-base">
                    <input id="terms" type="checkbox" name="terms" value="1" class="mt-1 h-4 w-4 rounded-sm border-white/70 bg-white text-sky-500 focus:ring-sky-400 @error('terms') ring-2 ring-red-300 @enderror" required @checked(old('terms')) @error('terms') aria-invalid="true" aria-describedby="terms-error" @enderror>
                    <span>I am 13 years of age or older and agree to the terms of the <a class="underline hover:text-white" href="#">GameDock Subscriber Agreement</a> and the <a class="underline hover:text-white" href="#">Valve Privacy Policy</a>.</span>
                </label>
                <x-input-error id="terms-error" :messages="$errors->get('terms')" class="mt-2 text-sm text-red-300" />

                <div class="mt-10 flex flex-col items-stretch gap-4 sm:items-center">
                    <button type="submit" class="auth-button">SIGN UP</button>
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-300 underline hover:text-white">Already have an account?</a>
                </div>
            </form>
        </section>
    </main>
</x-guest-layout>
