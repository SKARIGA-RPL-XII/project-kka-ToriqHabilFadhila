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
            background: linear-gradient(135deg, #3b82f6 0%, #6366f1 100%) !important;
            border-color: #3b82f6 !important;
            color: white !important;
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
        <div class="absolute inset-0 overflow-hidden pointer-events-none z-0">
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

            <!-- HOW IT WORKS SECTION - FIXED VERSION -->
            <section id="cara-kerja" class="py-12 sm:py-16 md:py-20 px-4">
                <div class="max-w-6xl mx-auto">
                    <!-- Header -->
                    <div class="text-center mb-12 sm:mb-16">
                        <span class="inline-block px-4 py-2 rounded-full bg-purple-100 text-purple-600 text-sm font-semibold mb-4">
                            Cara Kerja
                        </span>
                        <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                            Mulai Belajar dalam 3 Langkah
                        </h2>
                        <p class="text-base md:text-lg text-gray-600 max-w-2xl mx-auto">
                            Proses sederhana untuk mengelola pembelajaran secara digital dan terstruktur.
                        </p>
                    </div>

                    <!-- Steps Progress (Desktop Only) -->
                    <div class="relative max-w-4xl mx-auto mb-16 hidden md:block">
                        <div class="absolute top-8 left-0 right-0 h-1 bg-gray-200 rounded-full">
                            <div id="progressBar" class="h-1 rounded-full bg-gradient-to-r from-blue-500 via-indigo-500 to-purple-500 transition-all duration-500" style="width: 33%;"></div>
                        </div>

                        <div class="grid grid-cols-3 gap-8 relative">
                            <!-- Step 1 -->
                            <button onclick="setStep(1)" class="group text-center focus:outline-none">
                                <div id="step1" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-blue-600 text-white shadow-lg transition-all duration-300 hover:scale-110">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2">Daftar & Login</h3>
                                <p class="text-sm text-gray-500">Buat akun dengan mudah</p>
                            </button>

                            <!-- Step 2 -->
                            <button onclick="setStep(2)" class="group text-center focus:outline-none">
                                <div id="step2" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-white border-3 border-gray-300 text-gray-400 transition-all duration-300 hover:scale-105 hover:border-gray-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2">Ikuti Materi</h3>
                                <p class="text-sm text-gray-500">Akses konten belajar</p>
                            </button>

                            <!-- Step 3 -->
                            <button onclick="setStep(3)" class="group text-center focus:outline-none">
                                <div id="step3" class="w-16 h-16 mx-auto mb-4 rounded-full flex items-center justify-center bg-white border-3 border-gray-300 text-gray-400 transition-all duration-300 hover:scale-105 hover:border-gray-400">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <h3 class="font-bold text-gray-900 mb-2">Evaluasi & Progress</h3>
                                <p class="text-sm text-gray-500">Pantau perkembangan</p>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Steps Indicator -->
                    <div class="flex justify-center gap-2 mb-8 md:hidden">
                        <div id="mobile-step1" class="w-2 h-2 rounded-full bg-blue-500"></div>
                        <div id="mobile-step2" class="w-2 h-2 rounded-full bg-gray-300"></div>
                        <div id="mobile-step3" class="w-2 h-2 rounded-full bg-gray-300"></div>
                    </div>

                    <!-- Step Details Container -->
                    <div class="relative overflow-hidden">
                        <!-- Detail 1 -->
                        <div id="detail1" class="transition-all duration-500 opacity-100">
                            <div class="grid md:grid-cols-2 gap-8 items-center">
                                <div class="order-2 md:order-1 flex items-center justify-center p-8">
                                    <img src="/SVG/Login.svg" alt="Daftar Login" class="w-full max-w-sm h-64 object-contain">
                                </div>
                                <div class="order-1 md:order-2">
                                    <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-600 text-xs font-semibold mb-3">
                                        LANGKAH 1
                                    </span>
                                    <h3 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">
                                        Daftar & Login Mudah
                                    </h3>
                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                        Pengguna membuat akun dan masuk ke sistem LMS secara aman dengan proses yang cepat dan intuitif.
                                    </p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Email terverifikasi</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Akses aman</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Profil personal</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-purple-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Notifikasi real-time</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail 2 -->
                        <div id="detail2" class="hidden transition-all duration-500">
                            <div class="grid md:grid-cols-2 gap-8 items-center">
                                <div class="order-2 md:order-1 flex items-center justify-center p-8">
                                    <img src="/SVG/Materi.svg" alt="Ikuti Materi" class="w-full max-w-sm h-64 object-contain">
                                </div>
                                <div class="order-1 md:order-2">
                                    <span class="inline-block px-3 py-1 rounded-full bg-indigo-100 text-indigo-600 text-xs font-semibold mb-3">
                                        LANGKAH 2
                                    </span>
                                    <h3 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">
                                        Ikuti Materi Interaktif
                                    </h3>
                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                        Akses modul, video, latihan, dan kuis secara terstruktur untuk memperdalam pemahaman dengan cara yang menyenangkan.
                                    </p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Video pembelajaran</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Modul interaktif</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Latihan & kuis</span>
                                        </div>

                                        <div class="flex items-center gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-purple-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-900 text-sm">Feedback AI</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detail 3 -->
                        <div id="detail3" class="hidden transition-all duration-500">
                            <div class="grid md:grid-cols-2 gap-8 items-center">
                                <div class="order-2 md:order-1 flex items-center justify-center p-8">
                                    <img src="/SVG/Evaluasi.svg" alt="Evaluasi" class="w-full max-w-sm h-64 object-contain">
                                </div>
                                <div class="order-1 md:order-2">
                                    <span class="inline-block px-3 py-1 rounded-full bg-purple-100 text-purple-600 text-xs font-semibold mb-3">
                                        LANGKAH 3
                                    </span>
                                    <h3 class="text-2xl sm:text-3xl font-bold mb-4 text-gray-900">
                                        Evaluasi & Lacak Progress
                                    </h3>
                                    <p class="text-gray-600 mb-6 leading-relaxed">
                                        Sistem memberikan nilai, feedback, dan menampilkan progres belajar secara real-time dengan analytics yang detail.
                                    </p>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-blue-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-base mb-1">Nilai Otomatis</h4>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-indigo-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-base mb-1">Progress Real-time</h4>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-green-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-base mb-1">Sertifikat Digital</h4>
                                            </div>
                                        </div>

                                        <div class="flex items-start gap-3 p-4 rounded-xl bg-white border border-gray-200 hover:border-purple-300 transition-all">
                                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 flex-shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-semibold text-gray-900 text-base mb-1">Laporan Detail</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Buttons (Mobile) -->
                    <div class="flex justify-center gap-4 mt-8 md:hidden">
                        <button onclick="prevStep()" id="prevBtn" class="px-6 py-2 rounded-lg bg-gray-100 text-gray-700 font-medium hover:bg-gray-200 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                            ← Sebelumnya
                        </button>
                        <button onclick="nextStep()" id="nextBtn" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-medium hover:bg-blue-700 transition-all">
                            Selanjutnya →
                        </button>
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
            // Hide all details
            document.getElementById('detail1').classList.add('hidden');
            document.getElementById('detail2').classList.add('hidden');
            document.getElementById('detail3').classList.add('hidden');
            // Show selected detail
            document.getElementById('detail' + step).classList.remove('hidden');
            // Update desktop step icons
            for (let i = 1; i <= 3; i++) {
                const stepEl = document.getElementById('step' + i);
                if (stepEl) {
                    if (i === step) {
                        stepEl.classList.remove('bg-white', 'border-3', 'border-gray-300', 'text-gray-400');
                        stepEl.classList.add('bg-gradient-to-br', 'from-blue-500', 'to-blue-600', 'text-white');
                    } else {
                        stepEl.classList.remove('bg-gradient-to-br', 'from-blue-500', 'to-blue-600', 'text-white');
                        stepEl.classList.add('bg-white', 'border-3', 'border-gray-300', 'text-gray-400');
                    }
                }
            }

            // Update mobile indicators
            for (let i = 1; i <= 3; i++) {
                const mobileStep = document.getElementById('mobile-step' + i);
                if (mobileStep) {
                    if (i === step) {
                        mobileStep.classList.remove('bg-gray-300');
                        mobileStep.classList.add('bg-blue-500');
                    } else {
                        mobileStep.classList.remove('bg-blue-500');
                        mobileStep.classList.add('bg-gray-300');
                    }
                }
            }

            // Update progress bar
            const progressBar = document.getElementById('progressBar');
            if (progressBar) {
                const progress = step === 1 ? '33%' : step === 2 ? '66%' : '100%';
                progressBar.style.width = progress;
            }

            // Update mobile navigation buttons
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            if (prevBtn) prevBtn.disabled = step === 1;
            if (nextBtn) nextBtn.disabled = step === 3;
            currentStep = step;
        }

        function nextStep() {
            if (currentStep < 3) setStep(currentStep + 1);
        }

        function prevStep() {
            if (currentStep > 1) setStep(currentStep - 1);
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', function() {
            setStep(1);
        });
    </script>
</body>
</html>
