<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/LMS.png') }}" type="image/png">
    <title>Profile - LMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    @include('components.navbar')

    <div class="w-full px-4 sm:px-6 md:px-16 py-12">
        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border-l-4 border-green-500 text-green-800 px-6 py-4 rounded-xl shadow-md flex items-start gap-3">
                <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <p class="font-semibold">{{ session('success') }}</p>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
            <!-- Profile Card -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <!-- Header with Gradient -->
                <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-8 py-12 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
                    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
                    <div class="relative flex items-center gap-6">
                        <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-3xl font-bold overflow-hidden ring-4 ring-white/30">
                            @if($user->avatar)
                                <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($user->nama, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold mb-1">{{ $user->nama }}</h1>
                            <div class="flex items-center gap-3">
                                <span class="inline-flex items-center gap-2 bg-white/20 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-medium">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"/>
                                    </svg>
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="text-purple-100 text-sm">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Profile Form -->
                <div class="p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900">Edit Profile</h2>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Avatar Upload -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-3">Foto Profile</label>
                            <div class="flex items-center gap-6">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center overflow-hidden ring-4 ring-purple-100">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="w-full h-full object-cover" id="avatarPreview">
                                    @else
                                        <span class="text-2xl font-bold text-purple-600" id="avatarInitial">{{ strtoupper(substr($user->nama, 0, 1)) }}</span>
                                        <img src="" alt="Preview" class="w-full h-full object-cover hidden" id="avatarPreview">
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <input type="file" name="avatar" accept="image/*" id="avatarInput" class="hidden">
                                    <button type="button" onclick="document.getElementById('avatarInput').click()" class="px-4 py-2 bg-purple-100 text-purple-700 rounded-lg hover:bg-purple-200 transition font-semibold text-sm">
                                        Pilih Foto
                                    </button>
                                    <p class="text-xs text-gray-500 mt-2">JPG, PNG (Max 2MB)</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4">
                            <a href="{{ route('dashboard') }}" class="px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 transition font-semibold">
                                Batal
                            </a>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 font-semibold shadow-lg">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Avatar preview
        document.getElementById('avatarInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('avatarPreview');
                    const initial = document.getElementById('avatarInitial');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (initial) initial.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>
