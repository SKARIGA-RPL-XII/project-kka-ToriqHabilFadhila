<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Classes;
use App\Models\ClassEnrollment;
use App\Models\Assignment;

class SiswaController extends Controller
{
    public function index()
    {
        return view('siswa.kelas');
    }

    public function join(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $token = \App\Models\TokenKelas::where('token_code', $request->token)->first();

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
        $kelas = Classes::with(['enrollments.user', 'creator', 'assignments.submissions' => function($query) {
            $query->where('id_user', Auth::id());
        }, 'materials'])->findOrFail($id);
        return view('siswa.class-detail', compact('kelas'));
    }

    public function showAssignment($id)
    {
        $assignment = Assignment::with(['class', 'questions.options'])->findOrFail($id);
        return view('siswa.assignment', compact('assignment'));
    }

    public function submitAssignment(Request $request, $id)
    {
        $assignment = Assignment::with('questions.options')->findOrFail($id);
        
        $request->validate([
            'answers' => 'required|array',
        ]);

        $score = 0;
        $status = 'submitted';

        // Auto-grade for pilihan_ganda
        if ($assignment->tipe === 'pilihan_ganda') {
            foreach ($request->answers as $questionId => $answerId) {
                $question = $assignment->questions->where('id_question', $questionId)->first();
                if ($question) {
                    $selectedOption = $question->options->where('id_option', $answerId)->first();
                    if ($selectedOption && $selectedOption->is_correct) {
                        $score += $question->poin;
                    }
                }
            }
            $status = 'graded';
        }

        \App\Models\Submission::create([
            'id_assignment' => $id,
            'id_user' => Auth::user()->id_user,
            'jawaban' => json_encode($request->answers),
            'submitted_at' => now(),
            'score' => $assignment->tipe === 'pilihan_ganda' ? $score : null,
            'status' => $status,
            'graded_by' => $assignment->tipe === 'pilihan_ganda' ? null : null,
            'graded_at' => $assignment->tipe === 'pilihan_ganda' ? now() : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Jawaban berhasil dikumpulkan!');
    }

    public function showSubmission($id)
    {
        $submission = \App\Models\Submission::with(['assignment.class', 'assignment.questions.options'])->findOrFail($id);
        return view('siswa.submission-detail', compact('submission'));
    }

    public function materials()
    {
        $user = Auth::user();
        $classIds = $user->enrollments()->pluck('id_class');
        $materials = \App\Models\Material::whereIn('id_class', $classIds)
            ->with(['class', 'uploader'])
            ->orderBy('id_material', 'desc')
            ->get();
        
        return view('siswa.materials', compact('materials'));
    }
}
