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

    /**
     * Callback Google (login / register otomatis)
     */
    public function callback(): RedirectResponse
    {
        try {
            /** @var GoogleProvider $provider */
            $provider = Socialite::driver('google');
            $googleUser = $provider->stateless()->user();
            $mode = session('google_auth_mode', 'login');
            $user = User::where('email', $googleUser->getEmail())->first();

            // ❌ Login tapi akun belum ada
            if (! $user && $mode === 'login') {
                return redirect()->route('login')
                    ->withErrors([
                        'email' => 'Akun Google "' . $googleUser->getEmail() . '" belum terdaftar. Silakan daftar terlebih dahulu atau gunakan akun Google yang sudah terdaftar.'
                    ])
                    ->with('warning', 'Akun Google tidak ditemukan dalam sistem kami.');
            }

            // ❌ Register tapi akun sudah ada
            if ($user && $mode === 'register') {
                return redirect()->route('register')
                    ->withErrors([
                        'email' => 'Akun Google "' . $googleUser->getEmail() . '" sudah terdaftar. Silakan login menggunakan akun tersebut.'
                    ])
                    ->with('info', 'Akun sudah ada, silakan login.');
            }

            // ✅ Register via Google - akun baru
            if (! $user && $mode === 'register') {
                $user = User::create([
                    'nama'        => $googleUser->getName(),
                    'email'       => $googleUser->getEmail(),
                    'password'    => Hash::make(Str::random(32)),
                    'role'        => 'siswa',
                    'is_active'   => true,
                    'is_verified' => true,
                    'last_login'  => now(),
                ]);

                Auth::login($user);
                return redirect()->route('dashboard')
                    ->with('success', 'Selamat datang ' . $user->nama . '! Akun Google Anda berhasil didaftarkan dan Anda sudah login.')
                    ->with('redirect_delay', true);
            }

            // ✅ Login user lama
            $user->update(['last_login' => now()]);
            Auth::login($user);
            return redirect()->route('dashboard')
                ->with('success', 'Selamat datang kembali, ' . $user->nama . '! Login Google berhasil.')
                ->with('redirect_delay', true);

        } catch (\Exception $e) {
            // Log error untuk debugging
            Log::error('Google Auth Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'mode' => session('google_auth_mode', 'login')
            ]);
            $route = session('google_auth_mode', 'login') === 'register' ? 'register' : 'login';
            return redirect()->route($route)
                ->withErrors([
                    'email' => 'Terjadi kesalahan saat menghubungkan dengan Google. Silakan coba lagi atau gunakan metode login lain.'
                ])
                ->with('warning', 'Koneksi ke Google mengalami gangguan.');
        }
    }
}
