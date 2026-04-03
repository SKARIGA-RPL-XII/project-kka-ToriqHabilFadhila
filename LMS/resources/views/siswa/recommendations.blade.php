<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Rekomendasi Materi - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-600 rounded-3xl shadow-2xl p-8 mb-8 text-white overflow-hidden relative">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                    </svg>
                    <h1 class="text-3xl md:text-4xl font-bold">Rekomendasi Materi Pembelajaran</h1>
                </div>
                <p class="text-lg text-purple-100">AI akan menganalisis performa belajarmu dan memberikan rekomendasi materi yang sesuai</p>
            </div>
        </div>

        <!-- Loading State -->
        <div id="loading" class="bg-white rounded-3xl shadow-xl p-8 text-center border border-gray-100">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
            <p class="text-gray-600">AI sedang menganalisis data belajarmu...</p>
        </div>

        <!-- Profile Card -->
        <div id="profileCard" class="hidden bg-white rounded-3xl p-6 mb-6 shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Profil & Progress Belajar
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="p-4 bg-blue-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Mata Pelajaran</p>
                    <p class="font-semibold text-gray-900" id="subject">-</p>
                </div>
                <div class="p-4 bg-purple-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Nilai Terakhir</p>
                    <p class="font-semibold text-gray-900" id="lastScores">-</p>
                </div>
                <div class="p-4 bg-yellow-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Rata-rata Nilai</p>
                    <p class="font-semibold text-gray-900" id="avgScore">-</p>
                </div>
                <div class="p-4 bg-cyan-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Progress Belajar</p>
                    <p class="font-semibold text-gray-900" id="progress">-</p>
                </div>
                <div class="p-4 bg-orange-50 rounded-xl">
                    <p class="text-sm text-gray-600 mb-1">Topik yang Sulit</p>
                    <p class="font-semibold text-gray-900" id="weakTopics">-</p>
                </div>
                <div class="p-4 rounded-xl" id="statusCard">
                    <p class="text-sm text-gray-600 mb-1">Status Performa</p>
                    <p class="font-semibold text-gray-900" id="performanceStatus">-</p>
                </div>
            </div>
            <div class="mt-4 p-4 bg-indigo-50 rounded-xl">
                <p class="text-sm text-gray-600 mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Materi yang Tersedia
                </p>
                <p class="text-sm font-semibold text-gray-900" id="availableMaterials">-</p>
            </div>
        </div>

        <!-- Recommendations Card -->
        <div id="recommendationsCard" class="hidden bg-white rounded-3xl p-6 shadow-xl border border-gray-100">
            <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
                <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
                Rekomendasi untuk Kamu
            </h2>
            <div id="recommendations" class="prose max-w-none text-gray-700"></div>
        </div>

        <!-- Error State -->
        <div id="error" class="hidden bg-red-50 border-2 border-red-200 rounded-3xl p-8 text-center shadow-xl">
            <svg class="w-12 h-12 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-red-800 font-semibold mb-2">Gagal mendapatkan rekomendasi</p>
            <p class="text-red-600 text-sm" id="errorMessage"></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('{{ route('ai.recommendations') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loading').classList.add('hidden');

                    if (data.success) {
                        // Show profile
                        document.getElementById('profileCard').classList.remove('hidden');
                        document.getElementById('subject').textContent = data.profile.subject;
                        document.getElementById('lastScores').textContent = data.profile.last_scores;
                        document.getElementById('avgScore').textContent = data.profile.avg_score;
                        document.getElementById('progress').textContent = data.profile.progress;
                        document.getElementById('weakTopics').textContent = data.profile.weak_topics;
                        document.getElementById('performanceStatus').textContent = data.profile.performance_status;
                        document.getElementById('availableMaterials').textContent = data.profile.available_materials;

                        // Color status card
                        const statusCard = document.getElementById('statusCard');
                        if (data.profile.avg_score < 60) {
                            statusCard.classList.add('bg-red-50');
                        } else if (data.profile.avg_score >= 80) {
                            statusCard.classList.add('bg-green-50');
                        } else {
                            statusCard.classList.add('bg-yellow-50');
                        }

                        // Show recommendations
                        document.getElementById('recommendationsCard').classList.remove('hidden');
                        // Recommendations sudah berisi HTML dengan link dari backend
                        document.getElementById('recommendations').innerHTML = data.recommendations;
                    } else {
                        document.getElementById('error').classList.remove('hidden');
                        document.getElementById('errorMessage').textContent = data.message || 'Terjadi kesalahan';
                    }
                })
                .catch(error => {
                    document.getElementById('loading').classList.add('hidden');
                    document.getElementById('error').classList.remove('hidden');
                    document.getElementById('errorMessage').textContent = 'Tidak dapat terhubung ke server';
                });
        });
    </script>
</body>
</html>
