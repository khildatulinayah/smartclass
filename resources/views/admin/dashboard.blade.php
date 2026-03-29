@extends('layouts.app')

@section('content')
<!-- Struktur Kepengurusan Kelas Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ STRUKTUR KEPENGURUSAN ~</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="pixel-card p-3 bg-red-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">KETUA</p>
            <p class="pixel-font text-xs font-bold text-red-700">Muhammad Akhdan Rafa</p>
        </div>
        <div class="pixel-card p-3 bg-blue-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">WAKIL</p>
            <p class="pixel-font text-xs font-bold text-blue-700">Radithya Akhmad Prianarengga</p>
        </div>
        <div class="pixel-card p-3 bg-green-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">SEKRETARIS 1</p>
            <p class="pixel-font text-xs font-bold text-green-700">Meilani Virastika</p>
        </div>
        <div class="pixel-card p-3 bg-purple-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">SEKRETARIS 2</p>
            <p class="pixel-font text-xs font-bold text-purple-700">Izza Nur Asykarina</p>
        </div>
        <div class="pixel-card p-3 bg-yellow-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">BENDAHARA 1</p>
            <p class="pixel-font text-xs font-bold text-yellow-700">Dita Wahyu Anggraeni</p>
        </div>
        <div class="pixel-card p-3 bg-orange-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">BENDAHARA 2</p>
            <p class="pixel-font text-xs font-bold text-orange-700">Chica Nafril Zahra</p>
        </div>
        <div class="pixel-card p-3 bg-pink-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">WALI KELAS</p>
            <p class="pixel-font text-xs font-bold text-pink-700">Halimatus Sa'diyah</p>
        </div>
        <div class="pixel-card p-3 bg-indigo-300 text-center">
            <div class="pixel-font text-2xl mb-2">⭐</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">SPECIAL</p>
            <p class="pixel-font text-xs font-bold text-indigo-700">MEMBERS</p>
        </div>
    </div>
</div>

<!-- Jadwal Piket Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ JADWAL PIKET ~</h2>
    <div class="pixel-card p-4 bg-green-200">
        <div class="grid grid-cols-5 gap-4">
            <!-- Senin -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-green-600 text-white text-xs pixel-font font-bold mb-2">SENIN</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Amel</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Alfina</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Dita</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Dhiya'</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Andika</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Shakti</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Rahma</p>
                </div>
            </div>
            <!-- Selasa -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-yellow-500 text-white text-xs pixel-font font-bold mb-2">SELASA</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Chica</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Fahri</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Rizqi</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Gizel</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Riya</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Devi</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Azzam</p>
                </div>
            </div>
            <!-- Rabu -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-green-600 text-white text-xs pixel-font font-bold mb-2">RABU</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Sahrul</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Satya</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Diral</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Rafa</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Putri</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Nasya</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Naya</p>
                </div>
            </div>
            <!-- Kamis -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-yellow-500 text-white text-xs pixel-font font-bold mb-2">KAMIS</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Frisky</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Raihan</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Izza</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Wiwid</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Keisya</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Silvia</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Fadhil</p>
                </div>
            </div>
            <!-- Jumat -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-green-600 text-white text-xs pixel-font font-bold mb-2">JUMAT</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Dhea</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Novta</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Fathima</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Ageng</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Radit</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Rafi</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Nadia</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Admin Dashboard -->
<div class="mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ ADMIN DASHBOARD ~</h2>
    
    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Students Management -->
            <a href="{{ route('admin.students') }}" class="pixel-card p-6 bg-blue-400 hover:bg-blue-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-700 mb-4">👥</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">MANAJEMEN SISWA</h3>
                <p class="text-xs text-gray-700">Tambah, edit, hapus data siswa</p>
            </a>
            
            <!-- Reports -->
            <a href="{{ route('admin.reports') }}" class="pixel-card p-6 bg-green-300 hover:bg-green-200 text-center">
                <div class="pixel-font text-4xl text-green-600 mb-4">📊</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN</h3>
                <p class="text-xs text-gray-700">Laporan lengkap sistem</p>
            </a>
            
            <!-- Settings -->
            <div class="pixel-card p-6 bg-purple-300 text-center">
                <div class="pixel-font text-4xl text-purple-600 mb-4">⚙️</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">PENGATURAN</h3>
                <p class="text-xs text-gray-700">Konfigurasi sistem</p>
            </div>
        </div>
    </div>
</div>

@endsection
