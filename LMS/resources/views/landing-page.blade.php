<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* Glass morphism effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    @include('components.navbar')

    {{-- HERO SECTION --}}
    <section id="beranda" class="relative pt-32 pb-20 overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute top-20 left-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float"></div>
            <div class="absolute top-40 right-10 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 2s"></div>
            <div class="absolute bottom-20 left-1/2 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-20 animate-float" style="animation-delay: 4s"></div>
        </div>

        <div class="w-full px-4 sm:px-6 md:px-16 py-16 sm:py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Hero Content --}}
                <div class="text-center lg:text-left">
                    <div class="inline-block mb-4">
                        <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                            </svg>
                            Platform Pembelajaran Terdepan
                        </span>
                    </div>
                    <h1 class="text-5xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6">
                        Belajar Lebih
                        <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                            Efektif & Adaptif
                        </span>
                        dengan AI
                    </h1>
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        Platform LMS berbasis AI yang membantu proses belajar menjadi lebih terarah, personal, dan mudah diakses kapan saja, di mana saja.
                    </p>
                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('register') }}" class="px-8 py-4 gradient-primary text-white rounded-lg font-semibold text-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                            Mulai Belajar Gratis
                        </a>
                        <a href="#cara-kerja" class="px-8 py-4 bg-white text-purple-600 border-2 border-purple-600 rounded-lg font-semibold text-lg hover:bg-purple-50 transition-all duration-200">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                    {{-- Features Pills --}}
                    <div class="mt-8 flex flex-wrap gap-4 justify-center lg:justify-start">
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Gratis untuk Siswa</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">Sertifikat Digital</span>
                        </div>
                        <div class="flex items-center gap-2 text-gray-700">
                            <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-medium">AI-Powered</span>
                        </div>
                    </div>
                </div>
                {{-- Hero Image --}}
                <div class="relative">
                    <div class="relative z-10">
                        <img src="/SVG/Landing Page.svg" alt="LMS Illustration" class="w-full animate-float">
                    </div>
                    {{-- Decorative elements --}}
                    <div class="absolute -top-4 -right-4 w-24 h-24 gradient-secondary rounded-lg opacity-50 blur-2xl"></div>
                    <div class="absolute -bottom-4 -left-4 w-32 h-32 gradient-accent rounded-lg opacity-50 blur-2xl"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATS SECTION --}}
    <section class="py-16 bg-white">
        <div class="w-full px-4 sm:px-6 md:px-16">
            <div class="grid md:grid-cols-3 gap-8">
                {{-- Stat 1 --}}
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 hover:shadow-lg transition-shadow duration-300">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-2">
                        1.000+
                    </div>
                    <div class="text-gray-600 font-semibold text-lg">Pengguna Aktif</div>
                    <div class="text-gray-500 text-sm mt-1">Siswa & pengajar terdaftar</div>
                </div>
                {{-- Stat 2 --}}
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 hover:shadow-lg transition-shadow duration-300">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent mb-2">
                        120+
                    </div>
                    <div class="text-gray-600 font-semibold text-lg">Materi Pembelajaran</div>
                    <div class="text-gray-500 text-sm mt-1">Modul, video, dan kuis</div>
                </div>
                {{-- Stat 3 --}}
                <div class="text-center p-8 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 hover:shadow-lg transition-shadow duration-300">
                    <div class="text-5xl font-extrabold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent mb-2">
                        95%
                    </div>
                    <div class="text-gray-600 font-semibold text-lg">Tingkat Kepuasan</div>
                    <div class="text-gray-500 text-sm mt-1">Berdasarkan feedback pengguna</div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES SECTION --}}
    <section id="fitur" class="py-20 bg-gray-50">
        <div class="w-full px-4 sm:px-6 md:px-16">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <span class="px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Fitur Unggulan
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mt-4 mb-4">
                    Kenapa Memilih
                    <span class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">
                        LMS AI?
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dilengkapi dengan teknologi AI dan fitur-fitur modern untuk pengalaman belajar yang optimal dan hasil maksimal
                </p>
            </div>
            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Feature 1 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 gradient-primary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Materi Terstruktur</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kelola modul, video, dan dokumen pembelajaran dalam satu sistem terpusat dengan organisasi yang rapi dan mudah diakses.
                    </p>
                </div>
                {{-- Feature 2 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 gradient-secondary rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Evaluasi Otomatis</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Kuis dan tugas dinilai otomatis dengan bantuan AI untuk feedback instan dan akurat kepada setiap siswa.
                    </p>
                </div>
                {{-- Feature 3 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 gradient-accent rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Progress Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pantau perkembangan belajar siswa secara akurat dan transparan dengan dashboard analytics yang komprehensif.
                    </p>
                </div>
                {{-- Feature 4 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pembelajaran Adaptif</h3>
                    <p class="text-gray-600 leading-relaxed">
                        AI menyesuaikan materi dan tingkat kesulitan berdasarkan kemampuan dan progres belajar setiap siswa.
                    </p>
                </div>
                {{-- Feature 5 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Video Interaktif</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Pembelajaran melalui video berkualitas tinggi dengan fitur interaktif dan subtitle otomatis berbasis AI.
                    </p>
                </div>
                {{-- Feature 6 --}}
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-2">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-400 to-teal-500 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Sertifikat Digital</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan sertifikat digital yang terverifikasi setelah menyelesaikan kursus untuk meningkatkan kredibilitas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- HOW IT WORKS SECTION --}}
    <section id="cara-kerja" class="py-20 bg-white">
        <div class="w-full px-4 sm:px-6 md:px-16">
            {{-- Section Header --}}
            <div class="text-center mb-16">
                <span class="px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Cara Kerja
                </span>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mt-4 mb-4">
                    Mulai Belajar dalam
                    <span class="bg-gradient-to-r from-blue-600 to-cyan-600 bg-clip-text text-transparent">
                        3 Langkah Mudah
                    </span>
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Proses sederhana dan intuitif untuk memulai perjalanan pembelajaran digital Anda
                </p>
            </div>
            {{-- Steps --}}
            <div class="grid md:grid-cols-3 gap-8 relative">
                {{-- Connecting lines (hidden on mobile) --}}
                <div class="hidden md:block absolute top-20 left-0 right-0 h-0.5 bg-gradient-to-r from-purple-200 via-blue-200 to-green-200 z-0"></div>
                {{-- Step 1 --}}
                <div class="relative z-10">
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-purple-100 hover:border-purple-300 transition-all duration-300">
                        <div class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">
                            1
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Daftar & Login</h3>
                        <p class="text-gray-600 text-center mb-6">
                            Buat akun dengan mudah menggunakan email atau akun sosial media Anda
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Email terverifikasi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Akses aman & terlindungi</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Profil personal disesuaikan</span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Step 2 --}}
                <div class="relative z-10">
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-blue-100 hover:border-blue-300 transition-all duration-300">
                        <div class="w-16 h-16 gradient-accent rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">
                            2
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Ikuti Materi</h3>
                        <p class="text-gray-600 text-center mb-6">
                            Akses konten pembelajaran interaktif yang disesuaikan dengan kebutuhan Anda
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Video pembelajaran HD</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Modul interaktif</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Latihan & kuis AI</span>
                            </li>
                        </ul>
                    </div>
                </div>
                {{-- Step 3 --}}
                <div class="relative z-10">
                    <div class="bg-white p-8 rounded-2xl shadow-lg border-2 border-green-100 hover:border-green-300 transition-all duration-300">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-emerald-500 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-6 mx-auto">
                            3
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3 text-center">Evaluasi & Progress</h3>
                        <p class="text-gray-600 text-center mb-6">
                            Pantau perkembangan dan raih sertifikat untuk setiap pencapaian Anda
                        </p>
                        <ul class="space-y-3">
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Penilaian otomatis</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Dashboard analitik</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm text-gray-600">Sertifikat digital</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-24 relative overflow-hidden bg-cover bg-center" style="background-image: url('{{ asset('images/LMS CTA.png') }}');">
        <div class="absolute inset-0 gradient-primary opacity-60"></div>
        {{-- Background decoration --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        <div class="w-full px-4 sm:px-6 md:px-16 relative z-10">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-6">
                    Siap Meningkatkan Cara Belajar Anda?
                </h2>
                <p class="text-xl text-purple-100 mb-8 leading-relaxed">
                    Bergabunglah dengan ribuan pelajar yang sudah merasakan pengalaman belajar yang lebih efektif dengan LMS AI
                </p>
            </div>
        </div>
    </section>
    {{-- FOOTER --}}
    @include('components.footer')

    {{-- Smooth scroll script --}}
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
