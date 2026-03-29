@extends('layouts.app')

@section('content')
<!-- Sekretaris Dashboard -->
<div class="mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ SEKRETARIS DASHBOARD ~</h2>
    
    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('sekretaris.absensi') }}" class="pixel-card p-6 bg-green-400 hover:bg-green-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-green-700 mb-4">✅</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">ABSENSI HARIAN</h3>
                <p class="text-xs text-gray-700">Input absensi cepat & mudah</p>
            </a>
            
            <a href="{{ route('sekretaris.tracker.absensi') }}" class="pixel-card p-6 bg-blue-300 hover:bg-blue-200 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-600 mb-4">📈</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">TRACKER ABSENSI</h3>
                <p class="text-xs text-gray-700">Lihat riwayat kehadiran</p>
            </a>
            
        </div>
    </div>
</div>

@endsection