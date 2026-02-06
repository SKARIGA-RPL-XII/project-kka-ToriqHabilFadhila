<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassEnrollment;
use App\Models\Classes;
use App\Models\Assignment;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // SISWA
        if ($user->role === 'siswa') {
            $allClasses = $user->enrollments()
                ->with(['class.creator', 'class.enrollments'])
                ->whereHas('class', function($q) {
                    $q->where('status', 'active');
                })
                ->get()
                ->pluck('class');

            return view('dashboard.siswa', [
                'classes' => $allClasses
            ]);
        }

        // GURU
        if ($user->role === 'guru') {
            $allClasses = $user->createdClasses()
                ->with(['enrollments.user', 'creator', 'activeToken'])
                ->where('status', 'active')
                ->get();

            $assignments = Assignment::whereIn('id_class', $allClasses->pluck('id_class'))
                ->with(['class', 'creator'])
                ->where('deadline', '>=', now())
                ->orderBy('deadline', 'asc')
                ->limit(10)
                ->get();

            return view('dashboard.guru', [
                'classes' => $allClasses,
                'assignments' => $assignments
            ]);
        }

        return view('dashboard.admin');
    }

}
