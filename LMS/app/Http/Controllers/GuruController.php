<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Classes;
use App\Models\TokenKelas;

class GuruController extends Controller
{
    public function storeClass(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:100',
            'deskripsi'  => 'required|string|max:255',
            'max_students' => 'required|integer|min:1',
        ]);
        $token = null;
        DB::transaction(function () use ($request, &$token) { // <-- & penting
            // Buat kelas
            $kelas = Classes::create([
                'nama_kelas'  => $request->nama_kelas,
                'deskripsi'   => $request->deskripsi,
                'created_by' => Auth::user()->id_user,
                'max_students'=> $request->max_students,
                'status'      => 'active',
            ]);
            // Generate token join
            $generatedToken = TokenKelas::create([
                'id_class'   => $kelas->id_class,
                'token_code' => Str::upper(Str::random(8)),
                'created_by' => Auth::user()->id_user,
                'max_uses'   => 0, // unlimited
                'times_used' => 0,
            ]);
            $token = $generatedToken->token_code; // <-- simpan ke variabel reference
        });
        return redirect()->back()
            ->with('success', 'Kelas berhasil dibuat')
            ->with('token', $token); // sekarang ini akan berisi token yang benar
    }
}
