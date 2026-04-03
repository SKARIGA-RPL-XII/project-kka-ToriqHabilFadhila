<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Diperlukan - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-3xl shadow-2xl p-8 text-center">
            <div class="w-24 h-24 mx-auto mb-6 bg-yellow-100 rounded-full flex items-center justify-center">
                <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333 .192 3 1.732 3z"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">Verifikasi Diperlukan</h1>

            <p class="text-gray-600 mb-8">Sebelum melanjutkan, silakan verifikasi email Anda dengan klik link yang kami kirim.</p>

            <a href="{{ route('verification.resend') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 transition-all shadow-lg mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Kirim Ulang Email
            </a>

            <div class="text-sm text-gray-500 space-y-2">
                <p>Belum menerima email? Cek folder spam atau kirim ulang.</p>
                <p><a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700">← Kembali ke Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>

