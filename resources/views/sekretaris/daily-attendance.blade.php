@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Absensi Harian</h1>
        <p class="text-gray-600">{{ \Carbon\Carbon::parse($today)->locale('id')->format('l, d F Y') }}</p>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-green-100 border border-green-300 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-800" id="hadir-count">0</div>
            <div class="text-sm text-green-600">Hadir</div>
        </div>
        <div class="bg-yellow-100 border border-yellow-300 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-yellow-800" id="sakit-count">0</div>
            <div class="text-sm text-yellow-600">Sakit</div>
        </div>
        <div class="bg-blue-100 border border-blue-300 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-800" id="izin-count">0</div>
            <div class="text-sm text-blue-600">Izin</div>
        </div>
        <div class="bg-red-100 border border-red-300 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-red-800" id="alpha-count">0</div>
            <div class="text-sm text-red-600">Alpha</div>
        </div>
    </div>

    <!-- Filter & Search -->
    <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
        <div class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" id="search-student" placeholder="Cari nama siswa..." 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <div class="flex gap-2">
                <button onclick="filterByStatus('all')" class="filter-btn px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Semua
                </button>
                <button onclick="filterByStatus('hadir')" class="filter-btn px-4 py-2 bg-green-200 text-green-700 rounded-lg hover:bg-green-300 transition">
                    Hadir
                </button>
                <button onclick="filterByStatus('sakit')" class="filter-btn px-4 py-2 bg-yellow-200 text-yellow-700 rounded-lg hover:bg-yellow-300 transition">
                    Sakit
                </button>
                <button onclick="filterByStatus('izin')" class="filter-btn px-4 py-2 bg-blue-200 text-blue-700 rounded-lg hover:bg-blue-300 transition">
                    Izin
                </button>
                <button onclick="filterByStatus('alpha')" class="filter-btn px-4 py-2 bg-red-200 text-red-700 rounded-lg hover:bg-red-300 transition">
                    Alpha
                </button>
            </div>
        </div>
    </div>

    <!-- Students List -->
    <div id="students-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- Student cards will be loaded here -->
    </div>

    <!-- Loading State -->
    <div id="loading" class="text-center py-8 hidden">
        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
        <p class="mt-2 text-gray-600">Memuat data...</p>
    </div>

    <!-- Empty State -->
    <div id="empty-state" class="text-center py-12 hidden">
        <div class="text-gray-400 text-6xl mb-4">📚</div>
        <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada siswa ditemukan</h3>
        <p class="text-gray-500">Coba ubah filter atau kata kunci pencarian</p>
    </div>
</div>

<!-- Success Toast -->
<div id="success-toast" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-y-full transition-transform duration-300 z-50">
    <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        <span id="toast-message">Status berhasil diperbarui!</span>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let students = [];
    let currentFilter = 'all';
    let searchQuery = '';

    // Load initial data
    loadStudents();
    
    // Search functionality
    document.getElementById('search-student').addEventListener('input', function(e) {
        searchQuery = e.target.value.toLowerCase();
        renderStudents();
    });

    function loadStudents() {
        showLoading();
        fetch('{{ route("sekretaris.api.absensi_hari_ini") }}')
            .then(response => response.json())
            .then(data => {
                students = data;
                renderStudents();
                updateStats();
                hideLoading();
            })
            .catch(error => {
                console.error('Error loading students:', error);
                hideLoading();
            });
    }

    function renderStudents() {
        const container = document.getElementById('students-container');
        const emptyState = document.getElementById('empty-state');
        
        // Filter students
        let filteredStudents = students.filter(student => {
            const matchesSearch = student.name.toLowerCase().includes(searchQuery);
            const matchesFilter = currentFilter === 'all' || student.status === currentFilter;
            return matchesSearch && matchesFilter;
        });

        if (filteredStudents.length === 0) {
            container.innerHTML = '';
            emptyState.classList.remove('hidden');
            return;
        }

        emptyState.classList.add('hidden');
        container.innerHTML = filteredStudents.map(student => createStudentCard(student)).join('');
        
        // Add click handlers to status buttons
        document.querySelectorAll('.status-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const studentId = this.dataset.studentId;
                const newStatus = this.dataset.status;
                updateStudentStatus(studentId, newStatus);
            });
        });
    }

    function createStudentCard(student) {
        const statusConfig = getStatusConfig(student.status);
        const otherStatuses = ['hadir', 'sakit', 'izin', 'alpha'].filter(s => s !== student.status);
        
        return `
            <div class="bg-white rounded-lg shadow-sm border hover:shadow-md transition-shadow duration-200 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center mb-3">
                        <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                            <span class="text-gray-600 font-semibold">${student.name.charAt(0).toUpperCase()}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800">${student.name}</h3>
                            <p class="text-sm text-gray-500">ID: ${student.id}</p>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="${statusConfig.badgeClass} px-3 py-1 rounded-full text-xs font-semibold">
                                ${statusConfig.label}
                            </span>
                        </div>
                    </div>
                    
                    <div class="border-t pt-3">
                        <p class="text-xs text-gray-500 mb-2">Ubah status:</p>
                        <div class="grid grid-cols-2 gap-2">
                            ${otherStatuses.map(status => {
                                const config = getStatusConfig(status);
                                return `
                                    <button class="status-btn ${config.btnClass} px-3 py-2 rounded text-xs font-medium transition hover:opacity-80"
                                            data-student-id="${student.id}" 
                                            data-status="${status}">
                                        ${config.label}
                                    </button>
                                `;
                            }).join('')}
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function getStatusConfig(status) {
        const configs = {
            hadir: {
                label: 'Hadir',
                badgeClass: 'bg-green-100 text-green-800',
                btnClass: 'bg-green-500 text-white'
            },
            sakit: {
                label: 'Sakit',
                badgeClass: 'bg-yellow-100 text-yellow-800',
                btnClass: 'bg-yellow-500 text-white'
            },
            izin: {
                label: 'Izin',
                badgeClass: 'bg-blue-100 text-blue-800',
                btnClass: 'bg-blue-500 text-white'
            },
            alpha: {
                label: 'Alpha',
                badgeClass: 'bg-red-100 text-red-800',
                btnClass: 'bg-red-500 text-white'
            }
        };
        return configs[status] || configs.hadir;
    }

    function updateStudentStatus(studentId, newStatus) {
        const btn = document.querySelector(`[data-student-id="${studentId}"][data-status="${newStatus}"]`);
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<span class="inline-block animate-spin">⏳</span>';
        }

        fetch('{{ route("sekretaris.absensi.update") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                student_id: studentId,
                status: newStatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update local data
                const student = students.find(s => s.id == studentId);
                if (student) {
                    student.status = newStatus;
                }
                
                // Re-render
                renderStudents();
                updateStats();
                showToast('Status absensi berhasil diperbarui!');
            } else {
                throw new Error(data.message || 'Update failed');
            }
        })
        .catch(error => {
            console.error('Error updating status:', error);
            showToast('Gagal memperbarui status', 'error');
            loadStudents(); // Reload to restore original state
        });
    }

    function updateStats() {
        const stats = {
            hadir: 0,
            sakit: 0,
            izin: 0,
            alpha: 0
        };

        students.forEach(student => {
            if (stats.hasOwnProperty(student.status)) {
                stats[student.status]++;
            }
        });

        document.getElementById('hadir-count').textContent = stats.hadir;
        document.getElementById('sakit-count').textContent = stats.sakit;
        document.getElementById('izin-count').textContent = stats.izin;
        document.getElementById('alpha-count').textContent = stats.alpha;
    }

    function filterByStatus(status) {
        currentFilter = status;
        
        // Update button styles
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('ring-2', 'ring-offset-2', 'ring-blue-500');
        });
        event.target.classList.add('ring-2', 'ring-offset-2', 'ring-blue-500');
        
        renderStudents();
    }

    function showLoading() {
        document.getElementById('loading').classList.remove('hidden');
        document.getElementById('students-container').classList.add('hidden');
    }

    function hideLoading() {
        document.getElementById('loading').classList.add('hidden');
        document.getElementById('students-container').classList.remove('hidden');
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('success-toast');
        const toastMessage = document.getElementById('toast-message');
        
        toastMessage.textContent = message;
        
        if (type === 'error') {
            toast.className = toast.className.replace('bg-green-500', 'bg-red-500');
        } else {
            toast.className = toast.className.replace('bg-red-500', 'bg-green-500');
        }
        
        toast.classList.remove('translate-y-full');
        
        setTimeout(() => {
            toast.classList.add('translate-y-full');
        }, 3000);
    }
});
</script>
@endsection
