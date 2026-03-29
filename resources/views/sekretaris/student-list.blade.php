@extends('layouts.app')

@section('content')

<!-- Student List Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ PILIH SISWA ~</h2>
    
    <!-- Search Bar -->
    <div class="pixel-card p-4 bg-white mb-6">
        <div class="flex items-center space-x-4">
            <input type="text" id="search-student" placeholder="Cari nama siswa..." 
                   class="pixel-card flex-1 p-3 border-2 border-gray-300 focus:border-blue-500 focus:outline-none pixel-font text-sm">
            <button onclick="loadStudents()" class="pixel-card px-6 py-3 bg-blue-500 text-white pixel-font text-sm hover:bg-blue-600 transition-colors">
                🔍 Cari
            </button>
        </div>
    </div>
    
    <!-- Student List -->
    <div class="pixel-card p-6 bg-white">
        <h3 class="pixel-font text-sm text-gray-900 mb-4">~ DAFTAR SISWA ~</h3>
        <div class="space-y-2 max-h-96 overflow-y-auto" id="student-list">
            <div class="text-center pixel-font text-gray-500 py-8">
                Loading student data...
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="max-w-6xl mx-auto mt-6">
    <a href="{{ route('sekretaris.dashboard') }}" class="pixel-card p-4 bg-gray-200 hover:bg-gray-300 text-center block">
        <div class="pixel-font text-2xl text-gray-600 mb-2">← Kembali ke Dashboard</div>
    </a>
</div>

<script>
let students = [];
let searchQuery = '';

// Load all students
function loadStudents() {
    showLoading();
    searchQuery = document.getElementById('search-student').value.toLowerCase();
    
    fetch('/sekretaris/api/absensi-hari-ini')
        .then(response => response.json())
        .then(data => {
            students = data;
            renderStudents();
            hideLoading();
        })
        .catch(error => {
            console.error('Error loading students:', error);
            hideLoading();
        });
}

// Render student list
function renderStudents() {
    const container = document.getElementById('student-list');
    
    const filteredStudents = students.filter(student => 
        student.name.toLowerCase().includes(searchQuery)
    );
    
    if (filteredStudents.length === 0) {
        container.innerHTML = '<div class="text-center pixel-font text-gray-500 py-8">Tidak ada siswa yang ditemukan</div>';
        return;
    }
    
    container.innerHTML = filteredStudents.map(student => `
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded hover:bg-gray-100 transition-colors cursor-pointer">
            <div class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold mr-3">
                    ${student.name.charAt(0).toUpperCase()}
                </div>
                <div>
                    <span class="text-sm font-medium">${student.name}</span>
                    <p class="text-xs text-gray-600">${student.email}</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <a href="/sekretaris/absensi" 
                   class="pixel-card px-3 py-1 bg-green-500 text-white text-xs hover:bg-green-600 transition-colors">
                    ✅ Absensi
                </a>
            </div>
        </div>
    `).join('');
}


// Loading states
function showLoading() {
    document.getElementById('student-list').innerHTML = '<div class="text-center pixel-font text-gray-500 py-8">Loading...</div>';
}

function hideLoading() {
    // Loading will be replaced by actual data
}

// Search functionality
document.getElementById('search-student').addEventListener('input', function(e) {
    searchQuery = e.target.value.toLowerCase();
    renderStudents();
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    loadStudents();
});
</script>
@endsection
