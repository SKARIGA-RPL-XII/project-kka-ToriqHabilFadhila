<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function profile()
    {
        return view('profile.index', [
            'user' => Auth::user()
        ]);
    }

    public function settings()
    {
        return view('profile.settings', [
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id_user . ',id_user',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::delete('public/avatars/' . $user->avatar);
            }
            $avatarName = time() . '.' . $request->avatar->extension();
            $request->avatar->storeAs('public/avatars', $avatarName);
            $validated['avatar'] = $avatarName;
        }
        $user->fill($validated)->save(); // safer alternative to update()
        return back()->with('success', 'Profil Anda berhasil diperbarui! Perubahan telah disimpan.')
            ->with('redirect_delay', false);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
        ]);
        /** @var User $user */
        $user = Auth::user();
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama yang Anda masukkan tidak sesuai. Silakan periksa kembali.'])
                ->with('warning', 'Password lama salah.');
        }
        $user->password = Hash::make($validated['password']);
        $user->save(); // safer alternative
        return back()->with('success', 'Password berhasil diubah! Pastikan Anda mengingat password baru untuk login selanjutnya.')
            ->with('redirect_delay', false);
    }
}
