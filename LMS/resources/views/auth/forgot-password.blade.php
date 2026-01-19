<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen flex items-center justify-center p-4">
    <!-- Background Decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-400/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-400/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Container -->
    <div class="w-full max-w-6xl rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2 bg-white">
        <!-- Left Side - Illustration & Info -->
        <div class="hidden md:flex flex-col justify-center items-center p-12 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 text-white">
            <div class="mb-8">
                <img src="/images/LMS.png" alt="LMS Logo" class="w-24 h-24 rounded-full object-cover shadow-lg border-4 border-white/20 mb-6">
                <h1 class="text-4xl font-extrabold mb-4">
                    Selamat Datang!
                </h1>
                <p class="text-lg text-white/90 leading-relaxed">
                    Platform pembelajaran berbasis AI yang membantu Anda belajar lebih efektif dan efisien.
                </p>
            </div>

            <!-- Features List -->
            <div class="space-y-4 w-full">
                <div class="flex items-center gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Materi Terstruktur</h3>
                        <p class="text-sm text-white/80">Akses ratusan materi pembelajaran</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z">
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">AI-Powered</h3>
                        <p class="text-sm text-white/80">Evaluasi otomatis dengan AI</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 p-4 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">Sertifikat Digital</h3>
                        <p class="text-sm text-white/80">Dapatkan sertifikat setelah selesai</p>
                    </div>
                </div>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-3 gap-4 w-full mt-8 pt-8 border-t border-white/20">
                <div class="text-center">
                    <div class="text-3xl font-bold mb-1">1K+</div>
                    <div class="text-sm text-white/80">Pengguna</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mb-1">120+</div>
                    <div class="text-sm text-white/80">Materi</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold mb-1">95%</div>
                    <div class="text-sm text-white/80">Kepuasan</div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <!-- Logo & Title (Mobile) -->
                <div class="md:hidden text-center mb-8">
                    <img src="/images/LMS.png" alt="LMS Logo" class="w-16 h-16 rounded-full object-cover shadow-lg mx-auto mb-4">
                    <h2 class="text-2xl font-bold text-gray-900">Selamat Datang!</h2>
                </div>

                @if ($mode === 'request')
                    <!-- Login Form -->
                    <form method="POST" action="" class="space-y-6">
                        @csrf
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email Address
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9">
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full pl-12 pr-4 py-3.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent {{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }}" placeholder="Masukkan email terdaftar">
                            </div>
                            @error('email')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition-all">
                            Kirim Link Reset Password
                        </button>
                    </form>
                @endif

                @if ($mode === 'reset')
                    <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="token" value="{{ request('token') }}">
                        <!-- Email Field -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Alamat Email
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </svg>
                                </div>
                                <input type="email" id="email" name="email" value="{{ request('email') }}" readonly class="w-full pl-12 pr-4 py-3.5 border rounded-xl bg-gray-100 border-gray-300 cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </svg>
                                </div>
                                <input type="password" id="password" name="password" required class="w-full pl-12 pr-12 py-3.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}" placeholder="Masukkan password baru">
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 transition-colors">
                                    <svg id="eyeOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </svg>
                                    <svg id="eyeClosed" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </svg>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full pl-12 pr-12 py-3.5 border rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 {{ $errors->has('password_confirmation') ? 'border-red-500' : 'border-gray-300' }}" placeholder="Ulangi password baru">
                            </div>
                            @error('password_confirmation')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:scale-[1.02] transition-all">
                            Reset Password
                        </button>
                    </form>
                @endif

                <!-- Register Link -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Ingat password Anda?
                        <a href="/login" class="font-semibold text-blue-600 hover:text-blue-700">
                            Kembali ke login
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
