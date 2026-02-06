<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

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
                'email' => 'Email atau password yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.'
            ]);
        }

        $request->session()->regenerate();
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->last_login = now();
        $user->save();
        return redirect()
            ->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->nama . '! Login berhasil.')
            ->with('redirect_delay', true);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'nama'        => $validated['nama'],
            'email'       => $validated['email'],
            'password'    => Hash::make($validated['password']),
            'role'        => 'siswa',
            'is_active'   => true,
            'is_verified' => true,
            'last_login'  => now(),
        ]);

        // arahkan ke login dengan flash message
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Selamat datang ' . $validated['nama'] . ', silakan login dengan akun baru Anda.')
            ->with('redirect_delay', true);
    }

    /**
     * Kirim email reset password
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        try {
            // Cari user berdasarkan email
            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors([
                    'email' => 'Email "' . $request->email . '" tidak ditemukan dalam sistem kami. Pastikan email yang Anda masukkan benar.'
                ])->with('warning', 'Email tidak terdaftar.');
            }

            // Generate token menggunakan Laravel Password Broker
            $token = Password::createToken($user);

            // Kirim email (urutan parameter: token, email)
            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

            // Log untuk debugging
            Log::info('Reset password email sent', [
                'email' => $request->email,
                'token' => $token,
            ]);

            return back()->with('success', 'Email reset password telah dikirim ke ' . $request->email . '. Silakan periksa inbox atau folder spam Anda.')
                ->with('redirect_delay', false);

        } catch (\Exception $e) {
            // Log error
            Log::error('Failed to send reset password email', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors([
                'email' => 'Gagal mengirim email reset password. Silakan periksa koneksi internet Anda dan coba lagi nanti.'
            ])->with('warning', 'Terjadi gangguan sistem.');
        }
    }

    /**
     * Tampilkan form reset password (dari link email)
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.forgot-password', [ // sama Blade
            'mode'  => 'reset', // switch ke form reset password
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Proses reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.')
                ->with('redirect_delay', true)
            : back()->withErrors(['email' => 'Reset password gagal. ' . __($status)])->with('warning', 'Terjadi kesalahan saat reset password.');
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

        return redirect()
            ->route('login')
            ->with('success', 'Logout berhasil. Terima kasih telah menggunakan platform kami!')
            ->with('redirect_delay', true);
    }
}
