@extends('layouts.app')

@section('content')
<!-- Bendahara Dashboard -->
<div class="mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ BENDAHARA DASHBOARD ~</h2>
    
    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('bendahara.kas') }}" class="pixel-card p-6 bg-green-400 hover:bg-green-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-green-700 mb-4">�</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">KAS</h3>
                <p class="text-xs text-gray-700">Manajemen keuangan kelas</p>
            </a>
            
            <a href="{{ route('bendahara.weekly.payments') }}" class="pixel-card p-6 bg-blue-400 hover:bg-blue-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-700 mb-4">📊</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">PEMBAYARAN MINGGUAN</h3>
                <p class="text-xs text-gray-700">Tracking pembayaran kas mingguan</p>
            </a>
            
            <a href="{{ route('bendahara.laporan') }}" class="pixel-card p-6 bg-purple-400 hover:bg-purple-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-purple-700 mb-4">�</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN KEUANGAN</h3>
                <p class="text-xs text-gray-700">Laporan keuangan lengkap</p>
            </a>
        </div>
    </div>
</div>

@endsection