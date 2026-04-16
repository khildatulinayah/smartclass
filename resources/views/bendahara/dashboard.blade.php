@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Bendahara</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 max-w-6x2">
        <a href="{{ route('bendahara.kas') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">💰 Kas</h2>
            <p class="text-gray-600">Manajemen keuangan kelas</p>
        </a>
        
        <a href="{{ route('bendahara.weekly.payments') }}" class="bg-white p-6 rounded-lg shadow {{ isset($isWednesday) && $isWednesday ? 'ring-4 ring-red-500 shadow-2xl animate-pulse border-4 border-red-400' : 'hover:shadow-md' }} transition-all block">
            <h2 class="text-lg font-semibold mb-2">📊 Pembayaran Mingguan</h2>
            @if(isset($isWednesday) && $isWednesday)
                <p class="text-red-700 font-bold text-sm animate-pulse">🚨 HARI RABU PEMBAYARAN!</p>
                <p class="text-gray-700 font-medium">{{ $currentWeekUnpaid }} siswa belum bayar minggu ini</p>
            @else
                <p class="text-gray-600">Selanjutnya: Rabu, {{ $nextWednesday }}</p>
                <p class="text-sm text-gray-500">{{ $currentWeekUnpaid }} belum bayar minggu ini</p>
            @endif
        </a>

        <a href="#" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📈 Laporan Keuangan</h2>
            <p class="text-gray-600">Laporan keuangan lengkap</p>
        </a>
    </div>
</div>
@endsection

