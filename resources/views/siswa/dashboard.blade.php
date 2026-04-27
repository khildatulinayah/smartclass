@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Siswa</h1>
    <p class="bg-white rounded-lg shadow mb-8 text-blue-600 mb-8 text-2xl font-semibold">Selamat datang, {{ auth()->user()->name }}!</p>

    <!-- Status Hari Ini -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Status Hari Ini</h2>
        </div>
        <div class="p-6">
            <div class="text-center">
                <div class="text-4xl mb-2">
                    @if($statusHariIni == 'hadir')
                        ✅
                    @elseif($statusHariIni == 'sakit')
                        🤒
                    @elseif($statusHariIni == 'izin')
                        📝
                    @elseif($statusHariIni == 'alpha')
                        ❌
                    @elseif($statusHariIni == 'libur')
                        📅
                    @else
                        ⏳
                    @endif
                </div>
                <div class="text-lg font-semibold mb-2">
                    @if($statusHariIni == 'belum_absen')
                        Belum Absen
                    @elseif($statusHariIni == 'libur')
                        Hari Libur
                    @else
                        {{ ucfirst($statusHariIni) }}
                    @endif
                </div>
                <div class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::now()->locale('id')->format('l, d F Y') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Absensi Bulanan -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Absensi Bulanan</h2>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::now()->locale('id')->format('F Y') }}</p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600">{{ $totalHadir }}</div>
                        <div class="text-sm text-gray-600">Hadir</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $totalSakit }}</div>
                        <div class="text-sm text-gray-600">Sakit</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $totalIzin }}</div>
                        <div class="text-sm text-gray-600">Izin</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $totalAlpha }}</div>
                        <div class="text-sm text-gray-600">Alpha</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran Kas -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Pembayaran Kas</h2>
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::create($currentYear, $currentMonth)->locale('id')->format('F Y') }}</p>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $statusKas == 'Lunas' ? 'bg-green-100 text-green-700' : 
                               ($statusKas == 'Belum Bayar' ? 'bg-red-100 text-red-700' : 
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ $statusKas }}
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($paidWeeks / $totalWeeks) * 100 }}%"></div>
                    </div>
                    <div class="text-center text-sm text-gray-600 mt-1">
                        {{ $paidWeeks }} dari {{ $totalWeeks }} minggu
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    @for($week = 1; $week <= 4; $week++)
                        @php
                            $payment = $weeklyPayments->where('week_number', $week)->first();
                            $isPaid = $payment && $payment->status == 'paid';
                        @endphp
                        <div class="flex justify-between items-center p-3 rounded
                            {{ $isPaid ? 'bg-green-50' : 'bg-red-50' }}">
                            <div class="flex items-center">
                                <span class="mr-3">{{ $isPaid ? '✅' : '❌' }}</span>
                                <div>
                                    <div class="font-medium text-sm">Minggu {{ $week }}</div>
                                    <div class="text-xs text-gray-600">Rp 5.000</div>
                                </div>
                            </div>
                            <div class="text-sm font-medium
                                {{ $isPaid ? 'text-green-600' : 'text-red-600' }}">
                                {{ $isPaid ? 'Lunas' : 'Belum' }}
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <div class="text-green-600">📅</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Hari Absen</div>
                    <div class="text-xl font-bold">{{ $totalDays }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <div class="text-blue-600">💰</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Kas Bulanan</div>
                    <div class="text-xl font-bold">Rp {{ number_format($totalKasBulanan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <div class="text-purple-600">📊</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Tunggakan Kas</div>
                    <div class="text-xl font-bold text-red-600">Rp {{ number_format($kasTunggakan, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
