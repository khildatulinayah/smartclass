@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard Sekretaris</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl">
        <a href="{{ route('sekretaris.absensi') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📝 Absensi Harian</h2>
            <p class="text-gray-600">Input absensi siswa hari ini</p>
        </a>
        
        <a href="{{ route('sekretaris.tracker') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📊 Tracker Absensi</h2>
            <p class="text-gray-600">Lihat statistik bulanan</p>
        </a>

        <a href="{{ route('sekretaris.laporan') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📈 Laporan Absensi</h2>
            <p class="text-gray-600">Laporan absensi lengkap</p>
    </div>
</div>
@endsection
