<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>{{ $assignment->judul }} - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white animate-fade-in-up overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <h1 class="text-3xl md:text-4xl font-bold mb-2">{{ $assignment->judul }}</h1>
            <p class="text-lg text-purple-100 mb-4">{{ $assignment->deskripsi }}</p>
            <div class="flex flex-wrap gap-3">
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Kelas: {{ $assignment->class->nama_kelas }}</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Deadline: {{ $assignment->deadline->format('d M Y, H:i') }}</span>
                </div>
                <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
                    <span class="font-semibold">Nilai Maks: {{ $assignment->max_score }}</span>
                </div>
                @php
                    $existingSubmission = \App\Models\Submission::where('id_assignment', $assignment->id_assignment)
                        ->where('id_user', auth()->id())
                        ->where('status', '!=', 'draft')
                        ->first();
                @endphp
                @if($existingSubmission)
                    <div class="bg-green-500/30 backdrop-blur-sm px-4 py-2 rounded-xl border-2 border-green-300">
                        <span class="font-bold">✓ Sudah Dikumpulkan</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Assignment Content -->
        @if($existingSubmission)
            <div class="bg-white rounded-3xl shadow-xl p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Tugas Sudah Dikumpulkan</h2>
                <p class="text-gray-600 mb-6">Kamu sudah mengumpulkan tugas ini pada {{ $existingSubmission->submitted_at->format('d M Y, H:i') }}</p>
                @if($existingSubmission->status === 'graded')
                    <div class="inline-block bg-green-50 border-2 border-green-200 rounded-xl p-6 mb-6">
                        <p class="text-sm text-gray-600 mb-2">Nilai Kamu:</p>
                        <p class="text-4xl font-bold text-green-600">{{ $existingSubmission->score }}/{{ $assignment->max_score }}</p>
                    </div>
                @else
                    <div class="inline-block bg-yellow-50 border-2 border-yellow-200 rounded-xl p-6 mb-6">
                        <p class="text-yellow-800 font-semibold">⏳ Menunggu Penilaian dari Guru</p>
                    </div>
                @endif
                <div class="flex justify-center gap-4">
                    <a href="{{ route('siswa.submissions.show', $existingSubmission->id_submission) }}" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md">
                        Lihat Detail Jawaban
                    </a>
                    <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>
        @else
        <div class="bg-white rounded-3xl shadow-xl p-8">
            @if($assignment->tipe === 'pilihan_ganda')
                <form method="POST" action="{{ route('siswa.assignments.submit', $assignment->id_assignment) }}">
                    @csrf
                    @foreach($assignment->questions->sortBy('urutan') as $index => $question)
                        <div class="mb-8 pb-8 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                {{ $index + 1 }}. {{ $question->soal }}
                                <span class="text-sm text-gray-500">({{ $question->poin }} poin)</span>
                            </h3>
                            <div class="space-y-3">
                                @foreach($question->options as $optIndex => $option)
                                    <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-xl hover:border-indigo-500 hover:bg-indigo-50 cursor-pointer transition">
                                        <input type="radio" name="answers[{{ $question->id_question }}]" value="{{ $option->id_option }}" class="w-5 h-5 text-indigo-600" required>
                                        <span class="text-gray-800">{{ chr(65 + $optIndex) }}. {{ $option->pilihan }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md">
                            Submit Jawaban
                        </button>
                    </div>
                </form>
            @elseif($assignment->tipe === 'essay')
                <form method="POST" action="{{ route('siswa.assignments.submit', $assignment->id_assignment) }}">
                    @csrf
                    @foreach($assignment->questions as $index => $question)
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-900 mb-4">
                                {{ $index + 1 }}. {{ $question->soal }}
                                <span class="text-sm text-gray-500">({{ $question->poin }} poin)</span>
                            </h3>
                            <textarea name="answers[{{ $question->id_question }}]" rows="6" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500" placeholder="Tulis jawabanmu di sini..." required></textarea>
                        </div>
                    @endforeach

                    <div class="flex justify-end gap-4 mt-8">
                        <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md">
                            Submit Jawaban
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 mb-4">Tugas praktik - Upload file jawabanmu</p>
                    <form method="POST" action="{{ route('siswa.assignments.submit', $assignment->id_assignment) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="max-w-xl mx-auto">
                            <input type="file" name="file" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 mb-4" required>
                            <textarea name="jawaban" rows="4" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 mb-4" placeholder="Catatan tambahan (opsional)"></textarea>
                            <div class="flex justify-center gap-4">
                                <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                                    Batal
                                </a>
                                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md">
                                    Submit Tugas
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        </div>
        @endif
    </div>
</body>
</html>
