<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ClassEnrollment;
use App\Models\Classes;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\User;
use App\Models\Material;
use App\Models\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'siswa') {
            return $this->siswaView($user);
        }

        if ($user->role === 'guru') {
            return $this->guruView($user);
        }

        return view('dashboard.admin');
    }

    private function siswaView(User $user)
    {
        $classIds = $user->enrollments()->pluck('id_class');
        
        $allClasses = Classes::whereIn('id_class', $classIds)
            ->where('status', 'active')
            ->with(['creator', 'enrollments'])
            ->get();

        $assignments = Assignment::whereIn('id_class', $classIds)
            ->with(['class', 'creator'])
            ->where('is_published', true)
            ->where('deadline', '>=', now())
            ->orderBy('deadline', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($assignment) use ($user) {
                $submission = Submission::where('id_assignment', $assignment->id_assignment)
                    ->where('id_user', $user->id_user)
                    ->first();
                
                $assignment->submission = $submission;
                $assignment->is_completed = $submission && $submission->status === 'graded';
                return $assignment;
            });

        $materials = Material::whereIn('id_class', $classIds)
            ->with(['class', 'creator'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.siswa', [
            'classes'     => $allClasses,
            'assignments' => $assignments,
            'materials'   => $materials
        ]);
    }

    private function guruView(User $user)
    {
        $allClasses = $user->createdClasses()
            ->with(['enrollments.user', 'creator', 'activeToken'])
            ->where('status', 'active')
            ->get();

        $assignments = Assignment::whereIn('id_class', $allClasses->pluck('id_class'))
            ->with(['class.enrollments', 'creator'])
            ->orderBy('deadline', 'asc')
            ->limit(10)
            ->get();

        foreach ($assignments as $assignment) {
            $daysLeft = now()->diffInDays($assignment->deadline, false);
            if ($daysLeft <= 2 && $daysLeft >= 0) {
                $students = $assignment->class->enrollments;
                foreach ($students as $enrollment) {
                    $exists = Notification::where('id_user', $enrollment->id_user)
                        ->where('type', 'deadline')
                        ->where('related_id', $assignment->id_assignment)
                        ->where('created_at', '>=', now()->subDays(1))
                        ->exists();
                    
                    if (!$exists) {
                        Notification::create([
                            'id_user' => $enrollment->id_user,
                            'type' => 'deadline',
                            'title' => 'Deadline Tugas Mendekat!',
                            'message' => "Tugas '{$assignment->judul}' akan berakhir dalam {$daysLeft} hari. Segera kerjakan!",
                            'related_id' => $assignment->id_assignment,
                            'created_at' => now(),
                        ]);
                    }
                }
            }
        }

        $materials = Material::whereIn('id_class', $allClasses->pluck('id_class'))
            ->with(['class', 'creator'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('dashboard.guru', [
            'classes' => $allClasses,
            'assignments' => $assignments,
            'materials' => $materials
        ]);
    }

}
