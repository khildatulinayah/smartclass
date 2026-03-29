@extends('layouts.app')

@section('content')
<!-- Admin Dashboard -->
<div class="mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ ADMIN DASHBOARD ~</h2>
    
    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.students') }}" class="pixel-card p-6 bg-blue-400 hover:bg-blue-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-700 mb-4">👥</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">MANAJEMEN SISWA</h3>
                <p class="text-xs text-gray-700">Kelola data siswa</p>
            </a>
            
            <a href="{{ route('admin.reports') }}" class="pixel-card p-6 bg-green-400 hover:bg-green-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-green-700 mb-4">📊</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN</h3>
                <p class="text-xs text-gray-700">Lihat laporan lengkap</p>
            </a>
            
        </div>
    </div>
    
    <!-- Reports Section -->
    <div class="max-w-6xl mx-auto mt-8">
        <h2 class="pixel-font text-center text-yellow-400 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ REPORT ~</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.reports') }}?type=attendance" class="pixel-card p-6 bg-blue-300 hover:bg-blue-200 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-600 mb-4">📈</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN ABSENSI</h3>
                <p class="text-xs text-gray-700">Data kehadiran siswa</p>
            </a>
            
            <a href="{{ route('bendahara.laporan') }}" class="pixel-card p-6 bg-green-300 hover:bg-green-200 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-green-600 mb-4">💰</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN KAS</h3>
                <p class="text-xs text-gray-700">Data keuangan kelas</p>
            </a>
        </div>
    </div>
</div>

@endsection
