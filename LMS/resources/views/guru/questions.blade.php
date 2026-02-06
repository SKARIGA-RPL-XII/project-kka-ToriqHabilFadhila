<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.5s ease-out;
        }
        .question-card {
            transition: all 0.3s ease;
        }
        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(139, 92, 246, 0.15);
        }
        .option-item {
            transition: all 0.2s ease;
        }
        .option-item:hover {
            background: linear-gradient(to right, #faf5ff, transparent);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @include('components.navbar')
    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Header Section -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-indigo-600 rounded-3xl shadow-2xl p-8 mb-8 text-white animate-fade-in-up overflow-hidden relative">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div class="relative z-10">
                <div class="flex items-start gap-4">
                    <a href="{{ route('dashboard') }}" class="p-2.5 hover:bg-white/20 rounded-xl transition-all duration-300 hover:scale-110 flex-shrink-0 mt-1" title="Kembali ke Dashboard">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2 leading-tight">
                            {{ $assignment->judul }}
                        </h1>
                        <div class="flex flex-wrap items-center gap-3 text-sm">
                            <span class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full font-medium">
                                {{ $assignment->class->nama_kelas }}
                            </span>
                            <span class="bg-white/20 backdrop-blur-sm px-3 py-1.5 rounded-full font-medium flex items-center gap-2">
                                @if ($assignment->tipe === 'pilihan_ganda')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                    Pilihan Ganda
                                @elseif($assignment->tipe === 'essay')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                    Essay
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M3 5a2 2 0 012-2h10a2 2 0 012 2v8a2 2 0 01-2 2h-2.22l.123.489.804.804A1 1 0 0113 18H7a1 1 0 01-.707-1.707l.804-.804L7.22 15H5a2 2 0 01-2-2V5zm5.771 7H5V5h10v7H8.771z" clip-rule="evenodd" />
                                    </svg>
                                    Praktik
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="animate-fade-in-up bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl mb-8 shadow-md flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <div>
                    <p class="font-semibold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <!-- Form Tambah Soal -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden mb-8 animate-fade-in-up">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-8 py-6 border-b border-purple-100">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-purple-600 rounded-xl">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Soal Baru</h2>
                </div>
            </div>

            <!-- Form Body -->
            <form method="POST" action="{{ route('guru.questions.store', $assignment->id_assignment) }}" id="questionForm" class="p-8">
                @csrf
                <div class="space-y-6">
                    <!-- Soal Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                            </svg>
                            Pertanyaan Soal
                        </label>
                        <textarea name="soal" rows="4" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all resize-none" placeholder="Tuliskan pertanyaan soal di sini..."></textarea>
                    </div>

                    <!-- Poin Input -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Poin
                        </label>
                        <input type="number" name="poin" value="10" min="1" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all">
                    </div>

                    <!-- Pilihan Jawaban (untuk Pilihan Ganda) -->
                    @if ($assignment->tipe === 'pilihan_ganda')
                        <div id="pilihanContainer">
                            <label class="block text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                                Pilihan Jawaban
                            </label>
                            <div class="space-y-3 bg-gray-50 p-4 rounded-xl" id="optionsList">
                                <div class="option-item flex gap-3 items-center bg-white p-3 rounded-lg border-2 border-gray-200 hover:border-purple-300 transition-all">
                                    <input type="radio" name="jawaban_benar" value="0" required class="w-5 h-5 text-purple-600 focus:ring-purple-500">
                                    <input type="text" name="pilihan[]" placeholder="Pilihan A" required class="flex-1 px-4 py-2 border-0 focus:ring-0 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-400">A</span>
                                </div>
                                <div class="option-item flex gap-3 items-center bg-white p-3 rounded-lg border-2 border-gray-200 hover:border-purple-300 transition-all">
                                    <input type="radio" name="jawaban_benar" value="1" required class="w-5 h-5 text-purple-600 focus:ring-purple-500">
                                    <input type="text" name="pilihan[]" placeholder="Pilihan B" required class="flex-1 px-4 py-2 border-0 focus:ring-0 bg-transparent">
                                    <span class="text-sm font-semibold text-gray-400">B</span>
                                </div>
                            </div>
                            <button type="button" onclick="addOption()" class="mt-3 inline-flex items-center gap-2 text-sm text-purple-600 hover:text-purple-700 font-semibold hover:bg-purple-50 px-4 py-2 rounded-lg transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Pilihan
                            </button>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <button type="submit" class="w-full bg-gradient-to-r from-purple-600 to-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Soal
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Soal -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in-up">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 px-8 py-6 border-b border-indigo-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-indigo-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Daftar Soal</h2>
                    </div>
                    <span class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                        Total: {{ $assignment->questions->count() }}
                    </span>
                </div>
            </div>

            <!-- Questions List -->
            <div class="p-6 space-y-4">
                @forelse($assignment->questions as $question)
                    <div class="question-card border-2 border-gray-200 rounded-2xl p-6 hover:border-purple-300" x-data="{ edit: false }">
                        <!-- VIEW MODE -->
                        <div x-show="!edit">
                            <div class="flex justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-start gap-3 mb-4">
                                        <span
                                            class="flex-shrink-0 w-8 h-8 bg-gradient-to-br from-purple-600 to-indigo-600 text-white rounded-lg flex items-center justify-center font-bold text-sm">
                                            {{ $loop->iteration }}
                                        </span>
                                        <p class="flex-1 font-semibold text-gray-800 text-lg leading-relaxed">
                                            {{ $question->soal }}
                                        </p>
                                    </div>

                                    @if ($assignment->tipe === 'pilihan_ganda')
                                        <div class="ml-11 space-y-2">
                                            @foreach ($question->options as $opt)
                                                <div class="flex items-start gap-3 p-3 rounded-lg {{ $opt->is_correct ? 'bg-green-50 border-2 border-green-300' : 'bg-gray-50' }}">
                                                    <span
                                                        class="flex-shrink-0 w-7 h-7 rounded-full {{ $opt->is_correct ? 'bg-green-600 text-white' : 'bg-gray-300 text-gray-600' }} flex items-center justify-center text-sm font-bold">
                                                        {{ chr(65 + $loop->index) }}
                                                    </span>
                                                    <span
                                                        class="flex-1 text-sm {{ $opt->is_correct ? 'text-green-800 font-semibold' : 'text-gray-700' }}">
                                                        {{ $opt->pilihan }}
                                                    </span>
                                                    @if ($opt->is_correct)
                                                        <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col gap-2">
                                    <span class="inline-flex items-center gap-1 px-3 py-1.5 text-sm font-bold text-purple-700 bg-purple-100 rounded-lg">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        {{ $question->poin }}
                                    </span>
                                    <button @click="edit=true" class="inline-flex items-center gap-1 px-4 py-2 text-sm font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- EDIT MODE -->
                        <form x-show="edit" method="POST"
                            action="{{ route('guru.questions.update', $question->id_question) }}" class="space-y-4">
                            @csrf
                            @method('PUT')
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Soal</label>
                                <textarea name="soal" rows="3" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none" required>{{ $question->soal }}</textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Poin</label>
                                <input type="number" name="poin" value="{{ $question->poin }}" class="w-full border-2 border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>

                            @if ($assignment->tipe === 'pilihan_ganda')
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-3">Pilihan Jawaban</label>
                                    <div class="space-y-2">
                                        @foreach ($question->options as $i => $opt)
                                            <div class="flex gap-3 items-center bg-gray-50 p-3 rounded-lg">
                                                <input type="radio" name="jawaban_benar" value="{{ $i }}" {{ $opt->is_correct ? 'checked' : '' }} class="w-5 h-5 text-purple-600 focus:ring-purple-500">
                                                <input type="text" name="pilihan[]" value="{{ $opt->pilihan }}" class="flex-1 border-2 border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                                <span class="text-sm font-semibold text-gray-400">{{ chr(65 + $i) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="flex gap-3 pt-4">
                                <button type="submit" class="flex-1 bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-purple-700 hover:to-indigo-700 transition-all hover:shadow-lg">
                                    Simpan Perubahan
                                </button>
                                <button type="button" @click="edit=false" class="px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 transition-all">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Soal</h3>
                        <p class="text-gray-500">
                            Gunakan form di atas untuk menambahkan soal pertama Anda
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        let optionCount = 2;
        function addOption() {
            const container = document.getElementById('optionsList');
            const div = document.createElement('div');
            div.className =
                'option-item flex gap-3 items-center bg-white p-3 rounded-lg border-2 border-gray-200 hover:border-purple-300 transition-all';
            div.innerHTML = `
                <input type="radio" name="jawaban_benar" value="${optionCount}" required class="w-5 h-5 text-purple-600 focus:ring-purple-500">
                <input type="text" name="pilihan[]" placeholder="Pilihan ${String.fromCharCode(65 + optionCount)}" required class="flex-1 px-4 py-2 border-0 focus:ring-0 bg-transparent">
                <button type="button" onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-700 hover:bg-red-50 p-2 rounded-lg transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
                <span class="text-sm font-semibold text-gray-400">${String.fromCharCode(65 + optionCount)}</span>
            `;
            container.appendChild(div);
            optionCount++;
        }
    </script>
</body>
</html>
