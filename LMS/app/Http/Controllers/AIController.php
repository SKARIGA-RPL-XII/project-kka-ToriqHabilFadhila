<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HuggingFaceService;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class AIController extends Controller
{
    protected $ai;
    public function __construct(HuggingFaceService $ai)
    {
        $this->ai = $ai;
    }
    // Guru: Analisis progres siswa
    public function analyzeProgress(Request $request, $userId, $classId)
    {
        $user = \App\Models\User::findOrFail($userId);
        $class = \App\Models\Classes::findOrFail($classId);
        $question = $request->query('question', 'Bagaimana progress siswa ini?');
        $submissions = Submission::where('id_user', $userId)
            ->whereHas('assignment', function ($q) use ($classId) {
                $q->where('id_class', $classId);
            })
            ->with('assignment')
            ->get();
        $total = $submissions->count();
        $completed = $submissions->where('status', 'graded')->count();
        $avgScore = $submissions->where('status', 'graded')->avg('score') ?? 0;
        $late = $submissions->filter(function ($sub) {
            return $sub->submitted_at > $sub->assignment->deadline;
        })->count();
        $studentData = [
            'nama' => $user->nama,
            'kelas' => $class->nama_kelas,
            'completed' => $completed,
            'total' => $total,
            'avg_score' => round($avgScore, 1),
            'late' => $late,
            'question' => $question
        ];
        $analysis = $this->ai->analyzeStudentProgress($studentData);
        return response()->json([
            'success' => true,
            'analysis' => $analysis,
            'data' => $studentData
        ]);
    }

    // Siswa: Feedback jawaban uraian
    public function getFeedback(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string'
        ]);
        $feedback = $this->ai->provideFeedback(
            $request->question,
            $request->answer
        );
        return response()->json([
            'success' => true,
            'feedback' => $feedback
        ]);
    }

    // Siswa: Rekomendasi materi
    public function getRecommendations()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User tidak valid'
            ], 400);
        }
        $classIds = $user->enrollments()->pluck('id_class');
        if ($classIds->isEmpty()) {
            return response()->json([
                'success' => true,
                'recommendations' => 'Bergabunglah dengan kelas terlebih dahulu untuk mendapatkan rekomendasi pembelajaran yang personal.',
                'profile' => [
                    'subject' => 'Belum ada',
                    'last_scores' => 'Belum ada',
                    'weak_topics' => 'Belum ada',
                    'learning_style' => 'Belum diketahui'
                ]
            ]);
        }
        $submissions = Submission::where('id_user', $user->id_user)
            ->whereHas('assignment', function ($q) use ($classIds) {
                $q->whereIn('id_class', $classIds);
            })
            ->with('assignment.class')
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();
        $lastScores = $submissions->pluck('score')->filter()->implode(', ') ?: 'Belum ada';
        $avgScore = $submissions->avg('score') ?? 0;
        $totalSubmissions = $submissions->count();
        $completedCount = $submissions->where('status', 'graded')->count();
        $weakTopics = $submissions->filter(function ($sub) {
            return $sub->score < 70;
        })->pluck('assignment.judul')->take(3)->implode(', ') ?: 'Tidak ada';
        $availableMaterials = \App\Models\Material::whereIn('id_class', $classIds)
            ->with('class')
            ->get()
            ->map(function ($m) {
                return $m->judul . ' (' . $m->class->nama_kelas . ')';
            })
            ->implode(', ');
        $performanceStatus = $avgScore < 60 ? 'Perlu Perhatian Khusus' : ($avgScore >= 80 ? 'Baik' : 'Cukup');
        $studentProfile = [
            'subject' => $submissions->first()?->assignment?->class?->nama_kelas ?? 'Umum',
            'last_scores' => $lastScores,
            'avg_score' => round($avgScore, 1),
            'progress' => "$completedCount dari $totalSubmissions tugas",
            'performance_status' => $performanceStatus,
            'weak_topics' => $weakTopics,
            'learning_style' => $avgScore >= 80 ? 'Visual & Praktik' : 'Perlu Penguatan Dasar',
            'available_materials' => $availableMaterials ?: 'Belum ada materi'
        ];
        $recommendations = $this->ai->recommendMaterials($studentProfile);
        return response()->json([
            'success' => true,
            'recommendations' => $recommendations,
            'profile' => $studentProfile
        ]);
    }

    // Guru: Koreksi otomatis jawaban siswa
    public function autoGrade(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id_submission'
        ]);
        $submission = Submission::with(+'assignment.questions')->findOrFail($request->submission_id);
        $assignment = $submission->assignment;
        // Only for essay/praktik
        if (!in_array($assignment->tipe, ['essay', 'praktik'])) {
            return response()->json([
                'success' => false,
                'message' => 'AI grading hanya untuk soal essay/praktik'
            ], 400);
        }
        $answers = json_decode($submission->jawaban, true);
        $totalScore = 0;
        $feedbacks = [];
        $questionNum = 1;
        foreach ($answers as $questionId => $studentAnswer) {
            $question = $assignment->questions->where('id_question', $questionId)->first();
            if (!$question || !$question->kunci_jawaban) {
                continue;
            }
            $result = $this->ai->gradeAnswer(
                $question->soal,
                $question->kunci_jawaban,
                $studentAnswer,
                $question->poin
            );
            $totalScore += $result['score'];
            $feedbacks[] = "Soal {$questionNum}: {$result['feedback']}";
            $questionNum++;
        }
        $finalFeedback = implode(" | ", $feedbacks);
        return response()->json([
            'success' => true,
            'score' => min($totalScore, $assignment->max_score),
            'feedback' => $finalFeedback,
            'submission_id' => $submission->id_submission
        ]);
    }
}
