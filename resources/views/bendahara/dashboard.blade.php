@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Bendahara</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 max-w-6x2">
        <a href="{{ route('bendahara.kas') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">💰 Kas</h2>
            <p class="text-gray-600">Manajemen keuangan kelas</p>
        </a>
        
        <a href="{{ route('bendahara.weekly.payments') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📊 Pembayaran Mingguan</h2>
            <p class="text-gray-600">Tracking pembayaran kas mingguan</p>
        </a>

        <a  class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📈 Laporan Keuangan</h2>
            <p class="text-gray-600">Laporan keuangan lengkap</p>
        </a>
    </div>
</div>
@endsection
