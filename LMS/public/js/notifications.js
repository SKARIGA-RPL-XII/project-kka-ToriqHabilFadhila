// Enhanced Notification System with Modals and Delays
document.addEventListener('DOMContentLoaded', function () {

    // Show loading overlay
    window.showLoading = function () {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            overlay.classList.add('flex');
        }
    };

    // Hide loading overlay
    window.hideLoading = function () {
        const overlay = document.getElementById('loading-overlay');
        if (overlay) {
            overlay.classList.add('hidden');
            overlay.classList.remove('flex');
        }
    };

    // Show success modal with delay redirect
    window.showSuccessModal = function (message, redirectUrl = null, delay = 2000) {
        const modal = document.getElementById('success-modal');
        const messageEl = document.getElementById('success-message');
        const progressEl = document.getElementById('success-progress');

        if (modal && messageEl && progressEl) {
            messageEl.textContent = message;
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Animate modal entrance
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 50);

            // Start progress bar
            setTimeout(() => {
                progressEl.style.width = '100%';
            }, 100);

            // Redirect after delay
            if (redirectUrl) {
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, delay);
            } else {
                setTimeout(() => {
                    closeSuccessModal();
                }, delay);
            }
        }
    };

    // Close success modal
    window.closeSuccessModal = function () {
        const modal = document.getElementById('success-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };

    // Show error modal
    window.showErrorModal = function () {
        const modal = document.getElementById('error-modal');
        const messageEl = document.getElementById('error-message');

        if (modal && messageEl) {
            // Get error messages from notifications
            const errorNotification = document.querySelector('[x-data*="show: true"] .text-gray-700');
            if (errorNotification) {
                messageEl.innerHTML = errorNotification.innerHTML;
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // Animate modal entrance
            setTimeout(() => {
                modal.querySelector('.transform').classList.remove('scale-95');
                modal.querySelector('.transform').classList.add('scale-100');
            }, 50);
        }
    };

    // Close error modal
    window.closeErrorModal = function () {
        const modal = document.getElementById('error-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    };

    // Enhanced form submission with loading
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.tagName !== 'FORM') return;

        e.preventDefault(); // ⛔ tahan submit asli dulu

        const button = form.querySelector('button[type="submit"]');
        if (!button) return;

        const originalText = button.innerHTML;

        button.disabled = true;
        button.innerHTML = `
            <svg class="w-5 h-5 animate-spin mr-2 inline-block" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.2"/>
                <path d="M22 12a10 10 0 0 1-10 10" stroke="currentColor" stroke-width="4" fill="none"/>
            </svg>
            Memproses...
        `;

        // tampilkan overlay loading (opsional)
        setTimeout(() => {
            showLoading();
        }, 300);

        // kasih jeda UX, baru submit ke Laravel
        setTimeout(() => {
            form.submit(); // ✅ submit asli
        }, 800);
    });


    // Add custom CSS for better animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%) scale(0.95);
                opacity: 0;
            }
            to {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0) scale(1);
                opacity: 1;
            }
            to {
                transform: translateX(100%) scale(0.95);
                opacity: 0;
            }
        }

        @keyframes modalIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes modalOut {
            from {
                transform: scale(1);
                opacity: 1;
            }
            to {
                transform: scale(0.9);
                opacity: 0;
            }
        }

        #notification-container > div {
            animation: slideInRight 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .modal-content {
            animation: modalIn 0.3s ease-out;
        }

        @media (max-width: 640px) {
            #notification-container {
                top: 1rem;
                right: 1rem;
                left: 1rem;
                max-width: none;
            }
        }
    `;
    document.head.appendChild(style);
});

// Create dynamic notification
window.createNotification = function (type, message, duration = 4000) {
    const container = document.getElementById('notification-container');
    if (!container) return;

    const notification = document.createElement('div');
    notification.setAttribute('x-data', '{ show: true }');
    notification.setAttribute('x-show', 'show');
    notification.setAttribute('x-init', `setTimeout(() => show = false, ${duration})`);

    let borderColor, bgColor, iconBg, iconColor, icon, animationClass;

    switch (type) {
        case 'success':
            borderColor = 'border-green-500';
            bgColor = 'bg-white';
            iconBg = 'bg-green-100';
            iconColor = 'text-green-600';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>';
            animationClass = 'animate-bounce';
            break;
        case 'error':
            borderColor = 'border-red-500';
            bgColor = 'bg-white';
            iconBg = 'bg-red-100';
            iconColor = 'text-red-600';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>';
            animationClass = 'animate-pulse';
            break;
        case 'warning':
            borderColor = 'border-yellow-500';
            bgColor = 'bg-white';
            iconBg = 'bg-yellow-100';
            iconColor = 'text-yellow-600';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>';
            animationClass = 'animate-pulse';
            break;
        case 'info':
            borderColor = 'border-blue-500';
            bgColor = 'bg-white';
            iconBg = 'bg-blue-100';
            iconColor = 'text-blue-600';
            icon = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>';
            animationClass = 'animate-pulse';
            break;
    }

    notification.className = `${bgColor} border-l-4 ${borderColor} rounded-lg shadow-xl p-4 flex items-start gap-3 backdrop-blur-sm mb-3`;

    notification.innerHTML = `
        <div class="flex-shrink-0">
            <div class="w-8 h-8 ${iconBg} rounded-full flex items-center justify-center ${animationClass}">
                <svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${icon}
                </svg>
            </div>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-gray-900">${message}</p>
        </div>
        <button onclick="this.parentElement.remove()" class="flex-shrink-0 text-gray-400 hover:text-gray-600 transition-colors transform hover:scale-110">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    `;

    container.appendChild(notification);

    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, duration);

    return notification;
};
