/* =====================================================
    APP UI CORE
    Dropdown • Modals • Logout • Notifications • Loading
===================================================== */
document.addEventListener('DOMContentLoaded', function () {
    /* =====================
        DROPDOWN
    ====================== */
    window.toggleDropdown = function () {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) dropdown.classList.toggle('hidden');
    };

    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('userDropdown');
        if (!dropdown) return;
        if (!e.target.closest('.relative')) dropdown.classList.add('hidden');
    });

    /* =====================
        MODAL CORE
    ====================== */
    window.openModal = function (id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    };

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    };

    /* =====================
        MODAL ALIASES
    ====================== */
    [
        'createClass',
        'uploadMateri',
        'createTugas',
        'jawabanSiswa',
        'addUser',
        'manageUsers',
        'manageClasses',
        'monitoring',
        'joinClass',
        'logout',
        'token',
        'editDeadline'
    ].forEach(name => {
        window[`open${capitalize(name)}Modal`] = () => openModal(`${name}Modal`);
        window[`close${capitalize(name)}Modal`] = () => closeModal(`${name}Modal`);
    });

    /* =====================
        DRAG & DROP FILE
    ===================== */
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('fileInput');
    const fileName = document.getElementById('fileName');

    if (dropzone && fileInput) {

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            });
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.add('border-blue-500', 'bg-blue-50');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, () => {
                dropzone.classList.remove('border-blue-500', 'bg-blue-50');
            });
        });

        dropzone.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (!files.length) return;

            fileInput.files = files;

            if (fileName) {
                fileName.textContent = files[0].name;
                fileName.classList.remove('hidden');
            }
        });

        fileInput.addEventListener('change', () => {
            if (!fileInput.files.length) return;

            if (fileName) {
                fileName.textContent = fileInput.files[0].name;
                fileName.classList.remove('hidden');
            }
        });
    }
    

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    /* =====================
        LOGOUT (LARAVEL SAFE)
    ====================== */
    window.handleLogout = function () {
        const form = document.getElementById('logout-form');
        if (!form) {
            console.error('Logout form not found');
            return;
        }
        form.submit();
    };

    /* =====================
        TOKEN MODAL
    ====================== */
    window.openTokenModal = function (token) {
        const tokenEl = document.getElementById('tokenValue');
        if (tokenEl) tokenEl.innerText = token;
        openModal('tokenModal');
    };

    /* =====================
        JOIN CLASS
    ====================== */
    window.handleJoinClass = function (e) {
        e.preventDefault();
        const token = document.getElementById('classToken')?.value;
        if (!token) return;
        e.target.submit();
    };

    /* =====================
        EDIT DEADLINE
    ====================== */
    window.openEditDeadlineModal = function (assignmentId, currentDeadline) {
        const form = document.getElementById('editDeadlineForm');
        const input = document.getElementById('deadlineInput');
        if (form && input) {
            form.action = `/guru/assignments/${assignmentId}/deadline`;
            input.value = currentDeadline;
            openModal('editDeadlineModal');
        }
    };

    /* =====================
        ESC KEY CLOSE
    ====================== */
    document.addEventListener('keydown', function (e) {
        if (e.key !== 'Escape') return;
        document.querySelectorAll('.fixed.inset-0.flex').forEach(modal => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
        document.body.style.overflow = '';
    });

    /* =====================
        BACKDROP CLICK CLOSE
    ====================== */
    document.querySelectorAll('.fixed.inset-0').forEach(modal => {
        modal.addEventListener('click', function (e) {
            if (e.target === this) closeModal(this.id);
        });
    });

    /* =====================
        LOADING OVERLAY
    ====================== */
    window.showLoading = function () {
        const overlay = document.getElementById('loading-overlay');
        if (!overlay) return;
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
    };

    window.hideLoading = function () {
        const overlay = document.getElementById('loading-overlay');
        if (!overlay) return;
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
    };

    /* =====================
        FORM UX DELAY
    ====================== */
    document.addEventListener('submit', function (e) {
        const form = e.target;
        if (form.dataset.noUx !== undefined) return;

        const btn = form.querySelector('button[type="submit"]');
        if (!btn) return;

        e.preventDefault();

        const original = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = `
            <svg class="w-5 h-5 animate-spin inline mr-2" viewBox="0 0 24 24">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" opacity="0.2"/>
                <path d="M22 12a10 10 0 0 1-10 10" stroke="currentColor" stroke-width="4" fill="none"/>
            </svg>
            Memproses...
        `;

        setTimeout(showLoading, 300);
        setTimeout(() => form.submit(), 800);
    });

});

/* =====================================================
    NOTIFICATION SYSTEM
===================================================== */

window.createNotification = function (type, message, duration = 4000) {
    const container = document.getElementById('notification-container');
    if (!container) return;

    const colors = {
        success: ['border-green-500', 'bg-green-100', 'text-green-600'],
        error: ['border-red-500', 'bg-red-100', 'text-red-600'],
        warning: ['border-yellow-500', 'bg-yellow-100', 'text-yellow-600'],
        info: ['border-blue-500', 'bg-blue-100', 'text-blue-600']
    };

    const [border, iconBg, iconColor] = colors[type] || colors.info;

    const el = document.createElement('div');
    el.className = `bg-white border-l-4 ${border} rounded-lg shadow-xl p-4 flex gap-3 mb-3`;
    el.innerHTML = `
        <div class="w-8 h-8 ${iconBg} rounded-full flex items-center justify-center">
            <span class="${iconColor} font-bold">!</span>
        </div>
        <div class="flex-1 text-sm text-gray-800">${message}</div>
        <button onclick="this.parentElement.remove()" class="text-gray-400 hover:text-gray-600">✕</button>
    `;

    container.appendChild(el);
    setTimeout(() => el.remove(), duration);
};

/* =====================================================
    STYLE INJECT
===================================================== */
const style = document.createElement('style');
style.textContent = `
    .animate-spin { animation: spin 1s linear infinite }
    @keyframes spin { to { transform: rotate(360deg) } }
`;
document.head.appendChild(style);
