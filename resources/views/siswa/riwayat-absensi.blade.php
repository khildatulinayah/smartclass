@extends('layouts.app')

@section('title', 'Riwayat Absensi')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 20px; letter-spacing: 2px;">~ RIWAYAT ABSENSI ~</h2>
    
    <!-- Filter Bulan -->
    <div class="pixel-card p-4 mb-6 bg-blue-200">
        <form method="GET" action="{{ route('siswa.riwayat.absensi') }}" class="flex gap-4 items-end">
            <div>
                <label class="pixel-font text-xs text-gray-700">Bulan:</label>
                <select name="month" class="pixel-card px-3 py-2 text-xs">
                    <option value="1">Januari</option>
                    <option value="2">Februari</option>
                    <option value="3">Maret</option>
                    <option value="4">April</option>
                    <option value="5">Mei</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">Agustus</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
            <div>
                <label class="pixel-font text-xs text-gray-700">Tahun:</label>
                <select name="year" class="pixel-card px-3 py-2 text-xs">
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                    <option value="2026" selected>2026</option>
                </select>
            </div>
            <button type="submit" class="pixel-button px-4 py-2 bg-blue-400 text-black pixel-font text-xs">
                FILTER
            </button>
            <a href="{{ route('siswa.riwayat.absensi') }}" class="pixel-button px-4 py-2 bg-gray-400 text-black pixel-font text-xs">
                RESET
            </a>
        </form>
    </div>
    
    <!-- Tabel Riwayat -->
    <div class="pixel-card p-6">
        @if($attendances->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-xs">
                    <thead>
                        <tr class="border-b-4 border-black">
                            <th class="pixel-font text-left p-2">TANGGAL</th>
                            <th class="pixel-font text-center p-2">STATUS</th>
                            <th class="pixel-font text-center p-2">KETERANGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                        <tr class="border-b-2 border-gray-300">
                            <td class="p-2 pixel-font">{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                            <td class="p-2 text-center">
                                @switch($attendance->status)
                                    @case('hadir')
                                        <span class="pixel-card px-2 py-1 bg-green-400 text-green-800 pixel-font">HADIR</span>
                                        @break
                                    @case('sakit')
                                        <span class="pixel-card px-2 py-1 bg-yellow-400 text-yellow-800 pixel-font">SAKIT</span>
                                        @break
                                    @case('izin')
                                        <span class="pixel-card px-2 py-1 bg-blue-400 text-blue-800 pixel-font">IZIN</span>
                                        @break
                                    @case('alpha')
                                        <span class="pixel-card px-2 py-1 bg-red-400 text-red-800 pixel-font">ALPHA</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="p-2 text-center pixel-font text-gray-600">
                                {{ \Carbon\Carbon::parse($attendance->date)->format('l') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Statistik -->
            <div class="mt-6 grid grid-cols-4 gap-4">
                <div class="text-center pixel-card p-3 bg-green-100">
                    <div class="pixel-font text-green-700 font-bold">{{ $attendances->where('status', 'hadir')->count() }}</div>
                    <div class="pixel-font text-xs text-gray-600">HADIR</div>
                </div>
                <div class="text-center pixel-card p-3 bg-yellow-100">
                    <div class="pixel-font text-yellow-700 font-bold">{{ $attendances->where('status', 'sakit')->count() }}</div>
                    <div class="pixel-font text-xs text-gray-600">SAKIT</div>
                </div>
                <div class="text-center pixel-card p-3 bg-blue-100">
                    <div class="pixel-font text-blue-700 font-bold">{{ $attendances->where('status', 'izin')->count() }}</div>
                    <div class="pixel-font text-xs text-gray-600">IZIN</div>
                </div>
                <div class="text-center pixel-card p-3 bg-red-100">
                    <div class="pixel-font text-red-700 font-bold">{{ $attendances->where('status', 'alpha')->count() }}</div>
                    <div class="pixel-font text-xs text-gray-600">ALPHA</div>
                </div>
            </div>
        @else
            <div class="text-center py-8">
                <p class="pixel-font text-gray-600">Belum ada data absensi</p>
            </div>
        @endif
    </div>
    
    <!-- Kembali -->
    <div class="mt-6 text-center">
        <a href="{{ route('siswa.dashboard') }}" class="pixel-button px-6 py-3 bg-gray-400 text-black pixel-font text-xs">
            ← KEMBALI KE DASHBOARD
        </a>
    </div>
</div>
@endsection
