@extends('layouts.app')

@section('title', 'Tracking Pembayaran Mingguan')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 20px; letter-spacing: 2px;">~ TRACKING PEMBAYARAN MINGGUAN ~</h2>
    
    <!-- Statistik -->
    <div class="pixel-card p-4 mb-6 bg-blue-200">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-4 text-center">
            <div>
                <div class="pixel-font text-lg font-bold">{{ $totalStudents }}</div>
                <div class="pixel-font text-xs">Total Siswa</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold">{{ $totalBills }}</div>
                <div class="pixel-font text-xs">Total Tagihan</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-green-700">{{ $paidBills }}</div>
                <div class="pixel-font text-xs">Sudah Bayar</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-red-700">{{ $unpaidBills }}</div>
                <div class="pixel-font text-xs">Belum Bayar</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold">Rp {{ number_format($paidAmount, 0, ',', '.') }}</div>
                <div class="pixel-font text-xs">Kas Masuk</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold">Rp {{ number_format($unpaidAmount, 0, ',', '.') }}</div>
                <div class="pixel-font text-xs">Tunggakan</div>
            </div>
        </div>
    </div>
    
    <!-- Daftar Pembayaran per Siswa -->
    <div class="pixel-card p-6">
        @foreach($paymentsByStudent as $studentId => $payments)
            <div class="mb-6 p-4 border-4 border-black bg-gray-50">
                <h3 class="pixel-font text-sm mb-3">{{ $payments->first()->student->name }}</h3>
                
                <div class="grid grid-cols-4 gap-2">
                    @for($week = 1; $week <= 4; $week++)
                        <?php 
                        $payment = $payments->where('week_number', $week)->first();
                        $isPaid = $payment && $payment->status === 'paid';
                        ?>
                        <div class="text-center p-2 {{ $isPaid ? 'bg-green-100 border-green-400' : 'bg-red-100 border-red-400' }} border-2">
                            <div class="pixel-font text-xs">Minggu {{ $week }}</div>
                            <div class="pixel-font text-xs font-bold mt-1">
                                @if($isPaid)
                                    <span class="text-green-700">✓ Rp 5.000</span>
                                @else
                                    <span class="text-red-700">✗ Rp 5.000</span>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
                
                <!-- Total per siswa -->
                <div class="mt-3 text-right">
                    <span class="pixel-font text-xs">
                        Total: <span class="font-bold">Rp {{ number_format($payments->sum('amount'), 0, ',', '.') }}</span>
                        | Lunas: <span class="font-bold text-green-700">{{ $payments->where('status', 'paid')->count() }}/4</span>
                    </span>
                </div>
            </div>
        @endforeach
    </div>
    
    <!-- Link ke daftar tunggakan -->
    <div class="text-center mt-6">
        <a href="{{ route('bendahara.arrears.list') }}" class="pixel-button px-6 py-3 bg-red-400 text-black pixel-font text-xs">
            🚨 LIHAT DAFTAR TUNGGAKAN
        </a>
        <a href="{{ route('bendahara.dashboard') }}" class="pixel-button px-6 py-3 bg-gray-400 text-black pixel-font text-xs ml-4">
            ← KEMBALI
        </a>
    </div>
</div>
@endsection
