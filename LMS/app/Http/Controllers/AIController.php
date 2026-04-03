<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\HuggingFaceService;
use App\Services\AIAnalysisService;
use App\Services\ActivityLogService;
use App\Models\Submission;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AIController extends Controller
{
    protected $ai;
    public function __construct(HuggingFaceService $ai)
    {
        $this->ai = $ai;
    }
    
    // Guru: Analisis progres siswa (Enhanced)
    public function analyzeProgress(Request $request, $userId, $classId)
    {
        try {
            // Check if feedback already exists
            $existingFeedback = \App\Models\FeedbackAI::whereHas('submission', function ($q) use ($userId, $classId) {
                $q->where('id_user', $userId)
                  ->whereHas('assignment', function ($subQ) use ($classId) {
                      $subQ->where('id_class', $classId);
                  });
            })->first();
            
            if ($existingFeedback) {
                Log::info('Using existing feedback for guru analysis', [
                    'user_id' => $userId,
                    'class_id' => $classId
                ]);
                
                $analysis = $this->parseAnalysisFromFeedback($existingFeedback);
                
                return response()->json([
                    'success' => true,
                    'data' => $analysis,
                    'feedback_saved' => 0,
                    'from_cache' => true
                ]);
            }
            
            $analysisService = new AIAnalysisService();
            $analysis = $analysisService->analyzeStudentPerformance($userId, $classId);
            
            $feedbackService = new \App\Services\FeedbackAIService(new \App\Services\MaterialRecommendationService());
            $feedbackResult = $feedbackService->generateAndSaveFeedback($userId, $classId);
            
            Log::info('Feedback AI generated', [
                'user_id' => $userId,
                'class_id' => $classId,
                'saved_count' => $feedbackResult['saved_count'] ?? 0
            ]);
            
            ActivityLogService::log('analyze_student', 'user', $userId, "Menganalisis performa siswa di kelas {$classId}");
            
            return response()->json([
                'success' => true,
                'data' => $analysis,
                'feedback_saved' => $feedbackResult['saved_count'] ?? 0,
                'from_cache' => false
            ]);
        } catch (\Exception $e) {
            Log::error('AI Analysis Error: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menganalisis performa siswa: ' . $e->getMessage()
            ], 500);
        }
    }
    
    private function parseAnalysisFromFeedback($feedback)
    {
        $profile = $this->parseFeedbackProfile($feedback->feedback_text);
        
        return [
            'class_name' => $profile['subject'],
            'analysis' => $feedback->saran,
            'metrics' => [
                'max_score' => $profile['last_scores'],
                'avg_score' => $profile['avg_score'],
                'completed' => 0,
                'total_assignments' => 0,
                'completion_rate' => 100,
                'on_time_rate' => 100,
                'trend' => 'stabil',
                'consistency' => 'Sangat Konsisten'
            ]
        ];
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
            return $this->noClassResponse();
        }

        $latestFeedback = $this->getLatestFeedback($user, $classIds);
        if ($latestFeedback) {
            return $this->buildFeedbackResponse($latestFeedback, $classIds, true);
        }

        return $this->buildFallbackResponse($user, $classIds);
    }

    private function noClassResponse()
    {
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

    private function getLatestFeedback($user, $classIds)
    {
        return \App\Models\FeedbackAI::whereHas('submission', function ($q) use ($user, $classIds) {
            $q->where('id_user', $user->id_user)
              ->whereHas('assignment', function ($subQ) use ($classIds) {
                  $subQ->whereIn('id_class', $classIds);
              });
        })
        ->orderBy('created_at', 'desc')
        ->first();
    }

    private function buildFeedbackResponse($feedback, $classIds, $fromDatabase)
    {
        $profile = $this->parseFeedbackProfile($feedback->feedback_text);
        $recommendations = $this->formatRecommendationsWithLinks($feedback->rekomendasi_materi, $classIds);
        
        return response()->json([
            'success' => true,
            'recommendations' => $recommendations,
            'profile' => $profile,
            'from_database' => $fromDatabase
        ]);
    }

    private function buildFallbackResponse($user, $classIds)
    {
        $submissions = $this->getUserSubmissions($user, $classIds);
        $profile = $this->buildStudentProfile($submissions, $classIds);
        
        // Check if feedback already exists for any class
        $existingFeedback = $this->getLatestFeedback($user, $classIds);
        if ($existingFeedback) {
            return $this->buildFeedbackResponse($existingFeedback, $classIds, true);
        }
        
        // Generate new AI recommendations only if no feedback exists
        $aiRecommendations = $this->ai->recommendMaterials($profile);
        $structuredRecommendations = $this->parseAIRecommendations($aiRecommendations);
        $recommendations = $this->formatRecommendationsWithLinks(json_encode($structuredRecommendations), $classIds);
        
        // Save feedback to database for each class
        foreach ($classIds as $classId) {
            $this->saveFallbackFeedback($user->id_user, $classId, $profile, $structuredRecommendations);
        }
        
        return response()->json([
            'success' => true,
            'recommendations' => $recommendations,
            'profile' => $profile,
            'from_database' => false
        ]);
    }

    private function saveFallbackFeedback($userId, $classId, $profile, $recommendations)
    {
        try {
            $submissions = Submission::where('id_user', $userId)
                ->whereHas('assignment', function ($q) use ($classId) {
                    $q->where('id_class', $classId);
                })
                ->where(function ($query) {
                    $query->where('status', 'graded')
                        ->orWhere(function ($q) {
                            $q->where('status', 'submitted')
                              ->whereHas('assignment', function ($subQ) {
                                  $subQ->where('tipe', 'pilihan_ganda');
                              });
                        });
                })
                ->orderBy('submitted_at', 'desc')
                ->limit(5)
                ->get();

            foreach ($submissions as $submission) {
                $existingFeedback = \App\Models\FeedbackAI::where('id_submission', $submission->id_submission)->first();
                if ($existingFeedback) {
                    continue;
                }

                $feedbackText = "Profil & Progress Belajar\n";
                $feedbackText .= "========================\n\n";
                $feedbackText .= "Mata Pelajaran: " . ($profile['subject'] ?? 'Umum') . "\n";
                $feedbackText .= "Nilai Terakhir: " . ($profile['last_scores'] ?? '-') . "\n";
                $feedbackText .= "Rata-rata Nilai: " . ($profile['avg_score'] ?? 0) . "\n";
                $feedbackText .= "Progress Belajar: " . ($profile['progress'] ?? '-') . "\n";
                $feedbackText .= "Status Performa: " . ($profile['performance_status'] ?? 'Cukup') . "\n";

                \App\Models\FeedbackAI::create([
                    'id_submission' => $submission->id_submission,
                    'feedback_text' => $feedbackText,
                    'saran' => 'Pertahankan performa Anda yang sudah baik dengan terus belajar dan berlatih secara konsisten.',
                    'rekomendasi_materi' => json_encode($recommendations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT),
                    'created_at' => now(),
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Error saving fallback feedback: ' . $e->getMessage());
        }
    }

    private function parseAIRecommendations($aiText)
    {
        $recommendations = [];
        
        // Parse numbered recommendations from AI text
        if (preg_match_all('/\d+\.\s*\*\*(.+?)\*\*\s*-\s*(.+?)(?=\n\d+\.|$)/s', $aiText, $matches)) {
            foreach ($matches[1] as $index => $title) {
                $recommendations[] = [
                    'title' => trim($title),
                    'description' => trim($matches[2][$index]),
                    'resources' => 'Tutorial | Video | Dokumentasi'
                ];
            }
        }
        
        // If no structured recommendations found, create a generic one
        if (empty($recommendations)) {
            $recommendations[] = [
                'title' => 'Materi Pembelajaran Umum',
                'description' => $aiText,
                'resources' => 'Tutorial | Video | Dokumentasi'
            ];
        }
        
        return $recommendations;
    }

    private function getUserSubmissions($user, $classIds)
    {
        return Submission::where('id_user', $user->id_user)
            ->whereHas('assignment', function ($q) use ($classIds) {
                $q->whereIn('id_class', $classIds);
            })
            ->with('assignment.class')
            ->orderBy('submitted_at', 'desc')
            ->take(5)
            ->get();
    }

    private function buildStudentProfile($submissions, $classIds)
    {
        $avgScore = $submissions->avg('score') ?? 0;
        $totalSubmissions = $submissions->count();
        $completedCount = $submissions->where('status', 'graded')->count();
        
        return [
            'subject' => $submissions->first()?->assignment?->class?->nama_kelas ?? 'Umum',
            'last_scores' => $submissions->pluck('score')->filter()->implode(', ') ?: 'Belum ada',
            'avg_score' => round($avgScore, 1),
            'progress' => "{$completedCount} dari {$totalSubmissions} tugas",
            'performance_status' => $this->getPerformanceStatus($avgScore),
            'weak_topics' => $submissions->filter(fn($sub) => $sub->score < 70)->pluck('assignment.judul')->take(3)->implode(', ') ?: 'Tidak ada',
            'learning_style' => $avgScore >= 80 ? 'Visual & Praktik' : 'Perlu Penguatan Dasar',
            'available_materials' => $this->getAvailableMaterials($classIds)
        ];
    }

    private function getPerformanceStatus($avgScore)
    {
        if ($avgScore < 60) return 'Perlu Perhatian Khusus';
        if ($avgScore >= 80) return 'Baik';
        return 'Cukup';
    }

    private function getAvailableMaterials($classIds)
    {
        $materials = \App\Models\Material::whereIn('id_class', $classIds)
            ->with('class')
            ->get()
            ->map(fn($m) => $m->judul . ' (' . $m->class->nama_kelas . ')')
            ->implode(', ');
        
        return $materials ?: 'Belum ada materi';
    }

    private function parseFeedbackProfile($feedbackText)
    {
        $profile = [
            'subject' => 'Umum',
            'last_scores' => '-',
            'avg_score' => 0,
            'progress' => '-',
            'performance_status' => 'Cukup',
            'weak_topics' => '-',
            'learning_style' => 'Belum diketahui',
            'available_materials' => '-'
        ];

        // Parse feedback_text untuk extract profile data
        if (preg_match('/Mata Pelajaran:\s*(.+?)(?:\n|$)/i', $feedbackText, $m)) {
            $profile['subject'] = trim($m[1]);
        }
        if (preg_match('/Nilai Terakhir:\s*(.+?)(?:\n|$)/i', $feedbackText, $m)) {
            $profile['last_scores'] = trim($m[1]);
        }
        if (preg_match('/Rata-rata Nilai:\s*(.+?)(?:\n|$)/i', $feedbackText, $m)) {
            $avgVal = (float) trim($m[1]);
            $profile['avg_score'] = $avgVal;
        }
        if (preg_match('/Progress Belajar:\s*(.+?)(?:\n|$)/i', $feedbackText, $m)) {
            $profile['progress'] = trim($m[1]);
        }
        if (preg_match('/Trend:\s*(.+?)(?:\n|$)/i', $feedbackText, $m)) {
            $trend = trim($m[1]);
            if ($trend === 'menurun') {
                $profile['performance_status'] = 'Perlu Perhatian Khusus';
            } elseif ($trend === 'meningkat') {
                $profile['performance_status'] = 'Baik';
            } else {
                $profile['performance_status'] = 'Cukup';
            }
        } elseif ($profile['avg_score'] > 0) {
            // Fallback: gunakan avg_score untuk determine status
            if ($profile['avg_score'] < 60) {
                $profile['performance_status'] = 'Perlu Perhatian Khusus';
            } elseif ($profile['avg_score'] >= 80) {
                $profile['performance_status'] = 'Baik';
            } else {
                $profile['performance_status'] = 'Cukup';
            }
        }

        return $profile;
    }

    private function formatRecommendationsWithLinks($recommendationJson, $classIds)
    {
        try {
            $recommendations = json_decode($recommendationJson, true);
            if (!is_array($recommendations)) {
                return $recommendationJson;
            }

            $materials = \App\Models\Material::whereIn('id_class', $classIds)->get();
            $html = "";
            $counter = 1;
            
            foreach ($recommendations as $rec) {
                $title = $rec['title'] ?? '';
                $description = $rec['description'] ?? '';
                $resources = $rec['resources'] ?? '';

                $onlineLink = '';
                $googleSearchLink = "https://www.google.com/search?q=" . urlencode($title);
                
                foreach ($materials as $material) {
                    if (stripos($title, $material->judul) !== false || stripos($description, $material->judul) !== false) {
                        if ($material->online_link) {
                            $onlineLink = $material->online_link;
                        }
                        break;
                    }
                }

                $html .= "<div class='mb-4 p-4 bg-indigo-50 rounded-lg border-l-4 border-indigo-600'>";
                $html .= "<p class='font-semibold text-gray-900'>{$counter}. {$title}</p>";
                $html .= "<p class='text-sm text-gray-700 mt-2'>{$description}</p>";
                
                if (!empty($resources)) {
                    $html .= "<p class='text-xs text-gray-600 mt-2'><strong>Resources:</strong> {$resources}</p>";
                }
                
                // Action buttons
                $html .= "<div class='flex gap-2 mt-3'>";
                
                if ($onlineLink) {
                    $html .= "<a href='{$onlineLink}' target='_blank' class='inline-flex items-center gap-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition'>
                        <svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                            <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14'/>
                        </svg>
                        Akses Online
                    </a>";
                }
                
                $html .= "<a href='{$googleSearchLink}' target='_blank' class='inline-flex items-center gap-1 px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-semibold rounded-lg transition'>
                    <svg class='w-4 h-4' fill='currentColor' viewBox='0 0 24 24'>
                        <path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z'/>
                    </svg>
                    Cari di Google
                </a>";
                
                $html .= "</div>";
                $html .= "</div>";
                $counter++;
            }

            return $html ?: $recommendationJson;
        } catch (\Exception $e) {
            return $recommendationJson;
        }
    }

    // Guru: Koreksi otomatis jawaban siswa
    public function autoGrade(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id_submission'
        ]);
        $submission = Submission::with('assignment.questions')->findOrFail($request->submission_id);
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
