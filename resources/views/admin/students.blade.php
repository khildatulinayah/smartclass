@extends('layouts.app')

@section('content')
<div class="mb-8 max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ KELOLA SISWA ~</h2>
    
    <a href="{{ route('admin.students.create') }}" class="pixel-button px-6 py-3 bg-green-400 text-black pixel-font text-xs inline-block mb-6">+ TAMBAH SISWA</a>
    
    <div class="pixel-card p-4 bg-purple-100 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="pixel-card px-4 py-3 bg-purple-300 text-left text-xs pixel-font">NAMA</th>
                    <th class="pixel-card px-4 py-3 bg-purple-300 text-left text-xs pixel-font">EMAIL</th>
                    <th class="pixel-card px-4 py-3 bg-purple-300 text-left text-xs pixel-font">ROLE</th>
                    <th class="pixel-card px-4 py-3 bg-purple-300 text-center text-xs pixel-font">STATUS</th>
                    <th class="pixel-card px-4 py-3 bg-purple-300 text-center text-xs pixel-font">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr class="hover:bg-purple-50 transition-colors">
                        <td class="pixel-card px-4 py-3 bg-white text-sm font-bold">{{ $student->name }}</td>
                        <td class="pixel-card px-4 py-3 bg-white text-xs">{{ $student->email }}</td>
                        <td class="pixel-card px-4 py-3 bg-white text-xs">
                            <span class="pixel-card px-2 py-1 bg-blue-200 text-blue-700 text-xs">
                                {{ $student->role }}
                            </span>
                        </td>
                        <td class="pixel-card px-4 py-3 bg-white text-center text-xs">
                            <span class="pixel-card px-2 py-1 bg-green-200 text-green-700 text-xs">
                                ✓ AKTIF
                            </span>
                        </td>
                        <td class="pixel-card px-4 py-3 bg-white text-center text-xs">
                            <a href="{{ route('admin.students.edit', $student->id) }}" 
                               class="pixel-button px-3 py-1 bg-blue-400 text-black text-xs hover:bg-blue-300 mr-1">
                                ✏️ EDIT
                            </a>
                            <form method="POST" action="{{ route('admin.students.delete', $student->id) }}" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="pixel-button px-3 py-1 bg-red-400 text-white text-xs hover:bg-red-300">
                                    🗑️ HAPUS
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <!-- Back to Dashboard -->
    <div class="text-center mt-6">
        <a href="{{ route('admin.dashboard') }}" class="pixel-button px-6 py-3 bg-purple-400 text-black pixel-font text-xs">
            🔙 KEMBALI KE DASHBOARD
        </a>
    </div>
</div>
@endsection