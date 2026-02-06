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
        .assignment-card {
            transition: all 0.3s ease;
        }
        .assignment-card:hover {
            transform: translateX(8px);
            box-shadow: -4px 0 0 0 #8b5cf6;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @include('components.navbar')

    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Header Section -->
        <div class="bg-gradient-to-br from-purple-600 via-purple-700 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white animate-fade-in-up overflow-hidden relative">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div class="relative z-10">
                <!-- Back Button & Title -->
                <div class="flex items-start gap-4 mb-6">
                    <a href="{{ route('dashboard') }}" class="p-2.5 hover:bg-white/20 rounded-xl transition-all duration-300 hover:scale-110 flex-shrink-0 mt-1" title="Kembali ke Dashboard">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div class="flex-1">
                        <h1 class="text-3xl md:text-4xl font-bold mb-2 leading-tight">
                            {{ $kelas->nama_kelas }}
                        </h1>
                        <p class="text-lg text-purple-100 mb-3">{{ $kelas->deskripsi }}</p>
                        <div class="flex items-center gap-2 text-sm">
                            <svg class="w-5 h-5 text-purple-200" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                            </svg>
                            <span class="text-purple-100">Guru: <span class="font-semibold">{{ $kelas->creator->nama }}</span></span>
                        </div>
                    </div>
                </div>
                <!-- Stats -->
                <div class="flex flex-wrap gap-3">
                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-white/30 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                        </svg>
                        <span class="font-semibold">{{ $kelas->enrollments->count() }} Siswa</span>
                    </div>
                    <div class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-white/30 transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">{{ $kelas->assignments->count() }} Tugas</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Assignments Section -->
        <div class="bg-white rounded-3xl shadow-xl overflow-hidden animate-fade-in-up">
            <!-- Section Header -->
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-8 py-6 border-b border-purple-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-purple-600 rounded-xl">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Tugas & Quiz</h2>
                    </div>
                    <span class="text-sm font-medium text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                        Total: {{ $kelas->assignments->count() }}
                    </span>
                </div>
            </div>
            <!-- Assignments List -->
            <div class="divide-y divide-gray-100">
                @forelse($kelas->assignments as $index => $assignment)
                    <div class="assignment-card p-6 hover:bg-gradient-to-r hover:from-purple-50/50 hover:to-transparent" style="animation-delay: {{ $index * 0.1 }}s">
                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                            <!-- Assignment Info -->
                            <div class="flex-1">
                                <div class="flex items-start gap-3 mb-3">
                                    <!-- Type Icon -->
                                    <div class="p-2 rounded-lg flex-shrink-0
                                        @if($assignment->tipe === 'essay') bg-green-100
                                        @elseif($assignment->tipe === 'pilihan_ganda') bg-orange-100
                                        @else bg-purple-100
                                        @endif">
                                        @if($assignment->tipe === 'essay')
                                            <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        @elseif($assignment->tipe === 'pilihan_ganda')
                                            <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-bold text-lg text-gray-800 mb-1 group-hover:text-purple-600 transition">
                                            {{ $assignment->judul }}
                                        </h3>
                                        <p class="text-sm text-gray-600 leading-relaxed">
                                            {{ $assignment->deskripsi }}
                                        </p>
                                    </div>
                                </div>
                                <!-- Deadline Info -->
                                <div class="flex items-center gap-2 mt-3 text-sm">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-gray-500">
                                        Deadline: <span class="font-semibold text-gray-700">{{ is_string($assignment->deadline) ? $assignment->deadline : $assignment->deadline->format('d M Y, H:i') }}</span>
                                    </span>
                                    @php
                                        $deadline = is_string($assignment->deadline)
                                            ? \Carbon\Carbon::parse($assignment->deadline)
                                            : $assignment->deadline;
                                        $daysLeft = now()->startOfDay()->diffInDays($deadline->startOfDay(), false);
                                    @endphp
                                    @if($daysLeft >= 0)
                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full
                                            @if($daysLeft <= 1) bg-red-100 text-red-700
                                            @elseif($daysLeft <= 3) bg-yellow-100 text-yellow-700
                                            @else bg-blue-100 text-blue-700
                                            @endif">
                                            {{ $daysLeft == 0 ? 'Hari ini' : ($daysLeft == 1 ? 'Besok' : $daysLeft . ' hari lagi') }}
                                        </span>
                                    @else
                                        <span class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                            Terlewat
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <!-- Type Badge -->
                            <div class="flex-shrink-0">
                                <span class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold rounded-xl shadow-sm
                                    @if($assignment->tipe === 'essay') bg-gradient-to-r from-green-500 to-green-600 text-white
                                    @elseif($assignment->tipe === 'pilihan_ganda') bg-gradient-to-r from-orange-500 to-orange-600 text-white
                                    @else bg-gradient-to-r from-purple-500 to-purple-600 text-white
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $assignment->tipe)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="text-center py-16 px-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-100 rounded-full mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum Ada Tugas</h3>
                        <p class="text-gray-500 max-w-md mx-auto">
                            Saat ini belum ada tugas atau quiz yang tersedia untuk kelas ini. Pantau terus untuk update terbaru!
                        </p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>
