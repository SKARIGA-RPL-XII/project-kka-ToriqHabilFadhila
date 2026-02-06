@php
    $accountPage = request()->routeIs('profile', 'settings');
@endphp

<nav class="w-full bg-white shadow-sm relative z-10 transition-all duration-300">
    <div class="w-full px-4 sm:px-6 md:px-16 py-2 sm:py-3">
        <div class="flex justify-between items-center">
            {{-- Logo --}}
            <div class="flex items-center space-x-2">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                    <img src="{{ asset('images/LMS.png') }}" alt="LMS Logo" class="w-12 h-12">
                </div>
            </div>

            {{-- Auth Buttons --}}
            <div class="flex items-center space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-purple-600 font-medium transition-colors">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 gradient-primary text-white rounded-lg font-medium hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                        Daftar Gratis
                    </a>
                @else
                    <!-- USER DROPDOWN -->
                    <div class="relative">
                        <button onclick="toggleDropdown()"
                            class="flex items-center gap-2 focus:outline-none hover:bg-gray-50 rounded-lg px-2 py-1.5 transition">
                            <!-- Avatar -->
                            <div
                                class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}
                            </div>
                            <!-- Nama User - Hidden di Mobile -->
                            <span class="hidden sm:inline text-gray-700 font-medium">
                                {{ auth()->user()->nama }}
                            </span>
                            <!-- Chevron - Hidden di Mobile -->
                            <svg class="hidden sm:block w-4 h-4 text-gray-500" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- DROPDOWN MENU -->
                        <div id="userDropdown"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 hidden overflow-hidden z-50">
                            <a href="{{ route('profile') }}"
                                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile
                            </a>
                            <a href="{{ route('settings') }}"
                                class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-gray-50 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Settings
                            </a>
                            <div class="h-px bg-gray-200 my-1"></div>
                            <button type="submit" onclick="openLogoutModal()"
                                class="w-full flex items-center gap-3 text-left px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </div>
                    </div>
                    @php
                        $role = auth()->user()->role;
                    @endphp
                    @if ($accountPage)
                        <!-- ACCOUNT PAGE (PROFILE / SETTINGS) -->
                        <button onclick="window.history.back()"
                            class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="hidden sm:inline">Kembali</span>
                        </button>
                    @else
                        @if ($role === 'siswa')
                            <!-- SISWA -->
                            <button onclick="openJoinClassModal()"
                                class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                                <span class="hidden sm:inline">Join Kelas</span>
                            </button>
                        @elseif ($role === 'guru')
                            <!-- GURU -->
                            <button onclick="openCreateClassModal()"
                                class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                                <span class="hidden sm:inline">Buat Kelas</span>
                            </button>
                        @elseif ($role === 'admin')
                            <!-- ADMIN -->
                            <button onclick="openManageClassModal()"
                                class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                </svg>
                                <span class="hidden sm:inline">Kelola Kelas</span>
                            </button>
                        @endif
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>
