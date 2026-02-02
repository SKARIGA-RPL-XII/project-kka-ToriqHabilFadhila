<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\ClassEnrollment;
use App\Models\TokenKelas;

class SiswaController extends Controller
{
    // Menampilkan kelas yang diikuti siswa
    public function index()
    {
        $classes = Classes::whereHas('enrollments', function ($q) {
            $q->where('id_user', Auth::id());
        })->get();
        return redirect()->back();
    }

    // Join kelas menggunakan token
    public function join(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);
        // Cari token
        $token = TokenKelas::where('token_code', $request->token)->first();
        if (!$token) {
            return back()->with('error', 'Token tidak valid');
        }
        // Ambil kelas
        $kelas = Classes::where('id_class', $token->id_class)->first();
        if (!$kelas) {
            return back()->with('error', 'Kelas tidak ditemukan');
        }
        // Cegah join ganda
        $already = ClassEnrollment::where('id_class', $kelas->id_class)
            ->where('id_user', Auth::id())
            ->exists();
        if ($already) {
                return back()->with('error', 'Anda sudah join kelas ini');
            }
        // Simpan enrollment
        ClassEnrollment::create([
            'id_class' => $kelas->id_class,
            'id_user'  => Auth::id(),
            'status'   => 'active',
        ]);
        // Update penggunaan token (opsional tapi rapi)
        $token->increment('times_used');
        return redirect()->route('siswa.kelas')
            ->with('success', 'Berhasil join kelas');
    }
}
