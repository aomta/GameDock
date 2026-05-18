<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'email_confirmation' => ['required', 'same:email'],
            'country' => ['required', 'string', 'max:100'],
            'terms' => ['accepted'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'email_confirmation.required' => 'Please confirm your email address.',
            'email_confirmation.same' => 'Email confirmation must match your email address.',
            'country.required' => 'Please choose your country of residence.',
            'terms.accepted' => 'You must accept the subscriber agreement and privacy policy.',
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation must match your password.',
        ]);

        $user = User::create([
            'name' => str($request->email)->before('@')->headline()->toString(),
            'email' => $request->email,
            'country' => $request->country,
            'role' => 'user',
            'password' => Hash::make($request->password),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('login')->with('status', 'Account created successfully! Please sign in to continue.');
    }
}
