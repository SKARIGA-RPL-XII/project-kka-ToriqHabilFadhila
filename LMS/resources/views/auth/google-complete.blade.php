<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Lengkapi Profil - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg">
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 p-8 text-center relative overflow-hidden">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="relative">
                    <div class="w-24 h-24 mx-auto mb-4 rounded-full bg-white shadow-xl flex items-center justify-center">
                        @if(session('google_data.avatar'))
                            <img src="{{ session('google_data.avatar') }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                        @else
                            <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        @endif
                    </div>
                    <h1 class="text-3xl font-bold text-white mb-2">Lengkapi Profil</h1>
                    <p class="text-white/90">Satu langkah lagi untuk memulai</p>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('google.complete.store') }}" method="POST" class="p-8 space-y-6">
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email Google</label>
                    <div class="flex items-center gap-3 px-4 py-3.5 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border-2 border-blue-200">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-gray-800 font-medium flex-1">{{ session('google_data.email') }}</span>
                        <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>

                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            id="nama" 
                            name="nama" 
                            value="{{ old('nama', session('google_data.name')) }}"
                            class="w-full pl-12 pr-4 py-3.5 rounded-xl border-2 border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition outline-none @error('nama') border-red-500 @enderror"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                    </div>
                    @error('nama')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-3">
                        Daftar Sebagai <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="siswa" class="peer sr-only" {{ old('role', 'siswa') == 'siswa' ? 'checked' : '' }} required>
                            <div class="p-5 rounded-xl border-2 border-gray-300 peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300 transition-all text-center">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-blue-100 peer-checked:bg-blue-500 flex items-center justify-center transition">
                                    <svg class="w-6 h-6 text-blue-600 peer-checked:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                <span class="font-bold text-gray-700 peer-checked:text-blue-600 transition">Siswa</span>
                                <p class="text-xs text-gray-500 mt-1">Belajar & kerjakan tugas</p>
                            </div>
                        </label>
                        <label class="relative cursor-pointer">
                            <input type="radio" name="role" value="guru" class="peer sr-only" {{ old('role') == 'guru' ? 'checked' : '' }}>
                            <div class="p-5 rounded-xl border-2 border-gray-300 peer-checked:border-purple-500 peer-checked:bg-purple-50 hover:border-purple-300 transition-all text-center">
                                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-purple-100 peer-checked:bg-purple-500 flex items-center justify-center transition">
                                    <svg class="w-6 h-6 text-purple-600 peer-checked:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="font-bold text-gray-700 peer-checked:text-purple-600 transition">Guru</span>
                                <p class="text-xs text-gray-500 mt-1">Mengajar & kelola kelas</p>
                            </div>
                        </label>
                    </div>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <button 
                    type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-bold py-4 rounded-xl hover:from-blue-700 hover:via-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                >
                    Lanjutkan
                </button>

                <!-- Cancel -->
                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800 transition">
                        Kembali ke login
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
