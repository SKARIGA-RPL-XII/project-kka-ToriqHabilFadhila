<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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

    public function getStudents($id)
    {
        $kelas = Classes::with('enrollments.user')->findOrFail($id);
        return response()->json($kelas->enrollments->map(fn($e) => ['id_user' => $e->user->id_user, 'nama' => $e->user->nama]));
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

    public function generateQuestions(Request $request, $id)
    {
        $assignment = Assignment::findOrFail($id);
        
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,txt|max:10240',
        ]);

        try {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            
            // Extract text from file
            $extractedText = $this->extractTextFromFile($file);
            
            Log::info('AI Generate - File: ' . $fileName);
            Log::info('AI Generate - Extracted text length: ' . strlen($extractedText));
            Log::info('AI Generate - First 500 chars: ' . substr($extractedText, 0, 500));
            
            if (empty($extractedText)) {
                return redirect()->back()->with('error', 'Gagal mengekstrak teks dari file. Pastikan file berisi teks yang dapat dibaca.');
            }

            // Call AI to parse questions
            $questions = $this->parseQuestionsWithAI($extractedText, $assignment->tipe);
            
            Log::info('AI Generate - Questions found: ' . count($questions));
            
            if (empty($questions)) {
                return redirect()->back()->with('error', 'AI tidak dapat menemukan soal dalam file. Pastikan format sesuai dengan contoh.');
            }

            // Save questions to database
            DB::transaction(function () use ($questions, $assignment) {
                $urutan = $assignment->questions()->count() + 1;
                
                foreach ($questions as $questionData) {
                    $question = $assignment->questions()->create([
                        'soal' => $questionData['soal'],
                        'kunci_jawaban' => $questionData['kunci_jawaban'] ?? null,
                        'poin' => $questionData['poin'] ?? 10,
                        'urutan' => $urutan++,
                    ]);

                    if ($assignment->tipe === 'pilihan_ganda' && isset($questionData['pilihan'])) {
                        foreach ($questionData['pilihan'] as $index => $pilihan) {
                            $question->options()->create([
                                'pilihan' => $pilihan,
                                'is_correct' => $index == ($questionData['jawaban_benar'] ?? 0),
                            ]);
                        }
                    }
                }
            });

            return redirect()->back()->with('success', count($questions) . ' soal berhasil di-generate oleh AI!');
            
        } catch (\Exception $e) {
            Log::error('AI Generate Questions Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function extractTextFromFile($file)
    {
        $extension = strtolower($file->getClientOriginalExtension());
        $filePath = $file->getRealPath();
        
        try {
            if ($extension === 'txt') {
                return file_get_contents($filePath);
            }
            
            if ($extension === 'pdf') {
                // Try using smalot/pdfparser library
                try {
                    $parser = new \Smalot\PdfParser\Parser();
                    $pdf = $parser->parseFile($filePath);
                    $text = $pdf->getText();
                    if (!empty($text)) {
                        return $text;
                    }
                } catch (\Exception $e) {
                    Log::warning('PDF parser library error: ' . $e->getMessage());
                }
                
                // Fallback: Simple text extraction
                $content = file_get_contents($filePath);
                $text = '';
                
                // Try to extract text between BT and ET markers (PDF text objects)
                if (preg_match_all('/BT\s*(.+?)\s*ET/s', $content, $matches)) {
                    foreach ($matches[1] as $match) {
                        // Extract text in parentheses or brackets
                        if (preg_match_all('/[\(\[]([^\)\]]+)[\)\]]/s', $match, $textMatches)) {
                            $text .= implode(' ', $textMatches[1]) . "\n";
                        }
                    }
                }
                
                if (!empty($text)) {
                    return $text;
                }
            }
            
            if (in_array($extension, ['doc', 'docx'])) {
                if ($extension === 'docx') {
                    // Try using PHPWord library
                    try {
                        $phpWord = \PhpOffice\PhpWord\IOFactory::load($filePath);
                        $text = '';
                        foreach ($phpWord->getSections() as $section) {
                            foreach ($section->getElements() as $element) {
                                $text .= $this->extractTextFromElement($element) . "\n";
                            }
                        }
                        if (!empty($text)) {
                            return $text;
                        }
                    } catch (\Exception $e) {
                        Log::warning('PHPWord library error: ' . $e->getMessage());
                    }
                    
                    // Fallback: Extract from DOCX ZIP
                    $zip = new \ZipArchive();
                    if ($zip->open($filePath) === true) {
                        $content = $zip->getFromName('word/document.xml');
                        $zip->close();
                        
                        if ($content) {
                            $text = strip_tags($content);
                            return html_entity_decode($text);
                        }
                    }
                }
            }
            
        } catch (\Exception $e) {
            Log::error('File extraction error: ' . $e->getMessage());
        }
        
        return "";
    }

    private function extractTextFromElement($element)
    {
        $text = '';
        
        // Handle different types of PHPWord elements
        if ($element instanceof \PhpOffice\PhpWord\Element\Text) {
            $text .= $element->getText();
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextRun) {
            foreach ($element->getElements() as $textElement) {
                if ($textElement instanceof \PhpOffice\PhpWord\Element\Text) {
                    $text .= $textElement->getText();
                }
            }
        } elseif ($element instanceof \PhpOffice\PhpWord\Element\TextBreak) {
            $text .= "\n";
        } elseif (method_exists($element, 'getElements')) {
            // Handle containers like paragraphs, tables, etc.
            foreach ($element->getElements() as $childElement) {
                $text .= $this->extractTextFromElement($childElement);
            }
        }
        
        return $text;
    }

    private function parseQuestionsWithAI($text, $tipe)
    {
        $questions = [];
        
        $text = str_replace("\r\n", "\n", $text);
        $text = str_replace("\r", "\n", $text);
        $text = preg_replace('/\n{3,}/', "\n\n", $text);
        $text = trim($text);
        
        if ($tipe === 'pilihan_ganda') {
            // Split by question numbers (1. or 1) at start of line)
            $lines = explode("\n", $text);
            $currentQuestion = null;
            $currentText = '';
            
            foreach ($lines as $line) {
                $line = trim($line);
                // Check if line starts with number
                if (preg_match('/^(\d+)\s*[\.\)]\s*(.*)$/', $line, $match)) {
                    // Save previous question
                    if ($currentQuestion !== null && !empty($currentText)) {
                        $parsed = $this->parseSingleMultipleChoice($currentText);
                        if ($parsed) {
                            $questions[] = $parsed;
                        }
                    }
                    // Start new question
                    $currentQuestion = $match[1];
                    $currentText = $match[2] . "\n";
                } else {
                    // Continue current question
                    $currentText .= $line . "\n";
                }
            }
            
            // Don't forget last question
            if ($currentQuestion !== null && !empty($currentText)) {
                $parsed = $this->parseSingleMultipleChoice($currentText);
                if ($parsed) {
                    $questions[] = $parsed;
                }
            }
        } else {
            // Essay/Praktik - same logic
            $lines = explode("\n", $text);
            $currentQuestion = null;
            $currentText = '';
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (preg_match('/^(\d+)\s*[\.\)]\s*(.*)$/', $line, $match)) {
                    if ($currentQuestion !== null && !empty($currentText)) {
                        $parsed = $this->parseSingleEssay($currentText);
                        if ($parsed) {
                            $questions[] = $parsed;
                        }
                    }
                    $currentQuestion = $match[1];
                    $currentText = $match[2] . "\n";
                } else {
                    $currentText .= $line . "\n";
                }
            }
            
            if ($currentQuestion !== null && !empty($currentText)) {
                $parsed = $this->parseSingleEssay($currentText);
                if ($parsed) {
                    $questions[] = $parsed;
                }
            }
        }
        
        return $questions;
    }
    
    private function parseSingleMultipleChoice($text)
    {
        $text = trim($text);
        
        // Extract poin
        $poin = $this->extractPoints($text);
        
        // Extract soal (text before first option A/B/C/D)
        if (preg_match('/^(.+?)(?=A\.\s)/s', $text, $soalMatch)) {
            $soal = $this->cleanQuestionText($soalMatch[1]);
        } else {
            return null;
        }
        
        // Extract options A, B, C, D - improved to stop at Kunci Jawaban
        $pilihan = [];
        if (preg_match('/A\.\s*(.+?)(?=B\.|$)/s', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        if (preg_match('/B\.\s*(.+?)(?=C\.|$)/s', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        if (preg_match('/C\.\s*(.+?)(?=D\.|$)/s', $text, $match)) {
            $pilihan[] = trim($match[1]);
        }
        if (preg_match('/D\.\s*(.+?)(?=Kunci|$)/s', $text, $match)) {
            // Clean up option D - remove "Kunci" and everything after it
            $optionD = trim($match[1]);
            $optionD = preg_replace('/\s*Kunci.*$/s', '', $optionD);
            $pilihan[] = trim($optionD);
        }
        
        // Extract correct answer
        $jawabanBenar = $this->extractCorrectAnswer($text);
        
        if (count($pilihan) >= 2 && !empty($soal)) {
            return [
                'soal' => $soal,
                'pilihan' => $pilihan,
                'jawaban_benar' => $jawabanBenar,
                'poin' => $poin,
            ];
        }
        
        return null;
    }
    
    private function parseSingleEssay($text)
    {
        $text = trim($text);
        
        $poin = $this->extractPoints($text);
        
        // Split by "Kunci Jawaban:" or similar patterns
        $soal = '';
        $kunciJawaban = '';
        
        // Try to split soal and kunci jawaban
        if (preg_match('/^(.+?)(?:Kunci\s*Jawaban|Jawaban|Kunci)\s*:\s*(.+?)(?:\(\s*Poin|$)/s', $text, $matches)) {
            $soal = $this->cleanQuestionText($matches[1]);
            $kunciJawaban = trim($matches[2]);
        } else {
            // If no kunci jawaban found, treat all as soal
            $soal = $this->cleanQuestionText($text);
        }
        
        if (!empty($soal)) {
            return [
                'soal' => $soal,
                'kunci_jawaban' => $kunciJawaban,
                'poin' => $poin,
            ];
        }
        
        return null;
    }

    private function extractCorrectAnswer($text)
    {
        // Match patterns: Kunci Jawaban: B, Jawaban: B, Kunci: B
        if (preg_match('/(?:Kunci\s*Jawaban|Jawaban|Kunci)\s*:\s*([A-D])/i', $text, $matches)) {
            return ord(strtoupper($matches[1])) - ord('A');
        }
        return 0;
    }

    private function extractAnswerKey($text)
    {
        // Match patterns: Kunci Jawaban: ..., Jawaban: ...
        if (preg_match('/(?:Kunci\s*Jawaban|Jawaban|Kunci)\s*:\s*(.+?)$/s', $text, $matches)) {
            return trim($matches[1]);
        }
        return '';
    }

    private function extractPoints($text)
    {
        // Match patterns: (Poin: 10)
        if (preg_match('/\(\s*Poin\s*:\s*(\d+)\s*\)/i', $text, $matches)) {
            return (int) $matches[1];
        }
        return 10;
    }

    private function cleanQuestionText($text)
    {
        // Remove point indicators
        $text = preg_replace('/\(\s*Poin\s*:\s*\d+\s*\)/i', '', $text);
        // Remove extra whitespace
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $assignmentId = $question->id_assignment;
        
        DB::transaction(function () use ($question) {
            // Delete options if exists
            $question->options()->delete();
            // Delete question
            $question->delete();
        });
        
        return redirect()->back()->with('success', 'Soal berhasil dihapus!');
    }

    public function bulkDeleteQuestions(Request $request, $id)
    {
        $request->validate([
            'ids' => 'required|json',
        ]);
        
        $ids = json_decode($request->ids, true);
        
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada soal yang dipilih!');
        }
        
        DB::transaction(function () use ($ids, $id) {
            /** @var Question[] $questions */
            $questions = Question::where('id_assignment', $id)
                ->whereIn('id_question', $ids)
                ->get();
            
            foreach ($questions as $question) {
                $question->options()->delete();
                $question->delete();
            }
        });
        
        return redirect()->back()->with('success', count($ids) . ' soal berhasil dihapus!');
    }

    public function publishAssignment($id)
    {
        $assignment = Assignment::with('questions')->findOrFail($id);
        
        if ($assignment->questions->count() === 0) {
            return redirect()->back()->with('error', 'Tidak bisa mempublikasi tugas tanpa soal!');
        }
        
        $assignment->update(['is_published' => true]);
        
        return redirect()->route('guru.classes.show', $assignment->id_class)
            ->with('success', 'Tugas berhasil dipublikasi dan sekarang terlihat oleh siswa!');
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
