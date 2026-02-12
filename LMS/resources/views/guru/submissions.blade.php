<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Jawaban Siswa - {{ $assignment->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-2">Jawaban Siswa</h1>
            <p class="text-lg text-purple-100 mb-4">{{ $assignment->judul }} - {{ $assignment->class->nama_kelas }}</p>
            <div class="flex flex-wrap gap-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Total Siswa: {{ $assignment->class->enrollments->count() }}</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Sudah Submit: {{ $assignment->submissions->count() }}</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Belum Submit: {{ $assignment->class->enrollments->count() - $assignment->submissions->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Submissions List -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-gray-900">Daftar Jawaban</h2>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($assignment->submissions as $submission)
                    <div class="p-6 hover:bg-gray-50 transition">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                    {{ strtoupper(substr($submission->user->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $submission->user->nama }}</h3>
                                    <p class="text-sm text-gray-500">{{ $submission->user->email }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($submission->status === 'graded')
                                    <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓ Sudah dinilai</span>
                                    <p class="text-sm font-bold text-green-600 mt-1">Nilai: {{ $submission->score }}/{{ $assignment->max_score }}</p>
                                @else
                                    <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">⏳ Perlu dinilai</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Dikumpulkan: {{ $submission->submitted_at->format('d M Y, H:i') }}
                            </p>
                            <button onclick="toggleAnswer({{ $submission->id_submission }})" class="text-purple-600 hover:text-purple-700 font-semibold text-sm flex items-center gap-1">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Answer Detail (Hidden by default) -->
                        <div id="answer-{{ $submission->id_submission }}" class="hidden mt-4 p-4 bg-gray-50 rounded-xl">
                            <h4 class="font-semibold text-gray-900 mb-3">Jawaban:</h4>
                            @php
                                $answers = json_decode($submission->jawaban, true);
                            @endphp
                            @if(is_array($answers))
                                <div class="space-y-3">
                                    @foreach($answers as $questionId => $answer)
                                        @php
                                            $question = $assignment->questions->where('id_question', $questionId)->first();
                                        @endphp
                                        @if($question)
                                            <div class="bg-white p-3 rounded-lg">
                                                <p class="font-semibold text-gray-800 mb-2">{{ $question->soal }}</p>
                                                @if($assignment->tipe === 'pilihan_ganda')
                                                    @php
                                                        $selectedOption = $question->options->where('id_option', $answer)->first();
                                                    @endphp
                                                    <p class="text-gray-700">
                                                        Jawaban: <span class="font-semibold {{ $selectedOption && $selectedOption->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                                            {{ $selectedOption ? $selectedOption->pilihan : 'N/A' }}
                                                            @if($selectedOption && $selectedOption->is_correct)
                                                                ✓
                                                            @else
                                                                ✗
                                                            @endif
                                                        </span>
                                                    </p>
                                                @else
                                                    <p class="text-gray-700 mb-2">{{ $answer }}</p>
                                                    @if($question->kunci_jawaban)
                                                        <div class="mt-2 p-2 bg-blue-50 rounded border border-blue-200">
                                                            <p class="text-xs font-semibold text-blue-700 mb-1">🔑 Kunci Jawaban:</p>
                                                            <p class="text-xs text-blue-600">{{ $question->kunci_jawaban }}</p>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-600">{{ $submission->jawaban }}</p>
                            @endif

                            @if($submission->status !== 'graded')
                                <!-- AI Grading Button (for Essay/Praktik with Answer Key) -->
                                @if(($assignment->tipe === 'essay' || $assignment->tipe === 'praktik') && $assignment->questions->where('kunci_jawaban', '!=', null)->count() > 0)
                                    <div class="mt-4 mb-3 p-3 bg-blue-50 border border-blue-200 rounded-xl">
                                        <p class="text-xs text-blue-700 mb-2">
                                            <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                            </svg>
                                            <strong>AI Grading:</strong> Klik tombol di bawah untuk koreksi otomatis dengan AI.
                                        </p>
                                        <button onclick="autoGrade({{ $submission->id_submission }})" id="ai-btn-{{ $submission->id_submission }}" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-cyan-600 text-white rounded-xl hover:from-blue-700 hover:to-cyan-700 transition font-semibold flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 7H7v6h6V7z"/>
                                                <path fill-rule="evenodd" d="M7 2a1 1 0 012 0v1h2V2a1 1 0 112 0v1h2a2 2 0 012 2v2h1a1 1 0 110 2h-1v2h1a1 1 0 110 2h-1v2a2 2 0 01-2 2h-2v1a1 1 0 11-2 0v-1H9v1a1 1 0 11-2 0v-1H5a2 2 0 01-2-2v-2H2a1 1 0 110-2h1V9H2a1 1 0 010-2h1V5a2 2 0 012-2h2V2zM5 5h10v10H5V5z" clip-rule="evenodd"/>
                                            </svg>
                                            🤖 Koreksi dengan AI
                                        </button>
                                    </div>
                                @endif

                                <div id="ai-result-{{ $submission->id_submission }}" class="hidden mt-3 p-3 rounded-xl">
                                    <p class="text-xs font-semibold mb-1">✨ Hasil AI Grading:</p>
                                    <p id="ai-feedback-{{ $submission->id_submission }}" class="text-sm"></p>
                                </div>

                                <p class="text-xs text-gray-500 mt-2">
                                    💡 <strong>Penilaian Manual:</strong> Atau isi nilai manual di kolom di bawah.
                                </p>

                                <form method="POST" action="{{ route('guru.submissions.grade', $submission->id_submission) }}" id="grade-form-{{ $submission->id_submission }}" class="flex gap-3 mt-3">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="score" id="score-{{ $submission->id_submission }}" min="0" max="{{ $assignment->max_score }}" placeholder="Nilai (0-{{ $assignment->max_score }})" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500" required>
                                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold">
                                        Beri Nilai
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum Ada Jawaban</h3>
                        <p class="text-gray-600">Belum ada siswa yang mengumpulkan tugas ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Students Who Haven't Submitted -->
        @php
            $submittedUserIds = $assignment->submissions->pluck('id_user');
            $notSubmitted = $assignment->class->enrollments->whereNotIn('id_user', $submittedUserIds);
        @endphp

        @if($notSubmitted->count() > 0)
            <div class="bg-red-50 rounded-3xl shadow-xl p-6 mt-8 border border-red-200">
                <h3 class="font-bold text-red-800 mb-4 flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Belum Mengumpulkan ({{ $notSubmitted->count() }} siswa)
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($notSubmitted as $enrollment)
                        <div class="bg-white p-3 rounded-xl flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gray-300 flex items-center justify-center text-gray-600 font-bold">
                                {{ strtoupper(substr($enrollment->user->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $enrollment->user->nama }}</p>
                                <p class="text-xs text-gray-500">{{ $enrollment->user->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        function toggleAnswer(id) {
            const element = document.getElementById('answer-' + id);
            element.classList.toggle('hidden');
        }

        async function autoGrade(submissionId) {
            const btn = document.getElementById(`ai-btn-${submissionId}`);
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sedang mengoreksi...';

            try {
                const response = await fetch('/guru/ai/grade', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ submission_id: submissionId })
                });

                const data = await response.json();

                if (data.success) {
                    // Auto-fill score
                    document.getElementById(`score-${submissionId}`).value = data.score;

                    // Show AI feedback
                    const resultDiv = document.getElementById(`ai-result-${submissionId}`);
                    const feedbackP = document.getElementById(`ai-feedback-${submissionId}`);

                    // Check if there's an error in feedback
                    if (data.feedback.includes('Error:')) {
                        resultDiv.className = 'mt-3 p-3 bg-yellow-50 border border-yellow-300 rounded-xl';
                        feedbackP.className = 'text-sm text-yellow-800';
                        feedbackP.innerHTML = '<span class="font-semibold text-yellow-700">⚠️ AI Tidak Tersedia</span><br>' +
                            '<span class="text-xs">API key tidak valid atau koneksi bermasalah. Silakan nilai manual dengan mengisi kolom di bawah.</span><br>' +
                            '<span class="text-xs text-gray-600 mt-1 block">Detail: ' + data.feedback.replace('Error: ', '') + '</span>';
                    } else {
                        resultDiv.className = 'mt-3 p-3 bg-green-50 border border-green-200 rounded-xl';
                        feedbackP.className = 'text-sm text-green-800';
                        feedbackP.textContent = data.feedback;
                    }

                    resultDiv.classList.remove('hidden');
                    btn.innerHTML = '✅ Selesai! Nilai: ' + data.score;
                } else {
                    const resultDiv = document.getElementById(`ai-result-${submissionId}`);
                    const feedbackP = document.getElementById(`ai-feedback-${submissionId}`);
                    resultDiv.className = 'mt-3 p-3 bg-yellow-50 border border-yellow-300 rounded-xl';
                    feedbackP.className = 'text-sm text-yellow-800';
                    feedbackP.innerHTML = '<span class="font-semibold text-yellow-700">⚠️ AI Tidak Tersedia</span><br>' +
                        '<span class="text-xs">Silakan nilai manual dengan mengisi kolom di bawah.</span><br>' +
                        '<span class="text-xs text-gray-600 mt-1 block">Detail: ' + (data.message || 'Gagal mengoreksi') + '</span>';
                    resultDiv.classList.remove('hidden');
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                }
            } catch (error) {
                const resultDiv = document.getElementById(`ai-result-${submissionId}`);
                const feedbackP = document.getElementById(`ai-feedback-${submissionId}`);
                resultDiv.className = 'mt-3 p-3 bg-yellow-50 border border-yellow-300 rounded-xl';
                feedbackP.className = 'text-sm text-yellow-800';
                feedbackP.innerHTML = '<span class="font-semibold text-yellow-700">⚠️ Koneksi Bermasalah</span><br>' +
                    '<span class="text-xs">Tidak dapat terhubung ke server AI. Silakan nilai manual.</span>';
                resultDiv.classList.remove('hidden');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }
        }
    </script>
</body>
</html>
