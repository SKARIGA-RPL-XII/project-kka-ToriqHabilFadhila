<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        body::-webkit-scrollbar {
            display: none;
        }

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
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-5 right-5 z-50 flex items-start gap-3 bg-red-50 border border-red-400 text-red-700 px-6 py-4 rounded-xl shadow-lg" style="display: none;">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" stroke-dasharray="62.8" stroke-dashoffset="62.8" class="animate-draw"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <div>
                <h4 class="font-semibold text-red-800 mb-1">Terjadi Kesalahan</h4>
                <ul class="text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Success Popup -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-50 border border-green-400 text-green-700 px-6 py-4 rounded-xl shadow-lg" style="display: none;">
            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 13l4 4L19 7" stroke-dasharray="22" stroke-dashoffset="22" class="animate-draw"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Navbar -->
    <nav class="w-full bg-white shadow-sm relative z-10">
        <div class="w-full px-4 sm:px-6 md:px-16 py-2 sm:py-3">
            <div class="flex items-center justify-between">
                <!-- LOGO -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <img src="/images/LMS.png" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full object-cover">
                    <span class="hidden sm:inline text-lg font-bold text-gray-900">Dashboard Guru</span>
                </div>

                <!-- RIGHT MENU -->
                <div class="flex items-center gap-2 sm:gap-3 text-sm">
                    <!-- USER DROPDOWN -->
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 rounded-lg px-2 py-1.5 transition">
                            <!-- Avatar -->
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                            <!-- Nama User - Hidden di Mobile -->
                            <span class="hidden sm:inline text-gray-700 font-medium">
                                {{ auth()->user()->nama }}
                            </span>
                            <!-- Chevron - Hidden di Mobile -->
                            <svg class="hidden sm:block w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <div id="userDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 hidden overflow-hidden z-50">
                            <a href="/profile" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <a href="/settings" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>
                            <div class="h-px bg-gray-200 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}" id="logoutForm">
                                @csrf
                                <button type="submit" onclick="openLogoutModal()" class="w-full flex items-center gap-3 text-left px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- CREATE CLASS BUTTON -->
                    <button onclick="openCreateClassModal()" class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-purple-600 text-white font-semibold hover:bg-purple-700 transition shadow-md" title="Buat Kelas Baru">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        <span class="hidden sm:inline">Buat Kelas</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

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
                                    {{ $kelas->max_students }} siswa
                                </div>
                                <button class="text-indigo-600 hover:text-indigo-700 font-semibold text-sm flex items-center gap-1">
                                    Buka
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
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
        <div>
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
                <!-- Assignment 1 -->
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Matematika 8A</span>
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">📝 Tugas</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Latihan Persamaan Linear</h3>
                            <p class="text-sm text-gray-600 mb-4">15 soal • Deadline: 28 Jan 2025</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-1.5 text-blue-600 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    18/32 siswa mengumpulkan
                                </div>
                            </div>
                        </div>
                        <button onclick="openJawabanSiswaModal()" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                            Lihat Jawaban
                        </button>
                    </div>
                </div>

                <!-- Assignment 2 -->
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">Matematika 8B</span>
                                <span class="px-3 py-1.5 bg-orange-100 text-orange-700 text-xs font-bold rounded-full">🎯 Quiz</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Quiz Trigonometri Dasar</h3>
                            <p class="text-sm text-gray-600 mb-4">10 soal pilihan ganda • Deadline: 30 Jan 2025</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-1.5 text-orange-600 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    5/28 siswa mengerjakan
                                </div>
                            </div>
                        </div>
                        <button onclick="openJawabanSiswaModal()" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                            Lihat Jawaban
                        </button>
                    </div>
                </div>

                <!-- Assignment 3 -->
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">Matematika 9A</span>
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">📝 Tugas</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Soal Cerita Matematika</h3>
                            <p class="text-sm text-gray-600 mb-4">8 soal cerita • Deadline: 2 Feb 2025</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm">
                                <div class="flex items-center gap-1.5 text-green-600 font-semibold">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    30/30 siswa mengumpulkan
                                </div>
                            </div>
                        </div>
                        <button onclick="openJawabanSiswaModal()" class="px-6 py-2.5 bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-xl hover:from-purple-700 hover:to-indigo-700 transition font-semibold shadow-md hover:shadow-lg whitespace-nowrap">
                            Lihat Jawaban
                        </button>
                    </div>
                </div>
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
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
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
    <div id="tokenModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
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

            <form class="px-6 pt-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Kelas</label>
                    <select class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option>Matematika 8A</option>
                        <option>Matematika 8B</option>
                        <option>Matematika 9A</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul Materi</label>
                    <input type="text" placeholder="Contoh: Persamaan Linear" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Upload File</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-500 transition cursor-pointer">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        <p class="text-sm text-gray-600 mb-1">Klik untuk upload file</p>
                        <p class="text-xs text-gray-500">PDF, DOC, PPT (Max 10MB)</p>
                        <input type="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx">
                    </div>
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

            <form class="px-6 pt-6 pb-6 space-y-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Tipe</label>
                    <select class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                        <option>📝 Tugas</option>
                        <option>🎯 Quiz</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Pilih Kelas</label>
                    <select class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                        <option>Matematika 8A</option>
                        <option>Matematika 8B</option>
                        <option>Matematika 9A</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Judul</label>
                    <input type="text" placeholder="Contoh: Latihan Persamaan Linear" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deskripsi</label>
                    <textarea rows="3" placeholder="Jelaskan tugas/quiz ini..." class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required></textarea>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Deadline</label>
                    <input type="date" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition" required>
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
                <button class="flex-1 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 font-semibold text-white hover:from-red-700 hover:to-red-800 transition shadow-md">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Dropdown Toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdown');
            if (!event.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }
        });

        // Modal Functions
        function openCreateClassModal() {
            document.getElementById('createClassModal').classList.remove('hidden');
            document.getElementById('createClassModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateClassModal() {
            document.getElementById('createClassModal').classList.add('hidden');
            document.getElementById('createClassModal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openUploadMateriModal() {
            document.getElementById('uploadMateriModal').classList.remove('hidden');
            document.getElementById('uploadMateriModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadMateriModal() {
            document.getElementById('uploadMateriModal').classList.add('hidden');
            document.getElementById('uploadMateriModal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openCreateTugasModal() {
            document.getElementById('createTugasModal').classList.remove('hidden');
            document.getElementById('createTugasModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeCreateTugasModal() {
            document.getElementById('createTugasModal').classList.add('hidden');
            document.getElementById('createTugasModal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openJawabanSiswaModal() {
            document.getElementById('jawabanSiswaModal').classList.remove('hidden');
            document.getElementById('jawabanSiswaModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeJawabanSiswaModal() {
            document.getElementById('jawabanSiswaModal').classList.add('hidden');
            document.getElementById('jawabanSiswaModal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openLogoutModal() {
            document.getElementById('logoutModal').classList.remove('hidden');
            document.getElementById('logoutModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.add('hidden');
            document.getElementById('logoutModal').classList.remove('flex');
            document.body.style.overflow = '';
        }

        function openTokenModal(token) {
            document.getElementById('tokenValue').innerText = token;
            document.getElementById('tokenModal').classList.remove('hidden');
        }

        function closeTokenModal() {
            document.getElementById('tokenModal').classList.add('hidden');
        }

        // Jika ada session token dari backend, buka modal otomatis
        @if(session('token'))
            window.addEventListener('DOMContentLoaded', () => {
                openTokenModal("{{ session('token') }}");
            });
        @endif

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeCreateClassModal();
                closeUploadMateriModal();
                closeCreateTugasModal();
                closeJawabanSiswaModal();
                closeLogoutModal();
            }
        });

        // Close modal when clicking backdrop
        ['createClassModal', 'uploadMateriModal', 'createTugasModal', 'jawabanSiswaModal', 'logoutModal'].forEach(modalId => {
            document.getElementById(modalId)?.addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                    this.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>
