<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class RegisterController extends Controller
{
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


    // =====================
    // CALLBACK GOOGLE
    // =====================

    public function redirectGoogle()
    {
        // redirect biasa
        $googleAuthUrl = 'https://accounts.google.com/o/oauth2/auth?' . http_build_query([
            'client_id'     => config('services.google.client_id'),
            'redirect_uri'  => route('register.google.callback'),
            'response_type' => 'code',
            'scope'         => 'openid email profile',
            'prompt'        => 'select_account', // ini bikin selalu pilih akun
        ]);

        return redirect($googleAuthUrl);
    }

    public function callbackGoogle()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // auto register
            $user = User::create([
                'nama'        => $googleUser->getName(),
                'email'       => $googleUser->getEmail(),
                'password'    => Hash::make(Str::random(32)),
                'role'        => 'siswa',
                'is_active'   => true,
                'is_verified' => true,
                'last_login'  => now(),
            ]);
        } else {
            $user->last_login = now();
            $user->save();
        }

        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
