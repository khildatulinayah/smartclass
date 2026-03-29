@extends('layouts.app')

@section('content')

<!-- Status Cards Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-yellow-400 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ STATUS KAMU ~</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="pixel-card p-4 bg-green-200 text-center">
            <div class="pixel-font text-3xl mb-2">📋</div>
            <p class="pixel-font text-xs text-gray-900 mb-2">STATUS HARI INI</p>
            <p class="pixel-font text-lg font-bold" id="attendance-status">{{ $statusHariIni }}</p>
        </div>
        <div class="pixel-card p-4 bg-blue-200 text-center">
            <div class="pixel-font text-3xl mb-2">💰</div>
            <p class="pixel-font text-xs text-gray-900 mb-2">TRANSAKSI BULAN INI</p>
            <p class="pixel-font text-lg font-bold">Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}</p>
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

<!-- Transaction Summary Section -->
<div class="max-w-6xl mx-auto mb-8">
    <h2 class="pixel-font text-center text-green-600 mb-6" style="font-size: 20px; letter-spacing: 2px;">~ RINGKASAN TRANSAKSI ~</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="pixel-card p-4 bg-green-100 text-center">
            <div class="pixel-font text-2xl text-green-600 mb-1">�</div>
            <p class="pixel-font text-xs text-gray-900">Total Pemasukan</p>
            <p class="pixel-font text-lg font-bold text-green-700">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
        </div>
        <div class="pixel-card p-4 bg-red-100 text-center">
            <div class="pixel-font text-2xl text-red-600 mb-1">💸</div>
            <p class="pixel-font text-xs text-gray-900">Total Pengeluaran</p>
            <p class="pixel-font text-lg font-bold text-red-700">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</p>
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