<?php

namespace App\Services;

use App\Models\FeedbackAI;
use App\Models\Submission;
use Illuminate\Support\Facades\Log;

class FeedbackAIService
{
    protected $materialRecommendationService;

    public function __construct(MaterialRecommendationService $materialRecommendationService)
    {
        $this->materialRecommendationService = $materialRecommendationService;
    }

    public function generateAndSaveFeedback($userId, $classId)
    {
        try {
            // Check if feedback already exists for this user and class
            $existingFeedback = FeedbackAI::whereHas('submission', function ($q) use ($userId, $classId) {
                $q->where('id_user', $userId)
                  ->whereHas('assignment', function ($subQ) use ($classId) {
                      $subQ->where('id_class', $classId);
                  });
            })->first();
            
            if ($existingFeedback) {
                Log::info('Feedback already exists, skipping generation', [
                    'user_id' => $userId,
                    'class_id' => $classId
                ]);
                return [
                    'success' => true,
                    'message' => 'Feedback sudah ada, menggunakan data yang tersimpan',
                    'total_submissions' => 0,
                    'saved_count' => 0,
                ];
            }
            
            $analysisService = new AIAnalysisService();
            $analysis = $analysisService->analyzeStudentPerformance($userId, $classId);
            $metrics = $analysis['metrics'];

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

            Log::info('Submissions found for feedback', [
                'user_id' => $userId,
                'class_id' => $classId,
                'count' => $submissions->count()
            ]);

            $savedCount = 0;
            foreach ($submissions as $submission) {
                $existingFeedback = FeedbackAI::where('id_submission', $submission->id_submission)->first();
                if ($existingFeedback) {
                    Log::info('Feedback already exists', ['submission_id' => $submission->id_submission]);
                    continue;
                }

                $materialRecommendations = $this->materialRecommendationService->generateMaterialRecommendations($metrics);
                
                $feedbackText = $this->formatStudentProfile($analysis);
                $recommendationText = $this->formatRecommendations($materialRecommendations);

                FeedbackAI::create([
                    'id_submission' => $submission->id_submission,
                    'feedback_text' => $feedbackText,
                    'saran' => $this->generateSuggestions($submission, $metrics),
                    'rekomendasi_materi' => $recommendationText,
                    'created_at' => now(),
                ]);
                $savedCount++;

                Log::info('Feedback saved', [
                    'submission_id' => $submission->id_submission,
                    'user_id' => $userId
                ]);
            }

            return [
                'success' => true,
                'message' => "Feedback AI berhasil dibuat untuk {$savedCount} submission",
                'total_submissions' => $submissions->count(),
                'saved_count' => $savedCount,
            ];
        } catch (\Exception $e) {
            Log::error('FeedbackAIService Error: ' . $e->getMessage());
            Log::error('Stack: ' . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Error generating feedback: ' . $e->getMessage(),
            ];
        }
    }

    private function formatStudentProfile($analysis)
    {
        $metrics = $analysis['metrics'];
        
        $text = "Profil & Progress Belajar\n";
        $text .= "========================\n\n";
        $text .= "Mata Pelajaran: {$analysis['class_name']}\n";
        $text .= "Nilai Terakhir: {$metrics['max_score']}\n";
        $text .= "Rata-rata Nilai: {$metrics['avg_score']}\n";
        $text .= "Progress Belajar: {$metrics['completed']} dari {$metrics['total_assignments']} tugas\n";
        $text .= "Completion Rate: {$metrics['completion_rate']}%\n";
        $text .= "On-Time Rate: {$metrics['on_time_rate']}%\n";
        $text .= "Trend: {$metrics['trend']}\n";
        $text .= "Consistency: {$metrics['consistency']}\n";
        
        return $text;
    }

    private function formatRecommendations($recommendations)
    {
        // Simpan dalam format JSON untuk parsing yang lebih baik
        return json_encode($recommendations, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    private function generateSuggestions($submission, $metrics)
    {
        $suggestions = [];
        $score = $submission->score ?? 0;

        if ($score < 70) {
            $suggestions[] = "Baca kembali materi pembelajaran dan coba kerjakan soal latihan tambahan untuk memperkuat pemahaman.";
        }

        if ($metrics['on_time_rate'] < 80) {
            $suggestions[] = "Coba buat jadwal belajar yang lebih terstruktur agar dapat mengumpulkan tugas tepat waktu.";
        }

        if ($metrics['variance'] > 20) {
            $suggestions[] = "Tingkatkan konsistensi belajar Anda dengan membuat rutinitas harian yang teratur.";
        }

        if ($metrics['trend'] === 'menurun') {
            $suggestions[] = "Performa Anda menunjukkan tren menurun. Identifikasi hambatan yang Anda hadapi dan minta bantuan guru jika diperlukan.";
        }

        if (empty($suggestions)) {
            $suggestions[] = "Pertahankan performa Anda yang sudah baik dengan terus belajar dan berlatih secara konsisten.";
        }

        return implode(' ', $suggestions);
    }
}
