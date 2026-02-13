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

    <section class="bg-gradient-to-br from-purple-600 via-indigo-600 to-blue-600 text-white relative overflow-hidden">
        <!-- Animated Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
            <div class="absolute top-0 right-0 w-96 h-96 bg-yellow-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute bottom-0 left-20 w-96 h-96 bg-orange-200 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
        </div>

        <!-- Floating Icons -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 animate-float">
                <svg class="w-12 h-12 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <div class="absolute top-40 right-20 animate-float-slow">
                <svg class="w-16 h-16 text-white/15" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                </svg>
            </div>
            <div class="absolute bottom-20 left-1/4 animate-float-reverse">
                <svg class="w-10 h-10 text-white/20" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"/><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"/>
                </svg>
            </div>
            <div class="absolute top-1/3 right-1/3 animate-pulse">
                <div class="w-4 h-4 bg-white/30 rounded-full"></div>
            </div>
            <div class="absolute bottom-1/3 right-1/4 animate-pulse animation-delay-1000">
                <div class="w-3 h-3 bg-yellow-300/40 rounded-full"></div>
            </div>
        </div>

        <div class="relative w-full px-4 sm:px-6 md:px-16 py-20 sm:py-24">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <!-- Left Content -->
                    <div class="space-y-6 text-center lg:text-left">
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/20 backdrop-blur-md border border-white/30">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-semibold">Panel Manajemen Guru</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                            Selamat Datang,<br>
                            <span class="bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-300 bg-clip-text text-transparent animate-gradient">
                                {{ Auth::user()?->nama ?? 'Admin' }}!
                            </span>
                        </h1>

                        <p class="text-lg sm:text-xl text-red-50 max-w-2xl">
                            Kelola kelas, upload materi pembelajaran, buat tugas & quiz, dan pantau progress siswa dengan mudah.
                        </p>

                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-4">
                            <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl">
                                <svg class="w-6 h-6 text-gray-800 dark:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 20v-9l-4 1.125V20h4Zm0 0h8m-8 0V6.66667M16 20v-9l4 1.125V20h-4Zm0 0V6.66667M18 8l-6-4-6 4m5 1h2m-2 3h2"/>
                                </svg>
                                <span class="text-sm font-medium">Manajemen Kelas</span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl">
                                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                                <span class="text-sm font-medium">Pantau Aktivitas Belajar</span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Illustration -->
                    <div class="hidden lg:flex justify-center items-center">
                        <div class="relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-orange-400 rounded-full blur-3xl opacity-20 animate-pulse"></div>
                            <img src="/SVG/Education.svg" alt="Admin Dashboard" class="relative w-full max-w-lg h-auto drop-shadow-2xl transform hover:scale-105 transition-transform duration-500">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Wave -->
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0Z" fill="rgb(249 250 251)"/>
            </svg>
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
        <div x-data="{ showAllAssignments: false }" class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Tugas & Quiz Aktif</h2>
                <button @click="showAllAssignments = !showAllAssignments" class="text-purple-600 hover:text-purple-700 font-semibold flex items-center gap-1">
                    <span x-text="showAllAssignments ? 'Lihat Sedikit' : 'Lihat Semua'"></span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!showAllAssignments" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        <path x-show="showAllAssignments" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                @forelse($assignments as $index => $assignment)
                <div x-show="showAllAssignments || {{ $index }} < 3" x-cloak class="p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $assignment->class->nama_kelas }}</span>
                                @if($assignment->tipe === 'essay')
                                    <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                @elseif($assignment->tipe === 'pilihan_ganda')
                                    <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                @else
                                    <span class="px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                @endif
                                    @if($assignment->tipe === 'essay')
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Essay
                                    @elseif($assignment->tipe === 'pilihan_ganda')
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                        </svg>
                                        Pilihan Ganda
                                    @else
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                        </svg>
                                        Praktik
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
                        <div class="flex gap-2">
                            <a href="{{ route('guru.assignments.submissions', $assignment->id_assignment) }}" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                                Lihat Jawaban
                            </a>
                            <button onclick="openEditDeadlineModal({{ $assignment->id_assignment }}, '{{ $assignment->deadline->format('Y-m-d\TH:i') }}')" class="px-6 py-2.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl hover:from-orange-600 hover:to-orange-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                                Edit Deadline
                            </button>
                            <button onclick="openDeleteAssignmentModal({{ $assignment->id_assignment }}, '{{ $assignment->judul }}')" class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl hover:from-red-600 hover:to-red-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                                Hapus
                            </button>
                        </div>
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

        <!-- Progress Belajar Siswa -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Progress Belajar Siswa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($classes as $kelas)
                    @php
                        $totalStudents = $kelas->enrollments->count();
                        $classAssignments = \App\Models\Assignment::where('id_class', $kelas->id_class)->get();
                        $totalAssignments = $classAssignments->count();
                        $totalSubmissions = \App\Models\Submission::whereIn('id_assignment', $classAssignments->pluck('id_assignment'))->count();
                        $avgScore = \App\Models\Submission::whereIn('id_assignment', $classAssignments->pluck('id_assignment'))->where('status', 'graded')->avg('score') ?? 0;
                        $completionRate = $totalAssignments > 0 && $totalStudents > 0 ? ($totalSubmissions / ($totalAssignments * $totalStudents)) * 100 : 0;
                    @endphp
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-xl transition">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-bold text-gray-900">{{ $kelas->nama_kelas }}</h3>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">{{ $totalStudents }} Siswa</span>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-600">Tingkat Penyelesaian</span>
                                    <span class="text-sm font-bold text-purple-600">{{ number_format($completionRate, 1) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 h-2.5 rounded-full" style="width: {{ $completionRate }}%"></div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-blue-50 rounded-xl p-3">
                                    <p class="text-xs text-blue-600 mb-1">Total Tugas</p>
                                    <p class="text-2xl font-bold text-blue-700">{{ $totalAssignments }}</p>
                                </div>
                                <div class="bg-green-50 rounded-xl p-3">
                                    <p class="text-xs text-green-600 mb-1">Rata-rata Nilai</p>
                                    <p class="text-2xl font-bold text-green-700">{{ number_format($avgScore, 1) }}</p>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('guru.classes.show', $kelas->id_class) }}" class="flex-1 text-center px-4 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold text-sm">
                                    Lihat Detail
                                </a>
                                <button onclick="openAskProgressModal({{ $kelas->id_class }}, '{{ $kelas->nama_kelas }}')" class="px-4 py-2.5 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl hover:from-pink-600 hover:to-rose-600 transition font-semibold text-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-3 bg-white rounded-2xl shadow-md border border-gray-100 p-8 text-center">
                        <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <p class="font-semibold text-gray-900 mb-1">Belum ada data progress</p>
                        <p class="text-sm text-gray-500">Buat kelas dan tugas untuk melihat progress siswa</p>
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
                                <span class="px-3 py-1.5 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Materi
                                </span>
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
        <div
            class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeCreateTugasModal()"
                class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div
                    class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-purple-600 to-pink-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Buat Tugas / Quiz</h3>
                <p class="text-gray-600">Tambahkan tugas atau quiz baru untuk siswa</p>
            </div>

            <form method="POST" action="{{ route('guru.assignments.store') }}" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                <input type="hidden" name="id_class" value="{{ $kelas->id_class }}">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="tipe" value="essay" class="peer sr-only" required>
                            <div class="p-4 text-center border-2 border-gray-300 rounded-xl transition-all peer-checked:border-green-500 peer-checked:bg-gradient-to-br peer-checked:from-green-50 peer-checked:to-emerald-50 peer-checked:shadow-md hover:border-green-400">
                                <div class="text-2xl mb-1">✍️</div>
                                <div class="text-xs font-semibold text-gray-700">Essay</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="tipe" value="pilihan_ganda" class="peer sr-only">
                            <div class="p-4 text-center border-2 border-gray-300 rounded-xl transition-all peer-checked:border-orange-500 peer-checked:bg-gradient-to-br peer-checked:from-orange-50 peer-checked:to-amber-50 peer-checked:shadow-md hover:border-orange-400">
                                <div class="text-2xl mb-1">✅</div>
                                <div class="text-xs font-semibold text-gray-700">Pilihan Ganda</div>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="tipe" value="praktik" class="peer sr-only">
                            <div class="p-4 text-center border-2 border-gray-300 rounded-xl transition-all peer-checked:border-purple-500 peer-checked:bg-gradient-to-br peer-checked:from-purple-50 peer-checked:to-pink-50 peer-checked:shadow-md hover:border-purple-400">
                                <div class="text-2xl mb-1">💻</div>
                                <div class="text-xs font-semibold text-gray-700">Praktik</div>
                            </div>
                        </label>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul</label>
                    <input type="text" name="judul" placeholder="Contoh: Latihan Persamaan Linear"
                        class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan tugas/quiz ini..."
                        class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deadline</label>
                    <input type="datetime-local" name="deadline"
                        class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nilai Maksimal</label>
                    <input type="number" name="max_score" value="100" min="1" max="100"
                        class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition"
                        required>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeCreateTugasModal()"
                        class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 rounded-xl bg-gradient-to-r from-purple-600 to-pink-600 px-4 py-3 font-semibold text-white hover:from-purple-700 hover:to-pink-700 transition shadow-md">
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
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Pilih Tugas</h3>
                <p class="text-gray-600">Pilih tugas untuk melihat jawaban siswa</p>
            </div>

            <div class="px-6 py-4">
                @forelse($assignments as $assignment)
                    <a href="{{ route('guru.assignments.submissions', $assignment->id_assignment) }}"
                        class="block mb-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-gray-900">{{ $assignment->judul }}</h4>
                                <p class="text-xs text-gray-500">{{ $assignment->class->nama_kelas }} - {{ $assignment->deskripsi }}</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500">Belum ada tugas</p>
                    </div>
                @endforelse
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeJawabanSiswaModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Tanya Progress Siswa -->
    <div id="askProgressModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-2xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeAskProgressModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 pb-4 border-b border-gray-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Tanya Progress Siswa</h3>
                        <p class="text-gray-600" id="modalClassName">Kelas</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4">
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Siswa</label>
                    <select id="studentSelect" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition">
                        <option value="">-- Pilih Siswa --</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pertanyaan Anda</label>
                    <textarea id="questionInput" rows="3" placeholder="Contoh: Bagaimana progress Ahmad dalam mengerjakan tugas?" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition"></textarea>
                </div>

                <button onclick="askAI()" id="askButton" class="w-full px-4 py-3 bg-gradient-to-r from-pink-500 to-rose-500 text-white rounded-xl hover:from-pink-600 hover:to-rose-600 transition font-semibold shadow-md flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Tanya AI
                </button>

                <div id="aiResponse" class="hidden mt-6 p-4 bg-gradient-to-br from-pink-50 to-rose-50 rounded-xl border-2 border-pink-200">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-pink-500 to-rose-500 flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-gray-900 mb-2">Analisis AI</h4>
                            <div id="aiResponseText" class="text-sm text-gray-700 whitespace-pre-wrap"></div>
                        </div>
                    </div>
                </div>

                <div id="aiLoading" class="hidden mt-6 p-4 bg-gray-50 rounded-xl text-center">
                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-4 border-pink-500 border-t-transparent"></div>
                    <p class="text-sm text-gray-600 mt-2">AI sedang menganalisis...</p>
                </div>
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeAskProgressModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Hapus Tugas -->
    <div id="deleteAssignmentModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 animate-warning">
                    <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Tugas?</h3>
                <p class="text-gray-600 mb-1">Tugas: <span id="deleteAssignmentTitle" class="font-semibold"></span></p>
                <p class="text-gray-600">Semua data soal dan jawaban siswa akan terhapus permanen.</p>
            </div>
            <div class="flex flex-col-reverse sm:flex-row gap-3 px-6 pb-6">
                <button onclick="closeDeleteAssignmentModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Batal
                </button>
                <form id="deleteAssignmentForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 font-semibold text-white hover:from-red-700 hover:to-red-800 transition shadow-md">
                        Ya, Hapus
                    </button>
                </form>
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
