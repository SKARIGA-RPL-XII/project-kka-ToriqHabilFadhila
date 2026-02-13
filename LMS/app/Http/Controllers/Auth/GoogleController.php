<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google + paksa pilih akun
     */
    public function redirect(Request $request): RedirectResponse
    {
        $mode = $request->query('mode', 'login');
        session(['google_auth_mode' => $mode]);

        /** @var GoogleProvider $provider */
        $provider = Socialite::driver('google');

        return $provider
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback(): RedirectResponse
    {
        try {
            /** @var \Laravel\Socialite\Two\User $googleUser */
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            // Akun belum ada -> redirect ke form register
            if (!$user) {
                session([
                    'google_data' => [
                        'name' => $googleUser->getName(),
                        'email' => $googleUser->getEmail(),
                        'avatar' => $googleUser->getAvatar(),
                        'profile_picture' => $googleUser->getAvatar(),
                    ]
                ]);
                return redirect()->route('google.complete');
            }

            // Akun sudah ada -> langsung login
            $user->update(['last_login' => now()]);
            Auth::login($user);
            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->nama . '!');

        } catch (\Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->withErrors(['email' => 'Terjadi kesalahan saat menghubungkan dengan Google.']);
        }
    }

    public function showComplete()
    {
        if (!session('google_data')) {
            return redirect()->route('login');
        }
        return view('auth.google-complete');
    }

    public function storeComplete(Request $request): RedirectResponse
    {
        $googleData = session('google_data');
        if (!$googleData) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'role' => 'required|in:guru,siswa',
        ]);

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $googleData['email'],
            'password' => Hash::make(Str::random(32)),
            'role' => $validated['role'],
            'is_active' => true,
            'is_verified' => true,
            'last_login' => now(),
            'profile_picture' => $googleData['profile_picture'] ?? null,
        ]);

        session()->forget('google_data');
        Auth::login($user);
        
        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang ' . $user->nama . '!');
    }
}
