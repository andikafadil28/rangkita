<?php

namespace App\Http\Controllers;

use App\Models\QuizSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Autentikasi Google gagal. Silakan coba lagi.']);
        }

        $email = $googleUser->getEmail();

        if (! $email) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Google Anda tidak memiliki email yang dapat diakses.']);
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $email)
            ->first();

        if (! $user) {
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'User Google',
                'email' => $email,
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => Hash::make(str()->random(32)),
            ]);
        } elseif (! $user->google_id) {
            $user->update(['google_id' => $googleUser->getId()]);
        }

        Auth::login($user);

        session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function dashboard()
    {
        $userId = auth()->id();

        $recentSessions = QuizSession::with('package.soalCategory')
            ->where('user_id', $userId)
            ->latest()
            ->limit(3)
            ->get();

        $stats = [
            'total' => QuizSession::where('user_id', $userId)->count(),
            'avgScore' => (int) round(QuizSession::where('user_id', $userId)->avg('score')),
            'bestScore' => QuizSession::where('user_id', $userId)->max('score') ?? 0,
        ];

        return view('auth.dashboard', [
            'user' => Auth::user(),
            'recentSessions' => $recentSessions,
            'stats' => $stats,
        ]);
    }
}