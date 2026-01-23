<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;

class AuthServices extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Email atau password salah'
            ]);
        }

        $request->session()->regenerate();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->last_login = now();
        $user->save();
        return redirect()->route('dashboard');
    }

    public function loginAsGuest()
    {
        $user = User::create([
            'nama'        => 'Tamu ' . Str::random(5),
            'email'       => 'guest_' . Str::uuid() . '@guest.local',
            'password'    => Hash::make(Str::random(16)),
            'role'        => 'siswa',
            'is_active'   => true,
            'is_verified' => false,
            'last_login'  => now(),
        ]);
        Auth::login($user);
        return redirect()->route('dashboard');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nama'        => $validated['name'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => 'siswa',
            'is_active'   => true,
            'is_verified' => true,
            'last_login'  => now(),
        ]);

        // arahkan ke login dengan flash message
        return redirect()->route('login')->with('success', 'Berhasil membuat akun, silakan login!');
    }

    public function logout(Request $request)
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($user && str_ends_with($user->email, '@guest.local')) {
            $user->delete();
            // Reset sequence supaya guest berikutnya pakai ID berturut-turut
            DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('users', 'id_user'),
                    COALESCE((SELECT MAX(id_user) FROM users), 0) + 1,
                    false
                )
            ");
        }

        return redirect()->route('login');
    }
}
