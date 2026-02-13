/* =====================================================
    ADMIN PANEL FUNCTIONS
===================================================== */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin panel loaded');
    
    // Load users when manage users modal opens
    const manageUsersBtn = document.querySelector('[onclick="openManageUsersModal()"]');
    if (manageUsersBtn) {
        manageUsersBtn.addEventListener('click', loadUsers);
    }
    
    // Load classes when manage classes modal opens
    const manageClassesBtn = document.querySelector('[onclick="openManageClassesModal()"]');
    if (manageClassesBtn) {
        manageClassesBtn.addEventListener('click', loadClasses);
    }
    
    // Load monitoring when monitoring modal opens
    const monitoringBtn = document.querySelector('[onclick="openMonitoringModal()"]');
    if (monitoringBtn) {
        monitoringBtn.addEventListener('click', loadMonitoring);
    }
});

// Load Users
function loadUsers() {
    fetch('/admin/users')
        .then(r => r.json())
        .then(users => {
            const container = document.querySelector('#manageUsersModal .space-y-3');
            if (!container) return;
            
            if (users.length === 0) {
                container.innerHTML = '<div class="text-center py-8 text-gray-500">Belum ada user</div>';
                return;
            }
            
            container.innerHTML = users.map(user => `
                <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-${getRoleColor(user.role)}-600 flex items-center justify-center text-white font-semibold">
                                ${user.nama.charAt(0).toUpperCase()}
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">${user.nama}</h4>
                                <p class="text-xs text-gray-500">${user.email} • ${capitalizeRole(user.role)}</p>
                            </div>
                        </div>
                        ${user.role !== 'admin' ? `
                        <div class="flex gap-2">
                            <button onclick="editUser(${user.id_user})" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick="deleteUser(${user.id_user}, '${user.nama}')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                        ` : `
                        <span class="px-3 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-full">Protected</span>
                        `}
                    </div>
                </div>
            `).join('');
        })
        .catch(err => {
            console.error('Error loading users:', err);
            const container = document.querySelector('#manageUsersModal .space-y-3');
            if (container) {
                container.innerHTML = '<div class="text-center py-8 text-red-500">Gagal memuat data users</div>';
            }
        });
}

// Helper functions
function getRoleColor(role) {
    const colors = { guru: 'blue', siswa: 'green', admin: 'red' };
    return colors[role] || 'gray';
}

function capitalizeRole(role) {
    return role.charAt(0).toUpperCase() + role.slice(1);
}

function editUser(id) {
    alert('Edit user feature coming soon!');
}

function deleteUser(id, name) {
    if (!confirm(`Hapus user "${name}"?`)) return;
    
    fetch(`/admin/users/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('User berhasil dihapus!');
            loadUsers();
        }
    })
    .catch(err => console.error('Error deleting user:', err));
}

// Load Classes
function loadClasses() {
    fetch('/admin/classes')
        .then(r => r.json())
        .then(classes => {
            const container = document.querySelector('#manageClassesModal .space-y-4');
            if (!container) return;
            
            const colors = ['blue', 'purple', 'green', 'orange', 'pink', 'indigo'];
            
            if (classes.length === 0) {
                container.innerHTML = '<div class="text-center py-8 text-gray-500">Belum ada kelas</div>';
                return;
            }
            
            container.innerHTML = classes.map((kelas, index) => {
                const color = colors[index % colors.length];
                return `
                <div class="p-4 bg-${color}-50 rounded-xl border border-${color}-200">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h4 class="font-bold text-gray-900">${kelas.nama_kelas} - ${kelas.deskripsi}</h4>
                            <p class="text-sm text-gray-600">Token: <span class="font-mono font-bold text-${color}-600">${kelas.active_token.token_code}</span></p>
                        </div>
                        <span class="px-3 py-1 bg-${color}-100 text-${color}-700 text-xs font-bold rounded-full">${kelas.enrollments_count} siswa</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-600">Guru: ${kelas.creator.nama}</p>
                        <div class="flex gap-2">
                            <button onclick="deleteClass(${kelas.id_class}, '${kelas.nama_kelas}')" class="px-3 py-1.5 text-sm text-red-600 hover:bg-red-100 rounded-lg transition font-medium">Hapus</button>
                        </div>
                    </div>
                </div>
                `;
            }).join('');
        })
        .catch(err => {
            console.error('Error loading classes:', err);
            const container = document.querySelector('#manageClassesModal .space-y-4');
            if (container) {
                container.innerHTML = '<div class="text-center py-8 text-red-500">Gagal memuat data kelas</div>';
            }
        });
}

function deleteClass(id, name) {
    if (!confirm(`Hapus kelas "${name}"?`)) return;
    
    fetch(`/admin/classes/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            alert('Kelas berhasil dihapus!');
            loadClasses();
        }
    })
    .catch(err => console.error('Error deleting class:', err));
}

// Load Monitoring
function loadMonitoring() {
    fetch('/admin/monitoring')
        .then(r => r.json())
        .then(data => {
            // Update stats
            document.querySelector('#monitoringModal .grid.grid-cols-2 .bg-blue-50 .text-2xl').textContent = data.total_assignments || 0;
            document.querySelector('#monitoringModal .grid.grid-cols-2 .bg-green-50 .text-2xl').textContent = data.avg_completion + '%' || '0%';
            document.querySelector('#monitoringModal .grid.grid-cols-2 .bg-purple-50 .text-2xl').textContent = data.total_materials || 0;
            document.querySelector('#monitoringModal .grid.grid-cols-2 .bg-orange-50 .text-2xl').textContent = data.active_today || 0;
            
            // Update progress by subject
            const progressContainer = document.querySelector('#monitoringModal .space-y-3');
            if (progressContainer && data.progress_by_subject) {
                const colors = ['blue', 'purple', 'green', 'orange'];
                progressContainer.innerHTML = data.progress_by_subject.map((item, index) => {
                    const color = colors[index % 4];
                    
                    return `
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm font-medium">${item.subject}</span>
                            <span class="text-sm font-bold text-${color}-600">${item.progress}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-${color}-600 h-2 rounded-full" style="width: ${item.progress}%"></div>
                        </div>
                    </div>
                    `;
                }).join('');
            }
        })
        .catch(err => console.error('Error loading monitoring:', err));
}
