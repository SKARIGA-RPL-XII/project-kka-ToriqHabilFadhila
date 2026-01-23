<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .step {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 3px solid #e5e7eb;
            color: #9ca3af;
            transition: all 0.3s ease;
            position: relative;
            z-index: 10;
        }

        .step.active {
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%);
            border-color: #3b82f6;
            color: white;
            box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.4);
            transform: scale(1.1);
        }

        .step-detail {
            opacity: 0;
            pointer-events: none;
            transform: translateX(40px);
            transition: opacity 400ms ease, transform 400ms ease;
        }

        .step-detail.active {
            opacity: 1;
            pointer-events: auto;
            transform: translateX(0);
        }

        .step-detail.from-left {
            transform: translateX(-40px);
        }

        #step2.active {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border-color: #6366f1;
            box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.4);
        }

        #step3.active {
            background: linear-gradient(135deg, #8b5cf6 0%, #a855f7 100%);
            border-color: #8b5cf6;
            box-shadow: 0 10px 25px -5px rgba(139, 92, 246, 0.4);
        }

        .step:hover:not(.active) {
            border-color: #9ca3af;
            transform: scale(1.05);
        }
        @keyframes floatSlow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-float-slow {
            animation: floatSlow 6s ease-in-out infinite;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out both;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="w-full bg-white shadow-sm relative z-10">
        <div class="w-full px-4 sm:px-6 md:px-12 py-2 sm:py-3 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="/images/LMS.png" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full object-cover">
            </div>

            <div class="flex items-center gap-4 sm:gap-6 text-sm">
                {{-- MENU KANAN --}}
                @guest
                    <div class="flex items-center gap-2 sm:gap-4 text-xs sm:text-sm">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-500">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-2 py-1 sm:px-4 sm:py-2 bg-white text-blue-600 rounded-full hover:bg-blue-50">
                            Register
                        </a>
                    </div>
                @endguest

                @auth
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-1 sm:gap-2 focus:outline-none text-xs sm:text-sm">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline text-gray-600">
                                {{ auth()->user()->name }}
                            </span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="userDropdown" class="absolute right-0 mt-2 w-36 sm:w-40 bg-white rounded-xl shadow-lg border border-gray-100 hidden">
                            <a href="/profile" class="block px-4 py-2 text-sm text-gray-600 hover:bg-gray-50">
                                Profile
                            </a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Banner Section -->
    <section class="relative bg-cover bg-center h-[300px] sm:h-[400px] md:h-[500px] -mt-16" style="background-image: url('/images/LMS Banner.png');">
        <!-- Overlay gradasi -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/40 via-orange-500/30 to-green-500/30 flex flex-col justify-center items-start text-left text-white px-4 sm:px-8 md:px-16 pt-12 sm:pt-16 md:pt-24">
            <h1 class="text-2xl sm:text-3xl md:text-6xl font-bold mb-2 sm:mb-4">
                Selamat Datang di LMS Kami
            </h1>
            <p class="text-sm sm:text-lg md:text-2xl mb-4 sm:mb-6 max-w-xs sm:max-w-lg md:max-w-xl">
                Belajar jadi lebih mudah, kapan saja dan di mana saja, dengan platform digital yang terstruktur dan adaptif.
            </p>
        </div>
    </section>

    <main class="relative bg-gradient-to-b from-white via-blue-50/30 to-white pb-32">
        <!-- Decorative Background -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <!-- Blob kiri atas -->
            <div class=" absolute top-10 -left-24 w-60 h-60 sm:top-20 sm:-left-20 sm:w-96 sm:h-96 bg-gradient-to-br from-blue-400/30 to-indigo-400/30 rounded-full shape-blob animate-float"></div>
            <!-- Blob kanan atas (sembunyikan di mobile) -->
            <div class="hidden sm:block absolute top-40 -right-32 w-80 h-80 bg-gradient-to-br from-purple-400/30 to-pink-400/30 rounded-full shape-blob animate-float-slow"></div>
            <!-- Blob bawah (perkecil di mobile) -->
            <div class="absolute bottom-20 left-1/2 -translate-x-1/2 w-48 h-48 sm:bottom-40 sm:left-1/4 sm:translate-x-0 sm:w-72 sm:h-72 bg-gradient-to-br from-indigo-400/20 to-blue-400/20 rounded-full shape-blob animate-float"></div>
            <!-- Circle SVG (sembunyikan di mobile) -->
            <svg class="hidden md:block absolute top-32 right-10 w-24 h-24 text-blue-200 opacity-20 animate-float" viewBox="0 0 100 100">
                <circle cx="50" cy="50" r="40" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="50" cy="50" r="30" fill="none" stroke="currentColor" stroke-width="2"/>
                <circle cx="50" cy="50" r="20" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
            <!-- Triangle SVG -->
            <svg class="absolute bottom-16 left-4 w-20 h-20 sm:bottom-1/4 sm:left-10 sm:w-32 sm:h-32 text-indigo-200 opacity-20 animate-float-slow" viewBox="0 0 100 100">
                <polygon points="50,10 90,90 10,90" fill="none" stroke="currentColor" stroke-width="2"/>
                <polygon points="50,25 75,75 25,75" fill="none" stroke="currentColor" stroke-width="2"/>
            </svg>
        </div>
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12 md:py-16">
            <!-- HERO SECTION -->
            <section class="text-center mb-16 sm:mb-20">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-xs sm:text-sm font-semibold mb-6 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 sm:w-4 sm:h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Learning Management System Terdepan
                </div>

                <!-- Main Heading -->
                <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-4 sm:mb-6 leading-tight">
                    Platform Pembelajaran <br>
                    <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Berbasis AI
                    </span>
                </h1>

                <!-- Subheading -->
                <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-3xl mx-auto mb-6 sm:mb-8 leading-relaxed">
                    LMS berbasis AI yang membantu proses belajar menjadi lebih <span class="font-semibold text-gray-900">terarah</span>,
                    <span class="font-semibold text-gray-900">adaptif</span>, dan mudah diakses oleh siapa saja, kapan saja.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-8">
                    <a href="#fitur" class="group px-6 sm:px-8 py-3 sm:py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:scale-105 transition-all duration-300">
                        Coba Sekarang
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 sm:w-5 sm:h-5 inline-block ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                <!-- Trust Indicators -->
                <div class="flex flex-wrap items-center justify-center gap-6 text-xs sm:text-sm text-gray-500">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Gratis untuk Siswa</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>AI-Powered Learning</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span>Sertifikat Digital</span>
                    </div>
                </div>
            </section>


            <!-- FEATURES SECTION -->
            <section id="fitur" class="mb-16 sm:mb-24 px-4 sm:px-8 md:px-12">
                <div class="text-center mb-12 sm:mb-16">
                    <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs sm:text-sm font-semibold mb-2 sm:mb-4">
                        Fitur Unggulan
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-gray-900 mb-2 sm:mb-4">
                        Kenapa Memilih LMS Kami?
                    </h2>
                    <p class="text-sm sm:text-lg text-gray-600 max-w-xs sm:max-w-xl md:max-w-2xl mx-auto">
                        Dilengkapi dengan teknologi AI dan fitur-fitur modern untuk pengalaman belajar yang optimal.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 sm:gap-8">
                    <!-- Feature 1 -->
                    <div class="group p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 hover:border-blue-300 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 sm:hover:-translate-y-2">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-105 sm:group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-900">Materi Terstruktur</h3>
                        <p class="text-sm sm:text-gray-600 leading-relaxed">
                            Kelola modul, video, dan dokumen pembelajaran dalam satu sistem terpusat dengan organisasi yang rapi dan mudah diakses.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="group p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 sm:hover:-translate-y-2">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-105 sm:group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-900">Evaluasi Otomatis</h3>
                        <p class="text-sm sm:text-gray-600 leading-relaxed">
                            Kuis dan tugas dinilai otomatis dengan bantuan AI untuk feedback instan dan akurat kepada setiap siswa.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="group p-6 sm:p-8 rounded-2xl bg-white border border-gray-200 hover:border-purple-300 hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 sm:hover:-translate-y-2">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-105 sm:group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </svg>
                        </div>
                        <h3 class="text-lg sm:text-xl font-bold mb-2 sm:mb-3 text-gray-900">Progress Real-time</h3>
                        <p class="text-sm sm:text-gray-600 leading-relaxed">
                            Pantau perkembangan belajar siswa secara akurat dan transparan dengan dashboard analytics yang komprehensif.
                        </p>
                    </div>
                </div>
            </section>

            <!-- STATS SECTION -->
            <section class="py-16 -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 border-y border-gray-200 bg-gradient-to-br from-blue-50/50 via-indigo-50/30 to-purple-50/50 mb-24">
                <div class="max-w-7xl mx-auto">
                    <div class="text-center mb-12 sm:mb-16">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/80 backdrop-blur-sm text-gray-700 text-xs sm:text-sm font-semibold mb-3 shadow-sm">
                            Dipercaya Ribuan Pengguna
                        </span>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900">
                            Platform dalam Angka
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
                        <!-- STAT 1 -->
                        <div class="group relative">
                            <div class="flex flex-col items-center gap-4 p-6 sm:p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-blue-200 hover:-translate-y-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-blue-500/30">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                </div>

                                <div class="text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-blue-500 bg-clip-text text-transparent tracking-tight">
                                    1.000<span class="text-blue-600">+</span>
                                </div>

                                <div class="text-center">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                                        Pengguna Aktif
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        Siswa & pengajar terdaftar
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- STAT 2 -->
                        <div class="group relative">
                            <div class="flex flex-col items-center gap-4 p-6 sm:p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-indigo-200 hover:-translate-y-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-indigo-500/30">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>

                                <div class="text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-indigo-600 to-indigo-500 bg-clip-text text-transparent tracking-tight">
                                    120<span class="text-indigo-600">+</span>
                                </div>

                                <div class="text-center">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                                        Materi Pembelajaran
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        Modul, video, dan kuis
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- STAT 3 -->
                        <div class="group relative">
                            <div class="flex flex-col items-center gap-4 p-6 sm:p-8 rounded-2xl bg-white shadow-lg hover:shadow-2xl transition-all duration-500 border border-gray-100 hover:border-green-200 hover:-translate-y-1">
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-lg shadow-green-500/30">
                                    <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                    </svg>
                                </div>

                                <div class="text-4xl sm:text-5xl font-extrabold bg-gradient-to-r from-green-600 to-green-500 bg-clip-text text-transparent tracking-tight">
                                    95<span class="text-green-600">%</span>
                                </div>

                                <div class="text-center">
                                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-1">
                                        Tingkat Kepuasan
                                    </h3>
                                    <p class="text-xs sm:text-sm text-gray-500">
                                        Berdasarkan feedback pengguna
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- HOW IT WORKS SECTION -->
            <section id="cara-kerja" class="py-12 sm:py-16 md:py-20">
                <div class="text-center mb-12 sm:mb-16">
                    <span class="inline-block px-3 py-1 sm:px-4 sm:py-2 rounded-full bg-purple-100 text-purple-600 text-xs sm:text-sm font-semibold mb-3 sm:mb-4">
                        Cara Kerja
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-5xl font-bold text-gray-900 mb-3 sm:mb-4">
                        Mulai Belajar dalam 3 Langkah
                    </h2>
                    <p class="text-sm sm:text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                        Proses sederhana untuk mengelola pembelajaran secara digital dan terstruktur.
                    </p>
                </div>

                <!-- Steps Progress -->
                <div class="relative max-w-5xl mx-auto mb-20">
                    <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200 rounded-full hidden md:block">
                        <div id="progressBar" class="h-1 rounded-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 transition-all duration-500" style="width: 33%;"></div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                        <!-- Step 1 -->
                        <button onclick="setStep(1)" class="group text-center focus:outline-none rounded-xl">
                            <div id="step1" class="step active mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Daftar & Login</h3>
                            <p class="text-sm text-gray-500">Buat akun dengan mudah</p>
                        </button>

                        <!-- Step 2 -->
                        <button onclick="setStep(2)" class="group text-center focus:outline-none rounded-xl">
                            <div id="step2" class="step mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Ikuti Materi</h3>
                            <p class="text-sm text-gray-500">Akses konten belajar</p>
                        </button>

                        <!-- Step 3 -->
                        <button onclick="setStep(3)" class="group text-center focus:outline-none rounded-xl">
                            <div id="step3" class="step mx-auto mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                                </svg>
                            </div>
                            <h3 class="font-bold text-gray-900 mb-2">Evaluasi & Progress</h3>
                            <p class="text-sm text-gray-500">Pantau perkembangan</p>
                        </button>
                    </div>
                </div>

                <!-- Step Details -->
                <div class="max-w-6xl mx-auto min-h-[28rem] sm:min-h-[32rem] relative">
                    <!-- Detail 1 -->
                    <div id="detail1" class="step-detail absolute inset-0 grid md:grid-cols-2 gap-6 sm:gap-12 items-center opacity-100 pointer-events-auto transition-opacity duration-300">
                        <div class="order-2 md:order-1 w-full max-w-sm sm:max-w-md mx-auto">
                            <div class="relative p-4 sm:p-8 rounded-2xl bg-white/5 backdrop-blur-sm">
                                <img src="/SVG/Login.svg" alt="Daftar Login" class="w-full h-40 sm:h-64 object-contain drop-shadow-md transition-transform duration-500 ease-out md:hover:scale-105">
                            </div>
                        </div>
                        <div class="order-1 md:order-2">
                            <div class="inline-block px-2 sm:px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold mb-2 sm:mb-4">
                                LANGKAH 1
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4 text-gray-900">Daftar & Login Mudah</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 leading-relaxed">
                                Pengguna membuat akun dan masuk ke sistem LMS secara aman dengan proses yang cepat dan intuitif.
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Email terverifikasi</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Akses aman</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Profil personal</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Notifikasi real-time</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail 2 -->
                    <div id="detail2" class="step-detail absolute inset-0 grid md:grid-cols-2 gap-6 sm:gap-12 items-center transition-opacity duration-300">
                        <div class="order-2 md:order-1 w-full max-w-sm sm:max-w-md mx-auto">
                            <div class="relative p-4 sm:p-8 rounded-2xl bg-white/5 backdrop-blur-sm">
                                <img src="/SVG/Materi.svg" alt="Daftar Login" class="w-full h-40 sm:h-64 object-contain drop-shadow-md transition-transform duration-500 ease-out md:hover:scale-105">
                            </div>
                        </div>
                        <div class="order-1 md:order-2">
                            <div class="inline-block px-2 sm:px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold mb-2 sm:mb-4">
                                LANGKAH 2
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4 text-gray-900">Ikuti Materi Interaktif</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 leading-relaxed">
                                Akses modul, video, latihan, dan kuis secara terstruktur untuk memperdalam pemahaman dengan cara yang menyenangkan.
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Video pembelajaran</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Modul interaktif</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Latihan & kuis</span>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-purple-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                        </svg>
                                    </div>
                                    <span class="font-medium text-gray-900 text-xs sm:text-sm">Feedback AI</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Detail 3 -->
                    <div id="detail3" class="step-detail absolute inset-0 grid md:grid-cols-2 gap-6 sm:gap-12 items-center transition-opacity duration-300">
                        <div class="order-2 md:order-1 w-full max-w-sm sm:max-w-md mx-auto">
                            <div class="relative p-4 sm:p-8 rounded-2xl bg-white/5 backdrop-blur-sm">
                                <img src="/SVG/Evaluasi.svg" alt="Daftar Login" class="w-full h-40 sm:h-64 object-contain drop-shadow-md transition-transform duration-500 ease-out md:hover:scale-105">
                            </div>
                        </div>
                        <div class="order-1 md:order-2">
                            <div class="inline-block px-2 sm:px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold mb-2 sm:mb-4">
                                LANGKAH 3
                            </div>
                            <h3 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4 text-gray-900">Evaluasi & Lacak Progress</h3>
                            <p class="text-sm sm:text-base text-gray-600 mb-6 sm:mb-8 leading-relaxed">
                                Sistem memberikan nilai, feedback, dan menampilkan progres belajar secara real-time dengan analytics yang detail.
                            </p>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 sm:gap-4">
                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-base sm:text-lg mb-0.5">Nilai & Feedback Otomatis</h4>
                                        <p class="text-gray-500 text-xs sm:text-sm">Penilaian instan dengan saran perbaikan</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-base sm:text-lg mb-0.5">Progress Real-time</h4>
                                        <p class="text-gray-500 text-xs sm:text-sm">Dashboard analytics komprehensif</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2 sm:gap-3 p-3 sm:p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 hover:shadow-md transition-all">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-gray-900 font-semibold text-base sm:text-lg mb-0.5">Rekap & Sertifikat Digital</h4>
                                        <p class="text-gray-500 text-xs sm:text-sm">Download sertifikat setelah selesai</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom visual anchor -->
                <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
                    <div class="h-24 bg-gradient-to-t from-blue-50/70 to-transparent"></div>
                    <!-- step dots -->
                    <div class="absolute bottom-6 left-1/2 -translate-x-1/2 hidden sm:flex items-center gap-2 opacity-60">
                        <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                        <span class="w-6 h-0.5 bg-blue-300"></span>
                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                        <span class="w-6 h-0.5 bg-blue-300"></span>
                        <span class="w-2 h-2 rounded-full bg-blue-300"></span>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- CTA SECTION -->
    <section class="relative overflow-hidden">
        <img src="/images/LMS CTA.png" alt="" class="absolute inset-0 w-full h-full object-cover">
        <!-- Overlay biar teks kebaca -->
        <div class="absolute inset-0 bg-gradient-to-r from-blue-600/40 via-orange-500/30 to-green-500/30"></div>
        <div class="relative z-10 w-full px-4 sm:px-8 md:px-12 py-6 sm:py-8 md:py-10 flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-4 sm:gap-6 text-center sm:text-left">
            <div class="text-white mb-4 sm:mb-0">
                <h2 class="text-xl sm:text-2xl md:text-3xl font-bold mb-1 sm:mb-2">
                    Tingkatkan Cara Belajar Kamu
                </h2>
                <p class="text-white/90 text-sm sm:text-base md:text-lg">
                    Akses materi, latihan, dan evaluasi berbasis AI kapan saja dan di mana saja.
                </p>
            </div>
            <a href="/dashboard" class="bg-white text-red-600 font-semibold px-6 py-3 sm:px-8 sm:py-4 rounded-2xl hover:bg-red-50 transition text-sm sm:text-base">
                Mulai Belajar
            </a>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="bg-white border-t border-gray-100">
        <div class="w-full px-4 sm:px-8 md:px-12 py-10 sm:py-12 md:py-14">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8 sm:gap-10">
                <!-- Brand -->
                <div>
                    <div class="flex items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                        <img src="/images/LMS.png" alt="LMS Logo" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover">
                        <span class="text-base sm:text-lg font-semibold text-gray-800">
                            LMS AI
                        </span>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
                        Learning Management System berbasis AI untuk membantu belajar lebih efektif, fleksibel, dan relevan dengan kebutuhan masa kini.
                    </p>
                </div>
                <!-- Menu -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">Menu</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-gray-500">
                        <li><a href="/" class="hover:text-blue-600 transition">Beranda</a></li>
                        <li><a href="/courses" class="hover:text-blue-600 transition">Kelas</a></li>
                        <li><a href="/about" class="hover:text-blue-600 transition">Tentang Kami</a></li>
                        <li><a href="/contact" class="hover:text-blue-600 transition">Kontak</a></li>
                    </ul>
                </div>
                <!-- Bantuan -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">Bantuan</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-gray-500">
                        <li><a href="/faq" class="hover:text-blue-600 transition">FAQ</a></li>
                        <li><a href="/privacy" class="hover:text-blue-600 transition">Kebijakan Privasi</a></li>
                        <li><a href="/terms" class="hover:text-blue-600 transition">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                <!-- Kontak -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-800 mb-3">Kontak</h4>
                    <ul class="space-y-2 sm:space-y-3 text-xs sm:text-sm text-gray-500">
                        <li>Email: support@lms-ai.id</li>
                        <li>WhatsApp: +62 8xxx xxxx xxx</li>
                        <li>Indonesia 🇮🇩</li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-100 mt-8 sm:mt-12 pt-4 sm:pt-6 flex flex-col sm:flex-row items-center justify-center sm:justify-between gap-2 sm:gap-4">
                <p class="text-xs sm:text-sm text-gray-500 text-center sm:text-left">
                    © {{ date('Y') }} LMS Berbasis AI. All rights reserved.
                </p>
                <div class="flex items-center gap-3 text-gray-400">
                    <a href="#" class="hover:text-blue-600 transition">Instagram</a>
                    <a href="#" class="hover:text-blue-600 transition">LinkedIn</a>
                    <a href="#" class="hover:text-blue-600 transition">GitHub</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        let currentStep = 1;

        function setStep(step) {
            if (step === currentStep) return;

            // update step icon
            for (let i = 1; i <= 3; i++) {
                document.getElementById('step' + i).classList.remove('active');
            }
            document.getElementById('step' + step).classList.add('active');

            // update detail
            const currentDetail = document.getElementById('detail' + currentStep);
            const nextDetail = document.getElementById('detail' + step);

            currentDetail.classList.remove('active');

            nextDetail.classList.remove('from-left');
            if (step < currentStep) {
                nextDetail.classList.add('from-left');
            }

            nextDetail.classList.add('active');

            // progress bar
            const progress = step === 1 ? '33%' : step === 2 ? '66%' : '100%';
            document.getElementById('progressBar').style.width = progress;

            currentStep = step;
        }
    </script>
</body>
</html>
