<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\ClassEnrollment;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.kelas');
    }

    public function join(Request $request)
    {
        $request->validate([
            'token_code' => 'required|string|exists:token_kelas,token_code',
        ]);

        $token = \App\Models\TokenKelas::where('token_code', $request->token_code)->first();

        if (!$token) {
            return redirect()->back()->with('error', 'Token tidak valid!');
        }

        $kelas = Classes::find($token->id_class);

        if ($kelas->enrollments()->count() >= $kelas->max_students) {
            return redirect()->back()->with('error', 'Kelas sudah penuh!');
        }

        $exists = ClassEnrollment::where('id_class', $kelas->id_class)
            ->where('id_user', Auth::user()->id_user)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Kamu sudah join kelas ini!');
        }

        ClassEnrollment::create([
            'id_class' => $kelas->id_class,
            'id_user' => Auth::user()->id_user,
            'status' => 'active',
        ]);

        $token->increment('times_used');

        return redirect()->back()->with('success', 'Berhasil join kelas!');
    }

    public function showClass($id)
    {
        $kelas = Classes::with(['enrollments.user', 'creator', 'assignments'])->findOrFail($id);
        return view('siswa.class-detail', compact('kelas'));
    }
}
