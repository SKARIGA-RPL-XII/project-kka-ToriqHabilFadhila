<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Materi - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <div class="max-w-4xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">🎯 Rekomendasi Materi Pembelajaran</h1>
            <p class="text-gray-600">AI akan menganalisis performa belajarmu dan memberikan rekomendasi materi yang sesuai</p>
        </div>

        <!-- Loading State -->
        <div id="loading" class="bg-white rounded-2xl p-8 text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600 mx-auto mb-4"></div>
            <p class="text-gray-600">AI sedang menganalisis data belajarmu...</p>
        </div>

        <!-- Profile Card -->
        <div id="profileCard" class="hidden bg-white rounded-2xl p-6 mb-6 shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-4">📊 Profil & Progress Belajar</h2>
            <div class="grid grid-cols-2 gap-4">
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
                <p class="text-sm text-gray-600 mb-2">📚 Materi yang Tersedia</p>
                <p class="text-sm font-semibold text-gray-900" id="availableMaterials">-</p>
            </div>
        </div>

        <!-- Recommendations Card -->
        <div id="recommendationsCard" class="hidden bg-white rounded-2xl p-6 shadow-md">
            <h2 class="text-xl font-bold text-gray-900 mb-4">💡 Rekomendasi untuk Kamu</h2>
            <div id="recommendations" class="prose max-w-none text-gray-700"></div>
        </div>

        <!-- Error State -->
        <div id="error" class="hidden bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
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
                        let cleanText = data.recommendations.replace(/\*\*/g, '').replace(/\n/g, '<br>');
                        document.getElementById('recommendations').innerHTML = cleanText;
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
