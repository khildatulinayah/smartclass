@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 20px; letter-spacing: 2px;">~ TRACKER RIWAYAT ABSENSI ~</h2>
    
    <!-- Statistics Section -->
    <div class="pixel-card p-4 mb-6 bg-blue-200">
        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 text-center">
            <div>
                <div class="pixel-font text-lg font-bold">{{ $students->count() }}</div>
                <div class="pixel-font text-xs">Total Siswa</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold">{{ $totalDays }}</div>
                <div class="pixel-font text-xs">Hari Efektif</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-green-700">{{ $totalHadir }}</div>
                <div class="pixel-font text-xs">Hadir</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-yellow-700">{{ $totalSakit }}</div>
                <div class="pixel-font text-xs">Sakit</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-blue-700">{{ $totalIzin }}</div>
                <div class="pixel-font text-xs">Izin</div>
            </div>
            <div>
                <div class="pixel-font text-lg font-bold text-red-700">{{ $totalAlpha }}</div>
                <div class="pixel-font text-xs">Alpha</div>
            </div>
        </div>
    </div>
    
    <!-- Month & Year Display -->
    <div class="pixel-card p-3 mb-6 bg-green-200 text-center">
        <h3 class="pixel-font text-lg font-bold text-green-800">
            Bulan {{ \Carbon\Carbon::create($currentYear, $currentMonth)->locale('id')->format('F') }} {{ $currentYear }}
        </h3>
        <p class="pixel-font text-sm text-green-600">Data Riwayat Kehadiran Bulanan</p>
    </div>
    
    <!-- Student Attendance Table -->
    <div class="pixel-card p-4 bg-white overflow-x-auto">
        <h3 class="pixel-font text-sm font-bold mb-4 text-center">DATA KEHADIRAN PER SISWA</h3>
        
        <table class="w-full text-xs pixel-font">
            <thead>
                <tr class="bg-gray-100">
                    <th class="pixel-card p-2 bg-gray-300 text-left border">Nama Siswa</th>
                    <th class="pixel-card p-2 bg-gray-300 text-center border">Total Hadir</th>
                    <th class="pixel-card p-2 bg-gray-300 text-center border">Sakit</th>
                    <th class="pixel-card p-2 bg-gray-300 text-center border">Izin</th>
                    <th class="pixel-card p-2 bg-gray-300 text-center border">Alpha</th>
                    <th class="pixel-card p-2 bg-gray-300 text-center border">Persentase</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        $studentAttendances = $attendances->get($student->id, collect());
                        $hadirCount = $studentAttendances->where('status', 'hadir')->count();
                        $sakitCount = $studentAttendances->where('status', 'sakit')->count();
                        $izinCount = $studentAttendances->where('status', 'izin')->count();
                        $alphaCount = $studentAttendances->where('status', 'alpha')->count();
                        $belumAbsenCount = $studentAttendances->where('status', 'belum_absen')->count();
                        $persentaseKehadiran = $totalDays > 0 ? round(($hadirCount / $totalDays) * 100, 1) : 0;
                    @endphp
                    
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-2 border font-bold">{{ $student->name }}</td>
                        <td class="p-2 border text-center text-green-700 font-bold">{{ $hadirCount }}</td>
                        <td class="p-2 border text-center text-yellow-700 font-bold">{{ $sakitCount }}</td>
                        <td class="p-2 border text-center text-blue-700 font-bold">{{ $izinCount }}</td>
                        <td class="p-2 border text-center text-red-700 font-bold">{{ $alphaCount }}</td>
                        <td class="p-2 border text-center">
                            <div class="pixel-card px-2 py-1 bg-blue-200 text-xs inline-block">
                                {{ $persentaseKehadiran }}%
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Back to Dashboard -->
    <div class="text-center mt-6">
        <a href="{{ route('sekretaris.dashboard') }}" class="pixel-button px-6 py-3 bg-purple-400 text-black pixel-font text-xs">
            🔙 KEMBALI KE DASHBOARD
        </a>
    </div>
</div>
@endsection
