@extends('layouts.app')

@section('title', 'Daftar Tunggakan')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-red-400 mb-8" style="font-size: 20px; letter-spacing: 2px;">~ DAFTAR SISWA MENUNGGAK ~</h2>
    
    <!-- Total Tunggakan -->
    <div class="pixel-card p-4 mb-6 bg-red-200 text-center">
        <div class="pixel-font text-2xl font-bold text-red-700">
            Rp {{ number_format($totalArrears, 0, ',', '.') }}
        </div>
        <div class="pixel-font text-xs">TOTAL TUNGGAKAN BULAN INI</div>
    </div>
    
    <!-- Daftar Siswa Menunggak -->
    @if($arrearsData->count() > 0)
        <div class="pixel-card p-6">
            @foreach($arrearsData as $data)
                <div class="mb-4 p-4 border-4 border-black bg-red-50">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="pixel-font text-sm font-bold">{{ $data['student']->name }}</h3>
                            <p class="pixel-font text-xs text-gray-600">
                                Menunggak {{ $data['unpaid_count'] }} minggu: 
                                Minggu {{ implode(', ', $data['unpaid_weeks']->toArray()) }}
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="pixel-font text-lg font-bold text-red-700">
                                Rp {{ number_format($data['total_arrears'], 0, ',', '.') }}
                            </div>
                            <div class="pixel-font text-xs">Total Tunggakan</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="pixel-card p-8 text-center bg-green-100">
            <div class="pixel-font text-lg text-green-700 mb-2">✓ SEMUA SISWA SUDAH LUNAS!</div>
            <div class="pixel-font text-xs text-gray-600">Tidak ada tunggakan bulan ini</div>
        </div>
    @endif
    
    <!-- Link Kembali -->
    <div class="text-center mt-6">
        <a href="{{ route('bendahara.weekly.payments') }}" class="pixel-button px-6 py-3 bg-blue-400 text-black pixel-font text-xs">
            ← KEMBALI KE TRACKING
        </a>
        <a href="{{ route('bendahara.dashboard') }}" class="pixel-button px-6 py-3 bg-gray-400 text-black pixel-font text-xs ml-4">
            🏠 DASHBOARD
        </a>
    </div>
</div>
@endsection
