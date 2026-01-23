<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;

class GoogleController extends Controller
{
    /**
     * Redirect ke Google + paksa pilih akun
     */
    public function redirect()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        return $driver
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Callback Google (login / register otomatis)
     */
    public function callback()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');
        $googleUser = $driver->stateless()->user();
        $user = User::where('email', $googleUser->getEmail())->first();
        if (! $user) {
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
            $user->update([
                'last_login' => now(),
            ]);
        }
        Auth::login($user);
        return redirect()->route('dashboard');
    }
}
