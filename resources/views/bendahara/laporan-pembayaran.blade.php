@extends('layouts.app')
<?php use Carbon\Carbon; ?>

@section('title', 'Laporan Pembayaran - Bendahara')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Laporan Pembayaran Mingguan</h1>
        <p class="text-xl text-gray-600">Pilih bulan untuk melihat dan mencetak laporan pembayaran</p>
    </div>

    <div class="bg-white shadow-2xl rounded-2xl p-8 border-8 border-gray-200">
        <form method="POST" action="{{ route('bendahara.laporan.cetak') }}" class="space-y-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Bulan</label>
                    <select name="month" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all">
                        @foreach($months as $m)
                            <option value="{{ $m }}" {{ old('month', now()->month) == $m ? 'selected' : '' }}>
                                {{ Carbon::create(now()->year, $m)->locale('id')->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tahun</label>
                    <select name="year" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ old('year', now()->year) == $y ? 'selected' : '' }}>
                                {{ $y }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="pt-8 border-t-4 border-dashed border-gray-300">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                    <!-- CETAK FORM -->
                    <div class="bg-gradient-to-br from-blue-50 to-purple-50 p-8 rounded-2xl border-4 border-blue-200">
                        <h3 class="text-2xl font-bold text-blue-800 mb-6 text-center">📄 Cetak HTML</h3>
                        <form method="POST" action="{{ route('bendahara.laporan.cetak') }}">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Bulan</label>
                                    <select name="month" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all">
                                        @foreach($months as $m)
                                            <option value="{{ $m }}" {{ old('month', now()->month) == $m ? 'selected' : '' }}>
                                                {{ Carbon::create(now()->year, $m)->locale('id')->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tahun</label>
                                    <select name="year" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200 transition-all">
                                        @foreach($years as $y)
                                            <option value="{{ $y }}" {{ old('year', now()->year) == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center pt-4">
                                    <button type="submit" class="px-10 py-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white text-xl font-bold rounded-2xl shadow-2xl hover:shadow-3xl hover:scale-105 transform transition-all duration-300 w-full">
                                        📄 CETAK LAPORAN
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    
                    <!-- PDF FORM -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-8 rounded-2xl border-4 border-green-200">
                        <h3 class="text-2xl font-bold text-green-800 mb-6 text-center">⬇️ Download PDF</h3>
                        <form method="GET" action="{{ route('bendahara.laporan.pdf') }}">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Bulan</label>
                                    <select name="month" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-200 transition-all">
                                        @foreach($months as $m)
                                            <option value="{{ $m }}" {{ old('month', now()->month) == $m ? 'selected' : '' }}>
                                                {{ Carbon::create(now()->year, $m)->locale('id')->translatedFormat('F') }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tahun</label>
                                    <select name="year" required class="w-full px-4 py-3 border-4 border-gray-300 rounded-xl text-lg font-semibold focus:outline-none focus:border-green-500 focus:ring-4 focus:ring-green-200 transition-all">
                                        @foreach($years as $y)
                                            <option value="{{ $y }}" {{ old('year', now()->year) == $y ? 'selected' : '' }}>
                                                {{ $y }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="text-center pt-4">
                                    <button type="submit" class="px-10 py-4 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-xl font-bold rounded-2xl shadow-2xl hover:shadow-3xl hover:scale-105 transform transition-all duration-300 w-full">
                                        ⬇️ DOWNLOAD PDF
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </form>

        <div class="mt-12 text-center">
            <a href="{{ route('bendahara.dashboard') }}" class="inline-block px-8 py-4 bg-gray-400 text-black font-bold text-lg rounded-xl hover:bg-gray-500 transition-all shadow-lg">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>
@endsection

