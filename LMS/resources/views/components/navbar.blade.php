@php
    $accountPage = request()->routeIs('profile', 'settings');
    $isDashboard = request()->routeIs('dashboard');
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
                    <!-- Notification Bell -->
                    @php
                        $unreadCount = \App\Models\Notification::where('id_user', auth()->user()->id_user)
                            ->where('is_read', false)
                            ->count();
                    @endphp
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-indigo-600 hover:bg-gray-100 rounded-lg transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if($unreadCount > 0)
                                <span class="absolute top-0 right-0 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                            @endif
                        </button>

                        <div x-show="open" @click.away="open = false" style="display: none;" class="absolute right-0 mt-2 w-80 bg-white rounded-xl shadow-lg border border-gray-100 max-h-96 overflow-y-auto z-50">
                            <div class="p-4 border-b border-gray-100">
                                <h3 class="font-bold text-gray-900">Notifikasi</h3>
                            </div>
                            @php
                                $notifications = \App\Models\Notification::where('id_user', auth()->user()->id_user)
                                    ->orderBy('created_at', 'desc')
                                    ->limit(10)
                                    ->get();
                            @endphp
                            @forelse($notifications as $notif)
                                <a href="{{ route('notifications.read', $notif->id_notification) }}"
                                   class="block p-4 hover:bg-gray-50 transition {{ !$notif->is_read ? 'bg-indigo-50' : '' }}">
                                    <div class="flex gap-3">
                                        <div class="flex-shrink-0">
                                            @if($notif->type === 'deadline')
                                                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @elseif($notif->type === 'grade')
                                                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-900">{{ $notif->title }}</p>
                                            <p class="text-xs text-gray-600 mt-1">{{ $notif->message }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                    </svg>
                                    <p class="text-sm">Tidak ada notifikasi</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- USER DROPDOWN -->
                    @if($isDashboard)
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
                    @endif
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
                    @elseif ($isDashboard)
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
                    @else
                        <!-- OTHER PAGES - SHOW BACK BUTTON -->
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 sm:px-4 py-2 rounded-lg bg-indigo-600 text-white font-semibold hover:bg-indigo-700 transition shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span class="hidden sm:inline">Kembali</span>
                        </a>
                    @endif
                @endguest
            </div>
        </div>
    </div>
</nav>
