<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Desktop Modal Animation - Scale from center */
        @keyframes modalDesktop {
            0% {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.9);
            }
            100% {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        /* Mobile Modal Animation - Slide from bottom */
        @keyframes modalMobile {
            0% {
                transform: translateY(100%);
            }
            100% {
                transform: translateY(0);
            }
        }

        /* Backdrop Fade */
        @keyframes backdropFade {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Warning Float Animation */
        @keyframes warningFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        /* Desktop Modal Styles */
        .modal-desktop {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation: modalDesktop 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Mobile Modal Styles */
        @media (max-width: 640px) {
            .modal-mobile {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                top: auto;
                transform: none;
                animation: modalMobile 0.3s cubic-bezier(0.22, 1, 0.36, 1) forwards;
            }
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
            100% { transform: translateY(0); }
        }

        @keyframes floatSlow {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }

        @keyframes floatReverse {
            0% { transform: translateY(0); }
            50% { transform: translateY(10px); }
            100% { transform: translateY(0); }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-slow {
            animation: floatSlow 9s ease-in-out infinite;
        }

        .animate-float-reverse {
            animation: floatReverse 7s ease-in-out infinite;
        }

        .animate-backdrop {
            animation: backdropFade 0.2s ease-out forwards;
        }

        .animate-warning {
            animation: warningFloat 1.6s ease-in-out infinite;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="bg-gray-50">
    @include('components.notifications')
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <span class="absolute top-10 left-1/2 -translate-x-1/2 text-white/30 text-6xl animate-float-slow pointer-events-none z-0">✦</span>
            <span class="absolute top-48 right-48 text-white/35 text-4xl animate-float">✦</span>
            <span class="absolute bottom-32 left-1/3 text-white/35 text-4xl animate-float-reverse">✦</span>
        </div>
        <div class="relative w-full px-4 sm:px-6 md:px-16 py-16 sm:py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-10">
                <!-- KIRI: TEXT -->
                <div class="text-left relative">
                    <span class="inline-flex items-center gap-2 mb-4 px-5 py-2 text-base font-semibold rounded-full bg-white/20 text-purple-100 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Panel Manajemen Guru
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                        Selamat Datang, <span class="text-yellow-300">{{ auth()->user()->nama }}!</span>
                    </h2>
                    <p class="text-lg sm:text-xl mb-8 text-purple-100 max-w-xl">
                        Kelola kelas, upload materi pembelajaran, buat tugas & quiz, dan pantau progress siswa dengan mudah.
                    </p>
                </div>
                <div class="hidden lg:block absolute bottom-0 right-0 translate-x-[-60px] pointer-events-none">
                    <img src="/SVG/Education.svg" alt="Teacher Dashboard" class="w-[320px] xl:w-[360px] 2xl:w-[400px] h-auto opacity-90">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Quick Actions -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Menu Utama</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Buat Kelas -->
                <button onclick="openCreateClassModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-purple-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Buat Kelas</h3>
                    <p class="text-sm text-gray-500">Tambah kelas baru</p>
                </button>

                <!-- Upload Materi -->
                <button onclick="openUploadMateriModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Upload Materi</h3>
                    <p class="text-sm text-gray-500">Tambah materi baru</p>
                </button>

                <!-- Buat Tugas/Quiz -->
                <button onclick="openCreateTugasModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Buat Tugas</h3>
                    <p class="text-sm text-gray-500">Tugas & Quiz baru</p>
                </button>

                <!-- Lihat Jawaban -->
                <button onclick="openJawabanSiswaModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-orange-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-orange-500 to-orange-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Lihat Jawaban</h3>
                    <p class="text-sm text-gray-500">Review & feedback</p>
                </button>
            </div>
        </div>

        <!-- Kelas yang Diampu -->
        <div x-data="{ showAll: false }" class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelas yang Diampu</h2>
                <button @click="showAll = !showAll" class="text-indigo-600 hover:text-indigo-700 font-semibold flex items-center gap-1">
                    <span x-text="showAll ? 'Lihat Sedikit' : 'Lihat Semua'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!showAll" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        <path x-show="showAll" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($classes as $index => $kelas)
                <div x-show="showAll || {{ $index }} < 3" x-cloak class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1">
                    <!-- Class Card 1 -->
                    <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 transform hover:-translate-y-1">
                        <div class="h-36 bg-gradient-to-br from-blue-500 to-indigo-600 relative">
                            <div class="absolute inset-0 bg-black/10"></div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $kelas->nama_kelas }}</span>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $kelas->deskripsi }}</h3>
                            <p class="text-sm text-gray-600 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $kelas->creator->nama ?? 'Guru' }}
                            </p>

                            <p class="text-sm text-gray-600 mb-4">
                                Token:
                                <span class="font-mono font-bold text-blue-600">
                                    {{ $kelas->activeToken->token_code ?? '-' }}
                                </span>
                            </p>

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    {{ $kelas->enrollments->count() }} /
                                    {{ $kelas->max_students }} Siswa
                                </div>
                                <a href="{{ route('guru.classes.show', $kelas->id_class) }}" class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-1">
                                    Buka
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                    <p class="text-gray-500 col-span-3">
                        Kamu belum join kelas apa pun.
                    </p>
                @endforelse
            </div>
        </div>

        <!-- Tugas & Quiz Aktif -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Tugas & Quiz Aktif</h2>
                <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold flex items-center gap-1">
                    Lihat Semua
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                @forelse($assignments as $assignment)
                <div class="p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $assignment->class->nama_kelas }}</span>
                                <span class="px-3 py-1.5
                                    @if($assignment->tipe === 'essay') bg-green-100 text-green-700
                                    @elseif($assignment->tipe === 'pilihan_ganda') bg-orange-100 text-orange-700
                                    @else bg-purple-100 text-purple-700
                                    @endif
                                    text-xs font-bold rounded-full">
                                    @if($assignment->tipe === 'essay') 📝 Essay
                                    @elseif($assignment->tipe === 'pilihan_ganda') 🎯 Pilihan Ganda
                                    @else 💻 Praktik
                                    @endif
                                </span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $assignment->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ $assignment->deskripsi }} • Deadline: {{ $assignment->deadline->format('d M Y, H:i') }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                @php
                                    $submissionCount = \App\Models\Submission::where('id_assignment', $assignment->id_assignment)->count();
                                    $totalStudents = $assignment->class->enrollments->count();
                                @endphp
                                <div class="flex items-center gap-1.5 text-blue-600 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $submissionCount }}/{{ $totalStudents }} siswa mengumpulkan
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('guru.assignments.submissions', $assignment->id_assignment) }}" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                            Lihat Jawaban
                        </a>
                        <button onclick="openEditDeadlineModal({{ $assignment->id_assignment }}, '{{ $assignment->deadline->format('Y-m-d\TH:i') }}')" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                            Edit Deadline
                        </button>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="font-semibold mb-1">Belum ada tugas aktif</p>
                    <p class="text-sm">Buat tugas baru untuk siswa Anda</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Materi yang Diupload -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Materi yang Diupload</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                @forelse($materials as $material)
                <div class="p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $material->class->nama_kelas }}</span>
                                <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">📚 Materi</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $material->judul }}</h3>
                            <p class="text-sm text-gray-600 mb-4">{{ Str::limit($material->konten, 100) }} • Diupload: {{ $material->created_at->format('d M Y, H:i') }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                @if($material->file_path)
                                <div class="flex items-center gap-1.5 text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                    </svg>
                                    {{ pathinfo($material->file_path, PATHINFO_EXTENSION) }} File
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @if($material->file_path)
                            <a href="{{ Storage::url($material->file_path) }}" target="_blank" class="px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                                Download
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <p class="font-semibold mb-1">Belum ada materi</p>
                    <p class="text-sm">Upload materi pembelajaran untuk siswa Anda</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Modal: Buat Kelas -->
    <div id="createClassModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeCreateClassModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Kelas Baru</h3>
                <p class="text-gray-600">Isi informasi kelas untuk generate token</p>
            </div>

            <form method="POST" action="{{ route('guru.classes.store') }}" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Kelas</label>
                    <input type="text" name="nama_kelas" placeholder="Contoh: 8A" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi Matapelajaran</label>
                    <input type="text" name="deskripsi" placeholder="Contoh: Matematika, IPA, Bahasa Inggris, dsb" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Maksimal Siswa</label>
                    <input type="number" name="max_students" value="50" min="1" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeCreateClassModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-600 px-4 py-3 font-semibold text-white hover:from-purple-700 hover:to-indigo-700 transition shadow-md">
                        Buat Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Token Modal -->
    <div id="tokenModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-50 hidden z-50">
        <div class="bg-white rounded-xl w-96 p-6 shadow-lg">
            <h2 class="text-lg font-semibold mb-4 text-center">Token Kelas</h2>
            <div class="text-center text-2xl font-mono mb-6 p-4 bg-gray-100 rounded-lg" id="tokenValue">TOKEN123</div>
            <div class="flex justify-center">
                <button onclick="closeTokenModal()" class="px-6 py-2 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Upload Materi -->
    <div id="uploadMateriModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeUploadMateriModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Upload Materi</h3>
                <p class="text-gray-600">Upload file materi pembelajaran untuk siswa</p>
            </div>

            <form method="POST" action="{{ route('guru.materials.store') }}" enctype="multipart/form-data" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Kelas</label>
                    <select name="id_class" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        @foreach($classes as $kelas)
                            <option value="{{ $kelas->id_class }}">{{ $kelas->nama_kelas }} - {{ $kelas->deskripsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Materi</label>
                    <input type="text" name="judul" placeholder="Contoh: Persamaan Linear" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Konten (Opsional)</label>
                    <textarea name="konten" rows="3" placeholder="Deskripsi materi..." class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">
                        Upload File
                    </label>

                    <div id="dropzone" class="relative flex flex-col items-center justify-center w-full h-40 rounded-2xl border-2 border-dashed border-gray-300 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
                        <input
                            id="fileInput"
                            type="file"
                            name="file"
                            accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.zip"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                        <svg
                            class="w-10 h-10 text-gray-400 mb-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M12 12v6m0 0l-3-3m3 3l3-3"/>
                        </svg>
                        <p class="text-sm text-gray-600 font-medium">
                            Drag & drop file di sini
                        </p>
                        <p class="text-xs text-gray-500">
                            atau klik untuk memilih file
                        </p>
                    </div>
                    <p id="fileName" class="mt-2 text-sm text-gray-700 hidden"></p>
                    <p class="text-xs text-gray-500 mt-1">
                        PDF, DOC, PPT, XLS, ZIP (Max 10MB)
                    </p>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeUploadMateriModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 font-semibold text-white hover:from-blue-700 hover:to-indigo-700 transition shadow-md">
                        Upload Materi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Buat Tugas/Quiz -->
    <div id="createTugasModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeCreateTugasModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-green-500 to-green-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Tugas / Quiz</h3>
                <p class="text-gray-600">Tambahkan tugas atau quiz baru untuk siswa</p>
            </div>

            <form method="POST" action="{{ route('guru.assignments.store') }}" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe</label>
                    <select name="tipe" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                        <option value="essay">📝 Essay</option>
                        <option value="pilihan_ganda">🎯 Pilihan Ganda</option>
                        <option value="praktik">💻 Praktik</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Kelas</label>
                    <select name="id_class" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                        @foreach($classes as $kelas)
                            <option value="{{ $kelas->id_class }}">{{ $kelas->nama_kelas }} - {{ $kelas->deskripsi }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul</label>
                    <input type="text" name="judul" placeholder="Contoh: Latihan Persamaan Linear" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan tugas/quiz ini..." class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deadline</label>
                    <input type="datetime-local" name="deadline" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nilai Maksimal</label>
                    <input type="number" name="max_score" value="100" min="1" max="100" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeCreateTugasModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-green-600 to-teal-600 px-4 py-3 font-semibold text-white hover:from-green-700 hover:to-teal-700 transition shadow-md">
                        Buat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Deadline -->
    <div id="editDeadlineModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeEditDeadlineModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Edit Deadline</h3>
                <p class="text-gray-600">Ubah deadline tugas untuk mengaktifkan kembali</p>
            </div>

            <form id="editDeadlineForm" method="POST" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deadline Baru</label>
                    <input type="datetime-local" id="deadlineInput" name="deadline" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition" required>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeEditDeadlineModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-orange-500 to-orange-600 px-4 py-3 font-semibold text-white hover:from-orange-600 hover:to-orange-700 transition shadow-md">
                        Update Deadline
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Lihat Jawaban Siswa -->
    <div id="jawabanSiswaModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-2xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeJawabanSiswaModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Jawaban Siswa</h3>
                <p class="text-gray-600">Latihan Persamaan Linear - Matematika 8A</p>
            </div>

            <div class="px-6 py-4">
                <!-- Student Answer 1 -->
                <div class="mb-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                A
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Ahmad Fadli</h4>
                                <p class="text-xs text-gray-500">Dikumpulkan: 26 Jan 2025, 14:30</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓ Sudah dinilai</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Nilai: <span class="font-bold text-green-600">90/100</span></p>
                        <button class="text-purple-600 hover:text-purple-700 font-semibold text-sm">Lihat Detail →</button>
                    </div>
                </div>

                <!-- Student Answer 2 -->
                <div class="mb-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-semibold">
                                S
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Siti Nurhaliza</h4>
                                <p class="text-xs text-gray-500">Dikumpulkan: 26 Jan 2025, 15:00</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">⏳ Perlu dinilai</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Status: <span class="font-semibold text-yellow-600">Menunggu penilaian</span></p>
                        <button class="text-purple-600 hover:text-purple-700 font-semibold text-sm">Review →</button>
                    </div>
                </div>

                <!-- Student Answer 3 -->
                <div class="mb-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold">
                                B
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Budi Santoso</h4>
                                <p class="text-xs text-gray-500">Dikumpulkan: 27 Jan 2025, 08:15</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓ Sudah dinilai</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Nilai: <span class="font-bold text-green-600">85/100</span></p>
                        <button class="text-purple-600 hover:text-purple-700 font-semibold text-sm">Lihat Detail →</button>
                    </div>
                </div>

                <!-- Not Submitted Students -->
                <div class="mt-6 p-4 bg-red-50 rounded-xl border border-red-200">
                    <h4 class="font-semibold text-red-800 mb-2 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        Belum Mengumpulkan (14 siswa)
                    </h4>
                    <p class="text-sm text-red-700">Andi, Dewi, Eko, Fitri, Gilang, Hana, Indra, Joko, Kirana, Lina, Mira, Nanda, Omar, Putri</p>
                </div>
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeJawabanSiswaModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 animate-warning">
                    <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Logout sekarang?</h3>
                <p class="text-gray-600">Anda harus login lagi untuk mengakses dashboard guru.</p>
            </div>
            <div class="flex flex-col-reverse sm:flex-row gap-3 px-6 pb-6">
                <button onclick="closeLogoutModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Batal
                </button>
                <form action="{{ route('logout') }}" method="POST" class="flex-1">
                    @csrf
                    <button
                        type="submit"
                        class="w-full rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 font-semibold text-white hover:from-red-700 hover:to-red-800 transition shadow-md">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @if(session('newNotification'))
    <script>
        if ('Notification' in window && Notification.permission === 'granted') {
            showNotification('{{ session('newNotification.title') }}', '{{ session('newNotification.message') }}');
        }
    </script>
    @endif

    @if(session('token'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tokenModal = document.getElementById('tokenModal');
            const tokenValue = document.getElementById('tokenValue');
            if (tokenModal && tokenValue) {
                tokenValue.textContent = '{{ session('token') }}';
                tokenModal.classList.remove('hidden');
                tokenModal.classList.add('flex');
            }
        });
    </script>
    @endif
</body>
</html>
