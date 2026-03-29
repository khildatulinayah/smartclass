@extends('layouts.app')

@section('content')

<!-- Weekly Payment Tracker Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ TRACKER KAS MINGGUAN ~</h2>
    
    <!-- Payment Status Card -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div class="pixel-card p-4 {{ $statusKas == 'Lunas' ? 'bg-green-200' : ($statusKas == 'Belum Bayar' ? 'bg-red-200' : 'bg-yellow-200') }} text-center">
            <div class="pixel-font text-3xl mb-2">{{ $statusKas == 'Lunas' ? '✅' : ($statusKas == 'Belum Bayar' ? '❌' : '⚠️') }}</div>
            <p class="pixel-font text-xs text-gray-900 mb-2">STATUS KAS BULAN INI</p>
            <p class="pixel-font text-lg font-bold">{{ $statusKas }}</p>
        </div>
        <div class="pixel-card p-4 bg-purple-200 text-center">
            <div class="pixel-font text-3xl mb-2">📊</div>
            <p class="pixel-font text-xs text-gray-900 mb-2">PROGRES PEMBAYARAN</p>
            <p class="pixel-font text-lg font-bold">{{ $paidWeeks }}/{{ $totalWeeks }} Minggu</p>
            <div class="w-full bg-gray-300 rounded-full h-2 mt-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ ($paidWeeks / $totalWeeks) * 100 }}%"></div>
            </div>
        </div>
    </div>
    
    <!-- Weekly Breakdown -->
    <div class="pixel-card p-4 mb-6">
        <h3 class="pixel-font text-sm font-bold mb-4 text-center">DETAIL PEMBAYARAN MINGGUAN</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            @php
                $wednesdayDates = [
                    1 => '5 Maret 2026',
                    2 => '12 Maret 2026', 
                    3 => '19 Maret 2026',
                    4 => '26 Maret 2026'
                ];
            @endphp
            
            @for($week = 1; $week <= 4; $week++)
                @php
                    $payment = $weeklyPayments->where('week_number', $week)->first();
                    $isPaid = $payment && $payment->status == 'paid';
                @endphp
                <div class="text-center p-3 {{ $isPaid ? 'bg-green-100 border-green-400' : 'bg-red-100 border-red-400' }} border-2">
                    <div class="pixel-font text-xs">Minggu {{ $week }}</div>
                    <div class="pixel-font text-xs text-gray-600">{{ $wednesdayDates[$week] }}</div>
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
    </div>
    
    <!-- Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="pixel-card p-4 bg-green-100 text-center">
            <div class="pixel-font text-2xl text-green-600 mb-1">💰</div>
            <p class="pixel-font text-xs text-gray-900">Total Kas Bulanan</p>
            <p class="pixel-font text-lg font-bold text-green-700">Rp {{ number_format($totalKasBulanan, 0, ',', '.') }}</p>
        </div>
        <div class="pixel-card p-4 bg-blue-100 text-center">
            <div class="pixel-font text-2xl text-blue-600 mb-1">✅</div>
            <p class="pixel-font text-xs text-gray-900">Sudah Dibayar</p>
            <p class="pixel-font text-lg font-bold text-blue-700">Rp {{ number_format($kasSudahBayar, 0, ',', '.') }}</p>
        </div>
        <div class="pixel-card p-4 bg-red-100 text-center">
            <div class="pixel-font text-2xl text-red-600 mb-1">⚠️</div>
            <p class="pixel-font text-xs text-gray-900">Tunggakan</p>
            <p class="pixel-font text-lg font-bold text-red-700">Rp {{ number_format($kasTunggakan, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ STATISTIK ABSENSI ~</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="pixel-card p-4 bg-green-100 text-center">
            <div class="pixel-font text-2xl text-green-600 mb-1">✅</div>
            <p class="pixel-font text-xs text-gray-900">Hadir</p>
            <p class="pixel-font text-lg font-bold text-green-700">{{ $totalHadir }}</p>
        </div>
        <div class="pixel-card p-4 bg-yellow-100 text-center">
            <div class="pixel-font text-2xl text-yellow-600 mb-1">🤒</div>
            <p class="pixel-font text-xs text-gray-900">Sakit</p>
            <p class="pixel-font text-lg font-bold text-yellow-700">{{ $totalSakit }}</p>
        </div>
        <div class="pixel-card p-4 bg-blue-100 text-center">
            <div class="pixel-font text-2xl text-blue-600 mb-1">�</div>
            <p class="pixel-font text-xs text-gray-900">Izin</p>
            <p class="pixel-font text-lg font-bold text-blue-700">{{ $totalIzin }}</p>
        </div>
        <div class="pixel-card p-4 bg-red-100 text-center">
            <div class="pixel-font text-2xl text-red-600 mb-1">❌</div>
            <p class="pixel-font text-xs text-gray-900">Alpha</p>
            <p class="pixel-font text-lg font-bold text-red-700">{{ $totalAlpha }}</p>
        </div>
    </div>
</div>


<!-- Link ke Riwayat -->
<div class="max-w-6xl mx-auto mb-8 text-center">
    <a href="{{ route('siswa.riwayat.absensi') }}" class="pixel-button px-6 py-3 bg-purple-400 text-black pixel-font text-xs">
        📋 LIHAT RIWAYAT ABSENSI LENGKAP
    </a>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load real-time status
    loadMyStatus();
    
    function loadMyStatus() {
        fetch('{{ route("siswa.api.status_saya") }}')
            .then(response => response.json())
            .then(data => {
                updateStatusDisplay(data);
            })
            .catch(error => {
                console.error('Error loading status:', error);
            });
    }
    
    function updateStatusDisplay(data) {
        // Update attendance status
        const attendanceStatus = document.getElementById('attendance-status');
        if (attendanceStatus && data.attendances && data.attendances.length > 0) {
            const todayAttendance = data.attendances.find(a => {
                const attendanceDate = new Date(a.date);
                const today = new Date();
                return attendanceDate.toDateString() === today.toDateString();
            });
            
            if (todayAttendance) {
                const statusTexts = {
                    'hadir' => 'Hadir',
                    'sakit' => 'Sakit',
                    'izin' => 'Izin',
                    'alpha' => 'Alpha'
                };
                
                attendanceStatus.textContent = statusTexts[todayAttendance.status] || 'Hadir';
                attendanceStatus.className = `pixel-font text-lg font-bold ${
                    todayAttendance.status === 'hadir' ? 'text-green-600' : 'text-red-600'
                }`;
            }
        }
    }
    
    // Auto refresh every 30 seconds
    setInterval(loadMyStatus, 30000);
});
</script>
@endsection