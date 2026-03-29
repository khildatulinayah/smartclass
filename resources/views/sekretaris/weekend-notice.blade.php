@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="pixel-card p-8 bg-yellow-100 border-4 border-yellow-400 text-center">
        <div class="pixel-font text-6xl mb-4">🏖️</div>
        <h1 class="pixel-font text-3xl text-yellow-700 mb-4">HARI LIBUR!</h1>
        <p class="pixel-font text-lg text-gray-700 mb-2">
            Hari ini adalah {{ \Carbon\Carbon::parse($today)->locale('id')->format('l') }}
        </p>
        <p class="pixel-font text-md text-gray-600 mb-4">
            {{ \Carbon\Carbon::parse($today)->locale('id')->format('d F Y') }}
        </p>
        <div class="pixel-card p-4 bg-yellow-200 inline-block">
            <p class="pixel-font text-sm text-yellow-800">
                <strong>Tidak ada absensi pada hari Sabtu dan Minggu</strong><br>
                Absensi akan aktif kembali pada hari Senin
            </p>
        </div>
    </div>
</div>
