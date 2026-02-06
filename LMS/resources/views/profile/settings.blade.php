<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Learning Management System Berbasis AI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    @include('components.notifications')
    @include('components.navbar')

    <!-- Main Content -->
    <section class="w-full px-4 sm:px-6 md:px-16 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-md p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Pengaturan</h3>
                    <nav class="space-y-2">
                        <a href="#password" onclick="showSection('password')" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition">
                            <i class="fa-solid fa-lock w-5 text-center"></i> Ubah Password
                        </a>
                        <a href="#notifications" onclick="showSection('notifications')" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition">
                            <i class="fa-solid fa-bell w-5 text-center"></i> Notifikasi
                        </a>
                        <a href="#privacy" onclick="showSection('privacy')" class="block px-4 py-2 text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-lg transition">
                            <i class="fa-solid fa-shield-halved w-5 text-center"></i> Privasi
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Content -->
            <div class="lg:col-span-3">
                <!-- Password Section -->
                <div id="password-section" class="bg-white rounded-2xl shadow-md p-6 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Ubah Password</h2>
                    <form method="POST" action="{{ route('profile.password') }}" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                            <input type="password" name="current_password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition font-semibold">
                                Ubah Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Notifications Section -->
                <div id="notifications-section" class="bg-white rounded-2xl shadow-md p-6 mb-6 hidden">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Notifikasi</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-semibold text-gray-900">Email Notifikasi</h3>
                                <p class="text-sm text-gray-600">Terima notifikasi melalui email</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-semibold text-gray-900">Notifikasi Tugas</h3>
                                <p class="text-sm text-gray-600">Pengingat deadline tugas</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Privacy Section -->
                <div id="privacy-section" class="bg-white rounded-2xl shadow-md p-6 hidden">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Pengaturan Privasi</h2>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-semibold text-gray-900">Profile Publik</h3>
                                <p class="text-sm text-gray-600">Tampilkan profile ke pengguna lain</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-xl">
                            <div>
                                <h3 class="font-semibold text-gray-900">Status Online</h3>
                                <p class="text-sm text-gray-600">Tampilkan status online</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Dropdown Toggle
        function toggleDropdown() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (event) {
            const dropdown = document.getElementById('userDropdown');
            if (!event.target.closest('.relative')) {
                dropdown.classList.add('hidden');
            }
        });

        function showSection(section) {
            // Hide all sections
            document.querySelectorAll('[id$="-section"]').forEach(el => el.classList.add('hidden'));
            // Show selected section
            document.getElementById(section + '-section').classList.remove('hidden');
        }
    </script>
</body>
</html>
