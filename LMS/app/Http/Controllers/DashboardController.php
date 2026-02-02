<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassEnrollment;
use App\Models\Classes;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        // SISWA
        if ($user->role === 'siswa') {
            $allClasses = Classes::with(['creator', 'enrollments'])
                ->whereHas('enrollments', function ($q) use ($user) {
                    $q->where('id_user', $user->id_user);
                })
                ->get();
            return view('dashboard.siswa', [
                'classes' => $allClasses
            ]);
        }

        // GURU
        if ($user->role === 'guru') {
            $allClasses = Classes::with(['enrollments', 'creator'])
                ->where('created_by', $user->id_user)
                ->get();
            return view('dashboard.guru', [
                'classes' => $allClasses
            ]);
        }
        return view('dashboard.admin');
    }

}
