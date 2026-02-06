<!-- Loading Overlay -->
<div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[10000] hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-8 max-w-sm mx-4 text-center">
        <div class="w-16 h-16 mx-auto mb-4 relative">
            <div class="w-16 h-16 border-4 border-blue-200 rounded-full animate-spin border-t-blue-600"></div>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Memproses...</h3>
        <p class="text-sm text-gray-600">Mohon tunggu sebentar</p>
    </div>
</div>

<!-- Success Modal -->
<div id="success-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[10000] hidden items-center justify-center">
    <div class="bg-white rounded-2xl p-8 max-w-sm mx-4 text-center transform scale-95 transition-transform duration-300">
        <div class="w-16 h-16 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-green-600 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Berhasil!</h3>
        <p id="success-message" class="text-sm text-gray-600 mb-4"></p>
        <div class="w-full bg-gray-200 rounded-full h-1">
            <div id="success-progress" class="bg-green-600 h-1 rounded-full transition-all duration-2000 ease-linear"
                style="width: 0%"></div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div id="error-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[10000] hidden items-center justify-center">
    <div
        class="bg-white rounded-2xl p-8 max-w-sm mx-4 text-center transform scale-95 transition-transform duration-300">
        <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
            <svg class="w-8 h-8 text-red-600 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Terjadi Kesalahan</h3>
        <div id="error-message" class="text-sm text-gray-600 mb-4"></div>
        <button onclick="closeErrorModal()"
            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            Tutup
        </button>
    </div>
</div>

<!-- Notification Container -->
<div id="notification-container" class="fixed top-4 right-4 z-[9999] space-y-3 max-w-sm w-full">
    <!-- Error Notifications -->
    @if ($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000);
        showErrorModal()"
            x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-95"
            class="bg-white border-l-4 border-red-500 rounded-lg shadow-xl p-4 flex items-start gap-3 backdrop-blur-sm">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <h4 class="text-sm font-semibold text-gray-900 mb-1">Terjadi Kesalahan</h4>
                <div class="text-sm text-gray-700">
                    @foreach ($errors->all() as $error)
                        <p class="mb-1 last:mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            <button @click="show = false"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors transform hover:scale-110">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Success Notifications -->
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="@if (session('redirect_delay') === true) setTimeout(() => show = false, 5000);
                        showSuccessModal('{{ session('success') }}', '{{ route('dashboard') }}', 2500);
                    @elseif(session('redirect_delay') === false)
                        setTimeout(() => show = false, 4000);
                        showSuccessModal('{{ session('success') }}');
                    @else
                        setTimeout(() => show = false, 5000);
                        showSuccessModal('{{ session('success') }}', '{{ route('dashboard') }}', 2500); @endif"
            x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-95"
            class="bg-white border-l-4 border-green-500 rounded-lg shadow-xl p-4 flex items-start gap-3 backdrop-blur-sm">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center animate-bounce">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ session('success') }}</p>
            </div>
            <button @click="show = false"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors transform hover:scale-110">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Warning Notifications -->
    @if (session('warning'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5500)"
            x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-95"
            class="bg-white border-l-4 border-yellow-500 rounded-lg shadow-xl p-4 flex items-start gap-3 backdrop-blur-sm">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ session('warning') }}</p>
            </div>
            <button @click="show = false"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors transform hover:scale-110">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    <!-- Info Notifications -->
    @if (session('info'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="transform ease-out duration-500"
            x-transition:enter-start="translate-x-full opacity-0 scale-95"
            x-transition:enter-end="translate-x-0 opacity-100 scale-100"
            x-transition:leave="transform ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100 scale-100"
            x-transition:leave-end="translate-x-full opacity-0 scale-95"
            class="bg-white border-l-4 border-blue-500 rounded-lg shadow-xl p-4 flex items-start gap-3 backdrop-blur-sm">
            <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ session('info') }}</p>
            </div>
            <button @click="show = false"
                class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors transform hover:scale-110">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif
</div>

<script src="{{ asset('js/notifications.js') }}"></script>
