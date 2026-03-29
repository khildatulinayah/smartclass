@extends('layouts.app')

@section('content')

<!-- Struktur Kepengurusan Kelas Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ STRUKTUR KEPENGURUSAN ~</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
        <div class="pixel-card p-3 bg-red-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">KETUA</p>
            <p class="pixel-font text-xs font-bold text-red-700">Harry James Potter</p>
        </div>
        <div class="pixel-card p-3 bg-blue-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">WAKIL</p>
            <p class="pixel-font text-xs font-bold text-blue-700">Hermione Jean Granger</p>
        </div>
        <div class="pixel-card p-3 bg-green-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">SEKRETARIS</p>
            <p class="pixel-font text-xs font-bold text-green-700">Padma Patil, Parvati Patil</p>
        </div>
        <div class="pixel-card p-3 bg-yellow-300 text-center">
            <div class="pixel-font text-2xl mb-2">�</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">BENDAHARA</p>
            <p class="pixel-font text-xs font-bold text-yellow-700">Ronald Bilius Weasley, Neville Longbottom</p>
        </div>
        <div class="pixel-card p-3 bg-pink-300 text-center">
            <div class="pixel-font text-2xl mb-2">👤</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">WALI KELAS</p>
            <p class="pixel-font text-xs font-bold text-pink-700">Minerva McGonagall</p>
        </div>
        <div class="pixel-card p-3 bg-indigo-300 text-center">
            <div class="pixel-font text-2xl mb-2">⭐</div>
            <p class="pixel-font text-xs text-gray-900 mb-1">SPECIAL</p>
            <p class="pixel-font text-xs font-bold text-indigo-700">11 pplg</p>
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
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Dean Thomas</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Seamus Finnigan</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Lavender Brown</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Colin Creevey</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Dennis Creevey</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Justin Finch-Fletchley</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Hannah Abbott</p>
                </div>
            </div>
            <!-- Selasa -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-yellow-500 text-white text-xs pixel-font font-bold mb-2">SELASA</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Draco Malfoy</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Blaise Zabini</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Pansy Parkinson</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Millicent Bulstrode</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Gregory Goyle</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Vincent Crabbe</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Theodore Nott</p>
                </div>
            </div>
            <!-- Rabu -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-green-600 text-white text-xs pixel-font font-bold mb-2">RABU</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Cedric Diggory</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Cho Chang</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Terry Boot</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Michael Corner</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Anthony Goldstein</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Marietta Edgecombe</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Zacharias Smith</p>
                </div>
            </div>
            <!-- Kamis -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-yellow-500 text-white text-xs pixel-font font-bold mb-2">KAMIS</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Fred Weasley</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">George Weasley</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Lee Jordan</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Angelina Johnson</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Alicia Spinnet</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Katie Bell</p>
                    <p class="pixel-card px-2 py-1 bg-yellow-100 text-xs">Oliver Wood</p>
                </div>
            </div>
            <!-- Jumat -->
            <div class="text-center">
                <h3 class="pixel-card px-2 py-1 bg-green-600 text-white text-xs pixel-font font-bold mb-2">JUMAT</h3>
                <div class="space-y-1">
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Romilda Vane</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Demelza Robins</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Tracey Davis</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Ernest Macmillan</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Susan Bones</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Padma Patil</p>
                    <p class="pixel-card px-2 py-1 bg-white text-xs">Parvati Patil</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ BENDAHARA DASHBOARD ~</h2>
    
    <!-- Menu Grid -->
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Kas Digital Baru -->
            <a href="{{ route('bendahara.kas') }}" class="pixel-card p-6 bg-blue-400 hover:bg-blue-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-blue-700 mb-4">💳</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">KAS DIGITAL</h3>
                <p class="text-xs text-gray-700">Manajemen kas modern</p>
            </a>
            
            <!-- Tracking Pembayaran Mingguan -->
            <a href="{{ route('bendahara.weekly.payments') }}" class="pixel-card p-6 bg-purple-400 hover:bg-purple-300 text-center block transform hover:scale-105 transition-all">
                <div class="pixel-font text-4xl text-purple-700 mb-4">�</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">TRACKING PEMBAYARAN</h3>
                <p class="text-xs text-gray-700">Pembayaran mingguan siswa</p>
            </a>
            
            <!-- Laporan Keuangan -->
            <a href="{{ route('bendahara.laporan') }}" class="pixel-card p-6 bg-green-300 hover:bg-green-200 text-center">
                <div class="pixel-font text-4xl text-green-600 mb-4">📊</div>
                <h3 class="pixel-font text-sm text-gray-900 mb-2">LAPORAN KEUANGAN</h3>
                <p class="text-xs text-gray-700">Laporan finansial bulanan</p>
            </a>
        </div>
    </div>
</div>

@endsection