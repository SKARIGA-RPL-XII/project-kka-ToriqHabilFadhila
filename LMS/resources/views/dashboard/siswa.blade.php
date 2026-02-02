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

        @keyframes draw {
            to { stroke-dashoffset: 0; }
        }
        .animate-draw {
            animation: draw 0.5s ease forwards;
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

    <nav class="w-full bg-white shadow-sm relative z-10">
        <div class="w-full px-4 sm:px-6 md:px-16 py-2 sm:py-3">
            <div class="flex items-center justify-between">
                <!-- LOGO -->
                <div class="flex items-center gap-2 sm:gap-3">
                    <img src="/images/LMS.png" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full object-cover">
                </div>

                <!-- RIGHT MENU -->
                <div class="flex items-center gap-2 sm:gap-3 text-sm">
                    @auth
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
                    @endauth

                    <!-- JOIN CLASS BUTTON -->
                    <button onclick="openJoinClassModal()"
                            class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md"
                            title="Join Kelas">
                        <!-- Icon SVG - Selalu tampil -->
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        <!-- Text - Hidden di Mobile, tampil di Desktop -->
                        <span class="hidden sm:inline">Join Kelas</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-black/10"></div>
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <span class="absolute top-10 left-1/2 -translate-x-1/2 text-white/30 text-6xl animate-float-slow pointer-events-none z-0">✦</span>
            <span class="absolute top-48 right-48 text-white/35 text-4xl animate-float">✦</span>
            <span class="absolute bottom-32 left-1/3 text-white/35 text-4xl animate-float-reverse">✦</span>
            <span class="absolute top-28 right-1/4 text-white/30 text-3xl animate-float-slow">✦</span>
            <span class="absolute top-24 right-20 w-3 h-3 bg-white/40 rounded-full blur-sm animate-pulse"></span>
            <span class="absolute bottom-24 right-1/3 w-2.5 h-2.5 bg-white/40 rounded-full blur-sm animate-pulse"></span>
        </div>
        <div class="relative w-full px-4 sm:px-6 md:px-16 py-16 sm:py-20 text-center">
            <div class="grid grid-cols-1 lg:grid-cols-2 items-center gap-10">
                <!-- KIRI: TEXT -->
                <div class="text-left relative">
                    <span class="inline-flex items-center gap-2 mb-4 px-5 py-2 text-base font-semibold rounded-full bg-white/20 text-indigo-100 backdrop-blur">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18s-3.332.477-4.5 1.253"/>
                        </svg>
                        Learning Management System
                    </span>
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">
                        Selamat Datang, <span class="text-yellow-300">{{ auth()->user()->nama }}!</span>
                    </h2>
                    <p class="text-lg sm:text-xl mb-8 text-indigo-100 max-w-xl">
                        Ikuti kelas, pelajari materi, kerjakan tugas, dan pantau progres belajarmu dengan lebih terarah dan modern.
                    </p>
                </div>
                <div class="hidden lg:block absolute bottom-0 right-0  translate-x-[-60px] pointer-events-none">
                    <img src="/SVG/Education.svg" alt="Student Dashboard Illustration" class="w-[320px] xl:w-[360px] 2xl:w-[400px] h-auto">
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Quick Actions -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Aktivitas Pembelajaran</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Lihat Tugas Card -->
                <button class="group relative p-6 bg-white rounded-2xl border-2 border-gray-100 hover:border-indigo-500 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <!-- Decorative background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-indigo-500/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition-colors">Lihat Tugas</h3>
                        <p class="text-sm text-gray-500 mb-3">Tugas yang perlu diselesaikan</p>
                        <!-- Badge/Indicator -->
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-indigo-50 text-indigo-600 text-xs font-semibold">
                            <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2 animate-pulse"></span>
                            5 Pending
                        </div>
                    </div>

                    <!-- Arrow Icon -->
                    <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>

                <!-- Kuis Card -->
                <button class="group relative p-6 bg-white rounded-2xl border-2 border-gray-100 hover:border-purple-500 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <!-- Decorative background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-purple-500/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors">Kuis Interaktif</h3>
                        <p class="text-sm text-gray-500 mb-3">Uji pemahamanmu dengan kuis</p>

                        <!-- Badge/Indicator -->
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-purple-50 text-purple-600 text-xs font-semibold">
                            <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            3 Tersedia
                        </div>
                    </div>

                    <!-- Arrow Icon -->
                    <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>

                <!-- Progress Card -->
                <button class="group relative p-6 bg-white rounded-2xl border-2 border-gray-100 hover:border-green-500 hover:shadow-2xl transition-all duration-300 overflow-hidden">
                    <!-- Decorative background gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-green-50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <div class="relative">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-green-500/30">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">Progress Belajar</h3>
                        <p class="text-sm text-gray-500 mb-3">Pantau pencapaian belajarmu</p>

                        <!-- Progress Bar -->
                        <div class="w-full bg-gray-100 rounded-full h-2 mb-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-500 group-hover:w-[75%]" style="width: 65%"></div>
                        </div>
                        <p class="text-xs font-semibold text-green-600">65% Selesai</p>
                    </div>

                    <!-- Arrow Icon -->
                    <div class="absolute top-6 right-6 opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300">
                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </button>
            </div>
        </div>

        <!-- Kelas Saya -->
        <div x-data="{ showAll: false }" class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Kelas Saya</h2>
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

                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    {{ $kelas->enrollments->count() }} siswa
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

        <!-- Tugas Terbaru -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Tugas Terbaru</h2>
                <a href="#" class="text-indigo-600 hover:text-indigo-700 font-semibold flex items-center gap-1">
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
                                <span class="px-3 py-1.5 bg-red-100 text-red-700 text-xs font-bold rounded-full">⏰ Deadline: 2 hari lagi</span>
                                <span class="px-3 py-1.5 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">Matematika</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Latihan Soal Persamaan Linear</h3>
                            <p class="text-sm text-gray-600 mb-4">Kerjakan 15 soal tentang persamaan linear dua variabel</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    28 Jan 2025
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    15 soal
                                </div>
                            </div>
                        </div>
                        <button class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md hover:shadow-lg">
                            Kerjakan
                        </button>
                    </div>
                </div>

                <!-- Assignment 2 -->
                <div class="p-6 border-b border-gray-100 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-bold rounded-full">⏰ Deadline: 5 hari lagi</span>
                                <span class="px-3 py-1.5 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">Bahasa Inggris</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Essay: My Favorite Book</h3>
                            <p class="text-sm text-gray-600 mb-4">Tulis essay minimal 200 kata tentang buku favoritmu</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    31 Jan 2025
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Essay 200+ kata
                                </div>
                            </div>
                        </div>
                        <button class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition font-semibold shadow-md hover:shadow-lg">
                            Kerjakan
                        </button>
                    </div>
                </div>

                <!-- Assignment 3 (Completed) -->
                <div class="p-6 hover:bg-gray-50 transition">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">✓ Selesai</span>
                                <span class="px-3 py-1.5 bg-green-100 text-green-700 text-xs font-bold rounded-full">IPA</span>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Laporan Praktikum Fisika</h3>
                            <p class="text-sm text-gray-600 mb-4">Upload laporan hasil praktikum hukum Newton</p>
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="font-semibold text-green-600">Nilai: 90/100</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Submitted: 20 Jan 2025
                                </div>
                            </div>
                        </div>
                        <button class="px-6 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-red-100 animate-warning">
                    <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                    </svg>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">
                    Logout sekarang?
                </h3>
                <p class="text-gray-600">
                    Kamu harus login lagi untuk mengakses dashboard.
                </p>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-3 px-6 pb-6">
                <button onclick="closeLogoutModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Batal
                </button>
                <button onclick="handleLogout()" class="flex-1 rounded-xl bg-gradient-to-r from-red-600 to-red-700 px-4 py-3 font-semibold text-white hover:from-red-700 hover:to-red-800 transition shadow-md">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <!-- Join Class Modal -->
    <div id="joinClassModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <!-- Close Button -->
            <button onclick="closeJoinClassModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Header -->
            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">
                    Gabung Kelas
                </h3>
                <p class="text-gray-600">
                    Masukkan token kelas dari guru untuk mulai belajar.
                </p>
            </div>

            <!-- Form -->
            <form action="{{ route('siswa.join') }}" method="POST" class="px-6 pt-6">
                @csrf
                <label class="block text-sm font-semibold text-gray-900 mb-2">
                    Token Kelas
                </label>
                <input type="text" name="token" id="classToken" placeholder="Contoh: KLS-8A23" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition" required>
                <p class="mt-2 text-xs text-gray-500">
                    Token bersifat unik dan hanya berlaku untuk satu kelas.
                </p>
                <!-- Actions -->
                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-6 pb-6">
                    <button type="button" onclick="closeJoinClassModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3 font-semibold text-white hover:from-indigo-700 hover:to-purple-700 transition shadow-md">
                        Join Kelas
                    </button>
                </div>
            </form>
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

        // Logout Modal
        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Join Class Modal
        function openJoinClassModal() {
            const modal = document.getElementById('joinClassModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeJoinClassModal() {
            const modal = document.getElementById('joinClassModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function handleJoinClass(event) {
            event.preventDefault();
            const token = document.getElementById('classToken').value;
            console.log('Joining class with token:', token);
            // Add your join class logic here
            closeJoinClassModal();
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeLogoutModal();
                closeJoinClassModal();
            }
        });

        // Close modal when clicking backdrop
        document.getElementById('logoutModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeLogoutModal();
            }
        });

        document.getElementById('joinClassModal')?.addEventListener('click', function(event) {
            if (event.target === this) {
                closeJoinClassModal();
            }
        });
    </script>
</body>
</html>
