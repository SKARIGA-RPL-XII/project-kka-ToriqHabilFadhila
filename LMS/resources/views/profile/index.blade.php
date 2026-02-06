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
        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-purple-600 to-indigo-600 px-6 py-8 text-white">
                <div class="flex items-center gap-4">
                    <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold">
                        @if($user->avatar)
                            <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="w-full h-full rounded-full object-cover">
                        @else
                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                        @endif
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">{{ $user->nama }}</h1>
                        <p class="text-purple-100">{{ ucfirst($user->role) }}</p>
                        <p class="text-purple-200 text-sm">{{ $user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Profile Form -->
            <div class="p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Profile</h2>
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <!-- Avatar Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Foto Profile</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xl font-bold text-gray-600">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                                @endif
                            </div>
                            <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ $user->nama }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-purple-600 text-white rounded-xl hover:bg-purple-700 transition font-semibold">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
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
    </script>
</body>
</html>
