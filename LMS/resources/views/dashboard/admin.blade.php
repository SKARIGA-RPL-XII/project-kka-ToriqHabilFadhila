<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Navbar -->
    @include('components.notifications')
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="bg-gradient-to-br from-red-600 via-rose-600 to-pink-600 text-white relative overflow-hidden">
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
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-sm font-semibold">Administrator Control Panel</span>
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight">
                            Selamat Datang,<br>
                            <span class="bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-300 bg-clip-text text-transparent animate-gradient">
                                {{ Auth::user()?->nama ?? 'Admin' }}!
                            </span>
                        </h1>

                        <p class="text-lg sm:text-xl text-red-50 max-w-2xl">
                            Kelola users, monitor kelas, dan pantau seluruh aktivitas sistem dengan kontrol penuh dan real-time analytics.
                        </p>

                        <div class="flex flex-wrap gap-4 justify-center lg:justify-start pt-4">
                            <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl">
                                <svg class="w-6 h-6 text-gray-800 dark:text-green-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                                </svg>

                                <span class="text-sm font-medium">Full Access</span>
                            </div>
                            <div class="flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-xl">
                                <svg class="w-6 h-6 text-gray-800 dark:text-blue-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M13.5 2c-.178 0-.356.013-.492.022l-.074.005a1 1 0 0 0-.934.998V11a1 1 0 0 0 1 1h7.975a1 1 0 0 0 .998-.934l.005-.074A7.04 7.04 0 0 0 22 10.5 8.5 8.5 0 0 0 13.5 2Z"/>
                                    <path d="M11 6.025a1 1 0 0 0-1.065-.998 8.5 8.5 0 1 0 9.038 9.039A1 1 0 0 0 17.975 13H11V6.025Z"/>
                                </svg>
                                <span class="text-sm font-medium">Real-time Analytics</span>
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

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -50px) scale(1.1); }
            50% { transform: translate(-20px, 20px) scale(0.9); }
            75% { transform: translate(50px, 50px) scale(1.05); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .animate-gradient {
            background-size: 200% auto;
            animation: gradient 3s ease infinite;
        }
    </style>

    <!-- Main Content -->
    <section class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Statistics Cards -->
        <div class="mb-12">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">Statistik Sistem</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Users -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_users'] ?? 0 }}</h3>
                    <p class="text-sm text-gray-600">Total Users</p>
                </div>

                <!-- Total Guru -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_guru'] ?? 0 }}</h3>
                    <p class="text-sm text-gray-600">Total Guru</p>
                </div>

                <!-- Total Siswa -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_siswa'] ?? 0 }}</h3>
                    <p class="text-sm text-gray-600">Total Siswa</p>
                </div>

                <!-- Total Kelas -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100 hover:shadow-xl transition">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_classes'] ?? 0 }}</h3>
                    <p class="text-sm text-gray-600">Total Kelas</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Menu Manajemen</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Manage Users -->
                <button onclick="openManageUsersModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-blue-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Kelola Users</h3>
                    <p class="text-sm text-gray-500">Lihat, edit, hapus users</p>
                </button>

                <!-- Manage Classes -->
                <button onclick="openManageClassesModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-purple-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Kelola Kelas</h3>
                    <p class="text-sm text-gray-500">Monitor & manage kelas</p>
                </button>

                <!-- System Monitoring -->
                <button onclick="openMonitoringModal()" class="group p-6 bg-white rounded-2xl border-2 border-gray-200 hover:border-green-500 hover:shadow-xl transition-all duration-300">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-1">Monitoring</h3>
                    <p class="text-sm text-gray-500">Laporan & progress</p>
                </button>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="mb-12">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Aktivitas Terbaru</h2>
            </div>

            <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                @forelse($activities as $activity)
                <div class="p-6 {{ !$loop->last ? 'border-b border-gray-100' : '' }} hover:bg-gray-50 transition">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-{{ $activity['color'] }}-100 flex items-center justify-center flex-shrink-0">
                            @if($activity['icon'] === 'user-add')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            @elseif($activity['icon'] === 'class')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            @elseif($activity['icon'] === 'upload')
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 mb-1">{{ $activity['title'] }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['time'] }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-500">
                    <p>Belum ada aktivitas terbaru</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- System Reports -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Laporan Sistem</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Progress Chart Card -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Progress Pembelajaran</h3>
                    <div class="space-y-4">
                        @php
                            $colors = ['blue', 'purple', 'green', 'orange'];
                        @endphp
                        @forelse($progressBySubject as $index => $item)
                            @php
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">{{ $item['subject'] }}</span>
                                    <span class="text-sm font-bold text-{{ $color }}-600">{{ $item['progress'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-{{ $color }}-600 h-3 rounded-full" style="width: {{ $item['progress'] }}%"></div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">Belum ada data progress</p>
                        @endforelse
                    </div>
                </div>

                <!-- Top Classes Card -->
                <div class="bg-white rounded-2xl p-6 shadow-md border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Kelas Paling Aktif</h3>
                    <div class="space-y-4">
                        @php
                            $classColors = ['blue', 'purple', 'green'];
                        @endphp
                        @forelse($topClasses as $index => $class)
                            @php
                                $color = $classColors[$index % count($classColors)];
                                $badge = $index === 0 ? 'Hot' : ($index === 1 ? 'Top' : 'Rising');
                                $badgeIcon = $index === 0 ? 'fire' : ($index === 1 ? 'star' : 'trending');
                            @endphp
                            <div class="flex items-center justify-between p-3 bg-{{ $color }}-50 rounded-lg">
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $class->nama_kelas }}</h4>
                                    <p class="text-xs text-gray-600">{{ $class->enrollments_count }} siswa aktif</p>
                                </div>
                                <span class="px-3 py-1 bg-{{ $color }}-100 text-{{ $color }}-700 text-xs font-bold rounded-full inline-flex items-center gap-1">
                                    @if($badgeIcon === 'fire')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"/>
                                    </svg>
                                    @elseif($badgeIcon === 'star')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @else
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                    @endif
                                    {{ $badge }}
                                </span>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">Belum ada data kelas</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal: Add User -->
    <div id="addUserModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-md bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeAddUserModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Tambah User Baru</h3>
                <p class="text-gray-600">Buat akun untuk guru atau siswa</p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="px-6 pt-6 pb-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" placeholder="Contoh: Ahmad Fadli" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Email</label>
                    <input type="email" name="email" placeholder="email@example.com" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Role</label>
                    <select name="role" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                        <option value="">Pilih Role</option>
                        <option value="guru">Guru</option>
                        <option value="siswa">Siswa</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Password</label>
                    <input type="password" name="password" placeholder="Min. 8 karakter" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" required>
                </div>

                <div class="flex flex-col-reverse sm:flex-row gap-3 pt-2">
                    <button type="button" onclick="closeAddUserModal()" class="flex-1 rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-4 py-3 font-semibold text-white hover:from-blue-700 hover:to-indigo-700 transition shadow-md">
                        Tambah User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Manage Users -->
    <div id="manageUsersModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-3xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeManageUsersModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Kelola Users</h3>
                <p class="text-gray-600">Lihat, edit, atau hapus akun users</p>
            </div>

            <div class="px-6 py-4">
                <!-- Search Bar -->
                <div class="mb-4">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        <input type="text" placeholder="Cari user..." class="w-full rounded-xl border-2 border-gray-300 pl-12 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                </div>

                <!-- User List -->
                <div class="space-y-3">
                    <!-- User 1 -->
                    <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                    B
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Pak Budi Rahman</h4>
                                    <p class="text-xs text-gray-500">budi@example.com • Guru</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- User 2 -->
                    <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold">
                                    A
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Ahmad Fadli</h4>
                                    <p class="text-xs text-gray-500">ahmad@example.com • Siswa</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- User 3 -->
                    <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-semibold">
                                    S
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Mrs. Sarah Johnson</h4>
                                    <p class="text-xs text-gray-500">sarah@example.com • Guru</p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeManageUsersModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Manage Classes -->
    <div id="manageClassesModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-3xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeManageClassesModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Kelola Kelas</h3>
                <p class="text-gray-600">Monitor dan kelola semua kelas</p>
            </div>

            <div class="px-6 py-4">
                <div class="space-y-4">
                    <!-- Class 1 -->
                    <div class="p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-bold text-gray-900">Matematika Kelas 8A</h4>
                                <p class="text-sm text-gray-600">Token: <span class="font-mono font-bold text-blue-600">KLS-8A23</span></p>
                            </div>
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full">32 siswa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Guru: Pak Budi Rahman</p>
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 text-sm text-blue-600 hover:bg-blue-100 rounded-lg transition font-medium">Detail</button>
                                <button class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-100 rounded-lg transition font-medium">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <!-- Class 2 -->
                    <div class="p-4 bg-purple-50 rounded-xl border border-purple-200">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-bold text-gray-900">English Grammar</h4>
                                <p class="text-sm text-gray-600">Token: <span class="font-mono font-bold text-purple-600">KLS-ENG01</span></p>
                            </div>
                            <span class="px-3 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">28 siswa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Guru: Mrs. Sarah Johnson</p>
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 text-sm text-purple-600 hover:bg-purple-100 rounded-lg transition font-medium">Detail</button>
                                <button class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-100 rounded-lg transition font-medium">Hapus</button>
                            </div>
                        </div>
                    </div>

                    <!-- Class 3 -->
                    <div class="p-4 bg-green-50 rounded-xl border border-green-200">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="font-bold text-gray-900">Fisika Dasar</h4>
                                <p class="text-sm text-gray-600">Token: <span class="font-mono font-bold text-green-600">KLS-FIS01</span></p>
                            </div>
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">30 siswa</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-600">Guru: Dr. Ahmad Hidayat</p>
                            <div class="flex gap-2">
                                <button class="px-3 py-1.5 text-sm text-green-600 hover:bg-green-100 rounded-lg transition font-medium">Detail</button>
                                <button class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-100 rounded-lg transition font-medium">Hapus</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeManageClassesModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <!-- Modal: Monitoring -->
    <div id="monitoringModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm animate-backdrop">
        <div class="modal-desktop modal-mobile w-full sm:max-w-3xl bg-white rounded-t-2xl sm:rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto custom-scrollbar">
            <button onclick="closeMonitoringModal()" class="absolute right-4 top-4 z-10 p-1 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <div class="px-6 pt-8 pb-4 border-b border-gray-200">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Monitoring Sistem</h3>
                <p class="text-gray-600">Laporan dan progress keseluruhan</p>
            </div>

            <div class="px-6 py-6 space-y-6">
                <!-- Overall Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-4 bg-blue-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Total Tugas</p>
                        <p class="text-2xl font-bold text-blue-600">156</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Avg. Completion</p>
                        <p class="text-2xl font-bold text-green-600">78%</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Total Materi</p>
                        <p class="text-2xl font-bold text-purple-600">89</p>
                    </div>
                    <div class="p-4 bg-orange-50 rounded-xl">
                        <p class="text-sm text-gray-600 mb-1">Active Today</p>
                        <p class="text-2xl font-bold text-orange-600">142</p>
                    </div>
                </div>

                <!-- Progress by Subject -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-3">Progress per Mata Pelajaran</h4>
                    <div class="space-y-3">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium">Matematika</span>
                                <span class="text-sm font-bold text-blue-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium">Bahasa Inggris</span>
                                <span class="text-sm font-bold text-purple-600">72%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" style="width: 72%"></div>
                            </div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="flex justify-between mb-2">
                                <span class="text-sm font-medium">IPA</span>
                                <span class="text-sm font-bold text-green-600">90%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" style="width: 90%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 pb-6">
                <button onclick="closeMonitoringModal()" class="w-full rounded-xl border-2 border-gray-300 px-4 py-3 text-gray-700 hover:bg-gray-50 transition font-medium">
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
                <p class="text-gray-600">Anda harus login lagi untuk mengakses admin panel.</p>
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
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>
