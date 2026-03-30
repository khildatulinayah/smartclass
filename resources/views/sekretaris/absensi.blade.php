@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Absensi Harian</h1>
    <p class="text-gray-600 mb-6">{{ \Carbon\Carbon::now()->locale('id')->format('l, d F Y') }}</p>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-green-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-green-700">{{ $attendances->where('status', 'hadir')->count() }}</div>
            <div class="text-sm text-green-600">Hadir</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-yellow-700">{{ $attendances->where('status', 'sakit')->count() }}</div>
            <div class="text-sm text-yellow-600">Sakit</div>
        </div>
        <div class="bg-blue-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-blue-700">{{ $attendances->where('status', 'izin')->count() }}</div>
            <div class="text-sm text-blue-600">Izin</div>
        </div>
        <div class="bg-red-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-red-700">{{ $attendances->where('status', 'alpha')->count() }}</div>
            <div class="text-sm text-red-600">Alpha</div>
        </div>
    </div>

    <!-- Attendance Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Update Absensi</h2>
        </div>
        
        <form action="{{ route('sekretaris.absensi.update') }}" method="POST" class="p-4">
            @csrf
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-2 text-left">Nama Siswa</th>
                            <th class="px-4 py-2 text-center">Status</th>
                            <th class="px-4 py-2 text-center">Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $attendance = $attendances->get($student->id);
                                $status = $attendance ? $attendance->status : 'belum_absen';
                                $time = $attendance ? $attendance->attendance_time : '-';
                            @endphp
                            <tr class="border-b">
                                <td class="px-4 py-3 font-medium">{{ $student->name }}</td>
                                <td class="px-4 py-3">
                                    <select name="status[{{ $student->id }}]" 
                                            class="w-full px-3 py-1 border rounded
                                                   {{ $status == 'hadir' ? 'bg-green-100' : 
                                                      ($status == 'sakit' ? 'bg-yellow-100' : 
                                                      ($status == 'izin' ? 'bg-blue-100' : 
                                                      ($status == 'alpha' ? 'bg-red-100' : 'bg-gray-100'))) }}">
                                        <option value="belum_absen" {{ $status == 'belum_absen' ? 'selected' : '' }}>Belum Absen</option>
                                        <option value="hadir" {{ $status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                                        <option value="sakit" {{ $status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                                        <option value="izin" {{ $status == 'izin' ? 'selected' : '' }}>Izin</option>
                                        <option value="alpha" {{ $status == 'alpha' ? 'selected' : '' }}>Alpha</option>
                                    </select>
                                </td>
                                <td class="px-4 py-3 text-center text-sm text-gray-600">
                                    {{ $time != '-' ? \Carbon\Carbon::parse($time)->format('H:i') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Update Absensi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
