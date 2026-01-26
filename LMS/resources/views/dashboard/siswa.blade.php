<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>

        @keyframes modalEnter {
            0% {
                opacity: 0;
                transform: scale(0.92) translateY(16px);
            }
            60% {
                opacity: 1;
                transform: scale(1.02) translateY(-2px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes warningFloat {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-4px);
            }
        }

        @keyframes modalDesktop {
            0% {
                opacity: 0;
                transform: scale(0.92) translateY(12px);
            }
            60% {
                opacity: 1;
                transform: scale(1.02) translateY(-2px);
            }
            100% {
                opacity: 1;
                transform: scale(1) translateY(0);
            }
        }

        @keyframes modalMobile {
            0% {
                transform: translateY(100%);
            }
            100% {
                transform: translateY(0);
            }
        }

        @keyframes backdropFade {
            from { opacity: 0 }
            to { opacity: 1 }
        }

        /* Desktop animation */
        .animate-modal-desktop {
            animation: modalDesktop 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Mobile animation */
        .animate-modal-mobile {
            animation: modalMobile 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        .animate-backdrop {
            animation: backdropFade 0.25s ease-out forwards;
        }

        .animate-modal {
            animation: modalEnter 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-warning {
            animation: warningFloat 1.6s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gray-100">
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-5 right-5 z-50 flex items-start gap-3 bg-red-50 border border-red-400 text-red-700 px-6 py-4 rounded-xl shadow-lg" style="display: none;">
            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10" stroke-dasharray="62.8" stroke-dashoffset="62.8" class="animate-draw"/>
                <line x1="15" y1="9" x2="9" y2="15"/>
                <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <div>
                <h4 class="font-semibold text-red-800 mb-1">Terjadi Kesalahan</h4>
                <ul class="text-red-700 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Success Popup -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2" class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-50 border border-green-400 text-green-700 px-6 py-4 rounded-xl shadow-lg" style="display: none;">
            <svg class="w-6 h-6 text-green-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 13l4 4L19 7" stroke-dasharray="22" stroke-dashoffset="22" class="animate-draw"/>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <nav class="w-full bg-white shadow-sm relative z-10">
        <div class="w-full px-4 sm:px-6 md:px-12 py-2 sm:py-3 flex items-center justify-between">
            <div class="flex items-center gap-2 sm:gap-3">
                <img src="/images/LMS.png" alt="Logo" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 rounded-full object-cover">
            </div>

            <div class="flex items-center gap-4 sm:gap-6 text-sm">
                @auth
                    <div class="relative">
                        <button onclick="toggleDropdown()" class="flex items-center gap-1 sm:gap-2 focus:outline-none text-xs sm:text-sm">
                            <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                            <span class="hidden sm:inline text-gray-600">
                                {{ auth()->user()->nama }}
                            </span>
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div id="userDropdown" class="absolute right-0 mt-2 w-36 sm:w-44 bg-white rounded-xl sm:rounded-2xl shadow-lg border border-gray-100 hidden overflow-hidden text-xs sm:text-sm">
                            <a href="/settings" class="flex items-center gap-2 sm:gap-3 px-3 py-2 sm:px-4 sm:py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Settings
                            </a>

                            <!-- Profile -->
                            <a href="/profile" class="flex items-center gap-2 sm:gap-3 px-3 py-2 sm:px-4 sm:py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 sm:w-6 sm:h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Profile
                            </a>
                            <!-- Divider -->
                            <div class="h-px bg-gray-200 mx-2"></div>
                            <!-- Logout -->
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="button" onclick="openLogoutModal()" class="w-full flex items-center gap-2 sm:gap-3 px-3 py-2 sm:px-4 sm:py-3 text-red-500 hover:bg-red-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                        <path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 0 1 5.25 2h5.5A2.25 2.25 0 0 1 13 4.25v2a.75.75 0 0 1-1.5 0v-2a.75.75 0 0 0-.75-.75h-5.5a.75.75 0 0 0-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 0 0 .75-.75v-2a.75.75 0 0 1 1.5 0v2A2.25 2.25 0 0 1 10.75 18h-5.5A2.25 2.25 0 0 1 3 15.75V4.25Z" clip-rule="evenodd" />
                                        <path fill-rule="evenodd" d="M19 10a.75.75 0 0 0-.75-.75H8.704l1.048-.943a.75.75 0 1 0-1.004-1.114l-2.5 2.25a.75.75 0 0 0 0 1.114l2.5 2.25a.75.75 0 1 0 1.004-1.114l-1.048-.943h9.546A.75.75 0 0 0 19 10Z" clip-rule="evenodd" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Logout Modal -->
    <div id="logoutModal" class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center bg-black/40 backdrop-blur-sm animate-backdrop px-3 sm:px-0">
        <div class="bg-white w-full sm:max-w-sm rounded-t-2xl sm:rounded-2xl shadow-xl max-h-[90vh] overflow-y-auto animate-modal-mobile sm:animate-modal-desktop">
            <div class="p-6 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-red-100 animate-warning">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5 text-red-600">
                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0 l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72 c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5 a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5 A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" />
                    </svg>
                </div>

                <h3 class="text-base sm:text-lg font-semibold text-gray-800">
                    Logout sekarang?
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    Kamu harus login lagi untuk mengakses dashboard.
                </p>
            </div>

            <div class="flex flex-col-reverse sm:flex-row gap-3 px-6 pb-6">
                <button onclick="closeLogoutModal()" class="w-full rounded-xl border border-gray-300 px-4 py-3 sm:py-2 text-sm text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <form method="POST" action="/logout" class="w-full">
                    @csrf
                    <button type="submit" class="w-full rounded-xl bg-red-500 px-4 py-3 sm:py-2 text-sm font-semibold text-white hover:bg-red-600 transition">
                        Ya, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Hero -->
    <section class="bg-indigo-600 text-white">
        <div class="max-w-7xl mx-auto px-6 py-16 text-center">
            <h2 class="text-3xl font-bold mb-4">Selamat Datang di Dashboard Siswa</h2>
            <p class="text-lg mb-6">Ikuti kelas, pelajari materi, kerjakan tugas, dan pantau progres belajarmu.</p>
            <button onclick="openJoinClassModal()" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-semibold hover:bg-indigo-50 transition">
                Gabung Kelas
            </button>
        </div>
    </section>

    <!-- Join Class Modal -->
    <div id="joinClassModal" class="fixed inset-0 z-50 hidden items-end sm:items-center justify-center bg-black/40 backdrop-blur-sm px-3 sm:px-0">
        <div class="relative w-full sm:max-w-md rounded-t-2xl sm:rounded-2xl bg-white shadow-xl max-h-[90vh] overflow-y-auto animate-modal-mobile sm:animate-modal-desktop">
            <!-- Close Button -->
            <button onclick="closeJoinClassModal()" class="absolute right-4 top-4 z-10 text-gray-400 hover:text-gray-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <!-- Header -->
            <div class="px-5 sm:px-6 pt-8 text-center">
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
                        <path fill-rule="evenodd" d="M9.664 1.319a.75.75 0 0 1 .672 0 41.059 41.059 0 0 1 8.198 5.424.75.75 0 0 1-.254 1.285 31.372 31.372 0 0 0-7.86 3.83.75.75 0 0 1-.84 0 31.508 31.508 0 0 0-2.08-1.287V9.394c0-.244.116-.463.302-.592a35.504 35.504 0 0 1 3.305-2.033.75.75 0 0 0-.714-1.319 37 37 0 0 0-3.446 2.12A2.216 2.216 0 0 0 6 9.393v.38a31.293 31.293 0 0 0-4.28-1.746.75.75 0 0 1-.254-1.285 41.059 41.059 0 0 1 8.198-5.424ZM6 11.459a29.848 29.848 0 0 0-2.455-1.158 41.029 41.029 0 0 0-.39 3.114.75.75 0 0 0 .419.74c.528.256 1.046.53 1.554.82-.21.324-.455.63-.739.914a.75.75 0 1 0 1.06 1.06c.37-.369.69-.77.96-1.193a26.61 26.61 0 0 1 3.095 2.348.75.75 0 0 0 .992 0 26.547 26.547 0 0 1 5.93-3.95.75.75 0 0 0 .42-.739 41.053 41.053 0 0 0-.39-3.114 29.925 29.925 0 0 0-5.199 2.801 2.25 2.25 0 0 1-2.514 0c-.41-.275-.826-.541-1.25-.797a6.985 6.985 0 0 1-1.084 3.45 26.503 26.503 0 0 0-1.281-.78A5.487 5.487 0 0 0 6 12v-.54Z" clip-rule="evenodd" />
                    </svg>
                </div>
                <h3 class="text-lg sm:text-xl font-semibold text-gray-800">
                    Gabung Kelas
                </h3>
                <p class="mt-2 text-sm text-gray-500">
                    Masukkan token kelas dari guru untuk mulai belajar.
                </p>
            </div>

            <!-- Form -->
            <div class="px-5 sm:px-6 pt-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Token Kelas
                </label>
                <input type="text" placeholder="Contoh: KLS-8A23" class="w-full rounded-xl border border-gray-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <p class="mt-2 text-xs text-gray-400">
                    Token bersifat unik dan hanya berlaku untuk satu kelas.
                </p>
            </div>

            <!-- Actions -->
            <div class="flex flex-col-reverse sm:flex-row gap-3 px-5 sm:px-6 pb-6 pt-6">
                <button onclick="closeJoinClassModal()" class="w-full rounded-xl border border-gray-300 px-4 py-3 sm:py-2 text-sm text-gray-600 hover:bg-gray-100 transition">
                    Batal
                </button>
                <button class="w-full rounded-xl bg-indigo-600 px-4 py-3 sm:py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">
                    Join Kelas
                </button>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Optional: klik di luar = auto close
        document.addEventListener('click', function (event) {
            const button = event.target.closest('button');
            const dropdown = document.getElementById('userDropdown');

            if (!event.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }
        });

        function openLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeLogoutModal() {
            const modal = document.getElementById('logoutModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openJoinClassModal() {
            const modal = document.getElementById('joinClassModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeJoinClassModal() {
            const modal = document.getElementById('joinClassModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>
