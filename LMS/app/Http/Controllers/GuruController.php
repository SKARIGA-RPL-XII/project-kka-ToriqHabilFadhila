<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Classes;
use App\Models\TokenKelas;
use App\Models\Material;
use App\Models\Assignment;
use App\Models\Question;
use App\Models\QuestionOption;

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
        DB::transaction(function () use ($request, &$token) {
            $kelas = Classes::create([
                'nama_kelas'  => $request->nama_kelas,
                'deskripsi'   => $request->deskripsi,
                'created_by' => Auth::user()->id_user,
                'max_students'=> $request->max_students,
                'status'      => 'active',
            ]);
            $generatedToken = TokenKelas::create([
                'id_class'   => $kelas->id_class,
                'token_code' => Str::upper(Str::random(8)),
                'created_by' => Auth::user()->id_user,
                'max_uses'   => 0,
                'times_used' => 0,
            ]);
            $token = $generatedToken->token_code;
        });
        return redirect()->back()
            ->with('success', 'Kelas berhasil dibuat! Token: ' . $token)
            ->with('token', $token)
            ->with('redirect_delay', false);
    }

    public function storeMaterial(Request $request)
    {
        $request->validate([
            'id_class' => 'required|exists:classes,id_class',
            'judul' => 'required|string|max:200',
            'konten' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip|max:10240',
        ]);

        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('materials', $fileName, 'public');
            $fileType = $file->getClientOriginalExtension();
        }

        Material::create([
            'id_class' => $request->id_class,
            'judul' => $request->judul,
            'konten' => $request->konten,
            'file_path' => $filePath,
            'file_type' => $fileType,
            'uploaded_by' => Auth::user()->id_user,
        ]);

        return redirect()->back()
            ->with('success', 'Materi berhasil diupload!')
            ->with('redirect_delay', false);
    }

    public function storeAssignment(Request $request)
    {
        $request->validate([
            'id_class' => 'required|exists:classes,id_class',
            'judul' => 'required|string|max:200',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:pilihan_ganda,essay,praktik',
            'deadline' => 'required|date|after:now',
            'max_score' => 'required|integer|min:1|max:100',
        ]);

        $assignment = Assignment::create([
            'id_class' => $request->id_class,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'deadline' => $request->deadline,
            'max_score' => $request->max_score,
            'created_by' => Auth::user()->id_user,
        ]);

        // Notify students about new assignment
        $class = Classes::with('enrollments')->find($request->id_class);
        foreach ($class->enrollments as $enrollment) {
            \App\Models\Notification::create([
                'id_user' => $enrollment->id_user,
                'type' => 'new_assignment',
                'title' => 'Tugas Baru!',
                'message' => "Tugas baru '{$request->judul}' telah ditambahkan di kelas {$class->nama_kelas}.",
                'related_id' => $assignment->id_assignment,
                'created_at' => now(),
            ]);
        }

        // Untuk essay/praktik: langsung ke halaman tambah soal dengan pesan khusus
        if (in_array($request->tipe, ['essay', 'praktik'])) {
            return redirect()->route('guru.assignments.questions', $assignment->id_assignment)
                ->with('success', 'Tugas berhasil dibuat! Silakan tambahkan soal-soal di bawah ini.');
        }

        // Untuk pilihan ganda: tetap ke halaman kelola soal
        return redirect()->route('guru.assignments.questions', $assignment->id_assignment)
            ->with('success', 'Tugas berhasil dibuat! Sekarang tambahkan soal.');
    }

    public function showClass($id)
    {
        $kelas = Classes::with(['enrollments.user', 'creator', 'activeToken', 'assignments'])->findOrFail($id);
        return view('guru.class-detail', compact('kelas'));
    }

    public function showQuestions($id)
    {
        $assignment = Assignment::with('questions.options')->findOrFail($id);
        return view('guru.questions', compact('assignment'));
    }

    public function storeQuestion(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);

        $request->validate([
            'soal' => 'required|string',
            'kunci_jawaban' => in_array($assignment->tipe, ['essay', 'praktik']) ? 'nullable|string' : 'nullable',
            'poin' => 'required|integer|min:1',
            'pilihan' => $assignment->tipe === 'pilihan_ganda' ? 'required|array|min:2' : 'nullable',
            'pilihan.*' => 'required|string',
            'jawaban_benar' => $assignment->tipe === 'pilihan_ganda' ? 'required|integer' : 'nullable',
        ]);

        DB::transaction(function () use ($request, $assignment) {
            $question = $assignment->questions()->create([
                'soal' => $request->soal,
                'kunci_jawaban' => $request->kunci_jawaban,
                'poin' => $request->poin,
                'urutan' => $assignment->questions()->count() + 1,
            ]);

            if ($assignment->tipe === 'pilihan_ganda' && $request->pilihan) {
                foreach ($request->pilihan as $index => $pilihan) {
                    $question->options()->create([
                        'pilihan' => $pilihan,
                        'is_correct' => $index == $request->jawaban_benar,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Soal berhasil ditambahkan!');
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::with('assignment', 'options')->findOrFail($id);
        $assignment = $question->assignment;

        $request->validate([
            'soal' => 'required|string',
            'kunci_jawaban' => in_array($assignment->tipe, ['essay', 'praktik']) ? 'nullable|string' : 'nullable',
            'poin' => 'required|integer|min:1',
            'pilihan' => $assignment->tipe === 'pilihan_ganda' ? 'required|array|min:2' : 'nullable',
            'pilihan.*' => 'required|string',
            'jawaban_benar' => $assignment->tipe === 'pilihan_ganda' ? 'required|integer' : 'nullable',
        ]);

        DB::transaction(function () use ($request, $question, $assignment) {

            // update soal utama
            $question->update([
                'soal' => $request->soal,
                'kunci_jawaban' => $request->kunci_jawaban,
                'poin' => $request->poin,
            ]);

            // kalau pilihan ganda, update opsinya
            if ($assignment->tipe === 'pilihan_ganda') {
                foreach ($question->options as $index => $option) {
                    $option->update([
                        'pilihan' => $request->pilihan[$index],
                        'is_correct' => $index == $request->jawaban_benar,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Soal berhasil diperbarui!');
    }

    public function updateAssignmentDeadline(Request $request, $id)
    {
        $request->validate([
            'deadline' => 'required|date',
        ]);

        $assignment = Assignment::findOrFail($id);
        $assignment->update(['deadline' => $request->deadline]);

        return redirect()->back()->with('success', 'Deadline berhasil diperbarui!');
    }

    public function showSubmissions($id)
    {
        $assignment = Assignment::with(['class.enrollments.user', 'submissions.user', 'questions.options'])->findOrFail($id);
        return view('guru.submissions', compact('assignment'));
    }

    public function gradeSubmission(Request $request, $id)
    {
        $request->validate([
            'score' => 'required|numeric|min:0',
        ]);

        $submission = \App\Models\Submission::with('assignment')->findOrFail($id);
        $submission->update([
            'score' => $request->score,
            'status' => 'graded',
            'graded_by' => Auth::user()->id_user,
            'graded_at' => now(),
        ]);

        // Notify student about grade
        \App\Models\Notification::create([
            'id_user' => $submission->id_user,
            'type' => 'grade',
            'title' => 'Tugas Dinilai!',
            'message' => "Tugas '{$submission->assignment->judul}' telah dinilai. Nilai: {$request->score}/{$submission->assignment->max_score}",
            'related_id' => $submission->id_submission,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Nilai berhasil diberikan!');
    }

}
