<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HuggingFaceService
{
    private string $apiKey;
    private string $apiUrl;
    private string $model;

    public function __construct()
    {
        $this->apiKey = config('services.huggingface.api_key');
        if (!$this->apiKey) {
            throw new \Exception('HUGGINGFACE_API_KEY tidak ditemukan');
        }
        $this->apiUrl = 'https://router.huggingface.co/v1/chat/completions';
        $this->model  = 'meta-llama/Meta-Llama-3-8B-Instruct';
    }

    private function callAPI(string $system, string $user, int $maxTokens = 256)
    {
        try {
            $response = Http::withToken($this->apiKey)
                ->timeout(90)
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $system],
                        ['role' => 'user', 'content' => $user],
                    ],
                    'max_tokens' => $maxTokens,
                    'temperature' => 0.1,
                    'seed' => 42,
                ]);
            if ($response->failed()) {
                Log::error('HF Router Error', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }
            return $response->json()['choices'][0]['message']['content'] ?? null;
        } catch (\Throwable $e) {
            Log::error('HF Exception: '.$e->getMessage());
            return null;
        }
    }

    /* =========================
        USE CASES
    ========================= */

    public function analyzeStudentProgress(array $data)
    {
        $system = 'Kamu asisten guru. Jawab SINGKAT tanpa format markdown atau simbol **.';
        $user =
            "Nama: {$data['nama']}\n" .
            "Kelas: {$data['kelas']}\n" .
            "Tugas selesai: {$data['completed']}/{$data['total']}\n" .
            "Rata-rata nilai: {$data['avg_score']}\n" .
            "Terlambat: {$data['late']}\n\n" .
            "Analisis: performa, area lemah, rekomendasi. Masing-masing 1-2 kalimat. TANPA simbol ** atau markdown.";
        $response = $this->callAPI($system, $user, 200);
        return $response ? str_replace(['**', '*'], '', $response) : $response;
    }

    public function provideFeedback(string $question, string $answer)
    {
        return $this->callAPI(
            'Anda adalah guru yang memberi feedback konstruktif.',
            "Pertanyaan:\n$question\n\nJawaban siswa:\n$answer\n\nBeri feedback singkat.",
            150
        );
    }

    public function gradeAnswer(string $question, string $key, string $answer, int $maxScore)
    {
        $system = 'Kamu sistem penilaian. WAJIB balas JSON: {"score":0,"feedback":"teks"} TANPA teks lain.';
        $user = "Soal: $question\nKunci: $key\nJawaban: $answer\nMax: $maxScore\n\nNilai dalam JSON. Feedback WAJIB diisi.";

        $raw = $this->callAPI($system, $user, 120);

        if (!$raw) {
            return ['score' => 0, 'feedback' => 'AI tidak merespons'];
        }

        // Extract JSON dari response
        if (preg_match('/{[^}]*"score"[^}]*"feedback"[^}]*}/', $raw, $match)) {
            $json = json_decode($match[0], true);
            if (is_array($json) && isset($json['score'])) {
                $feedback = trim($json['feedback'] ?? '');
                // Jika feedback kosong, beri default
                if (empty($feedback)) {
                    $feedback = 'Jawaban sudah dinilai';
                }
                return [
                    'score' => min(max((int)$json['score'], 0), $maxScore),
                    'feedback' => $feedback
                ];
            }
        }

        return ['score' => 0, 'feedback' => 'Format tidak valid'];
    }

    public function recommendMaterials(array $studentProfile)
    {
        $system = 'Kamu asisten rekomendasi materi. Jawab SINGKAT dan PADAT.';

        $performanceNote = '';
        if (isset($studentProfile['avg_score']) && $studentProfile['avg_score'] < 60) {
            $performanceNote = "PENTING: Nilai rata-rata rendah ({$studentProfile['avg_score']}). Fokus pada materi dasar dan penguatan fundamental.\n";
        }

        $user =
            $performanceNote .
            "Mata Pelajaran: {$studentProfile['subject']}\n" .
            "Nilai Terakhir: {$studentProfile['last_scores']}\n" .
            "Rata-rata: {$studentProfile['avg_score']}\n" .
            "Progress: {$studentProfile['progress']}\n" .
            "Status: {$studentProfile['performance_status']}\n" .
            "Topik Sulit: {$studentProfile['weak_topics']}\n" .
            "Gaya Belajar: {$studentProfile['learning_style']}\n" .
            "Materi Tersedia: {$studentProfile['available_materials']}\n\n" .
            "Rekomendasikan 3-4 materi. Format: Judul - alasan (1 kalimat). SINGKAT.";
        return $this->callAPI($system, $user, 300);
    }
}
