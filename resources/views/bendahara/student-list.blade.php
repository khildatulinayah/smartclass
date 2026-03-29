@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ MANAJEMEN SISWA ~</h2>
    
    <!-- Search Bar -->
    <div class="pixel-card p-4 mb-6 bg-white">
        <form method="GET" action="{{ route('bendahara.students') }}" class="flex gap-4">
            <div class="flex-1">
                <input type="text" name="search" placeholder="Cari nama siswa..." 
                       value="{{ request('search', '') }}" 
                       class="pixel-card flex-1 p-3 border-2 border-gray-300 focus:border-blue-500 focus:outline-none pixel-font text-sm">
            </div>
            <button type="submit" class="pixel-button px-4 py-2 bg-blue-500 text-white pixel-font text-sm">
                🔍 Cari
            </button>
        </form>
    </div>
    
    <!-- Student List -->
    <div class="pixel-card p-6 bg-white">
        <h3 class="pixel-font text-lg font-bold text-gray-900 mb-4 text-center">
            DAFTAR SISWA
            @if(request('search'))
                <span class="pixel-font text-sm text-gray-600">Hasil pencarian: "{{ request('search') }}"</span>
            @endif
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-xs pixel-font">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="pixel-card p-2 bg-gray-300 text-left border">No</th>
                        <th class="pixel-card p-2 bg-gray-300 text-left border">Nama</th>
                        <th class="pixel-card p-2 bg-gray-300 text-left border">Email</th>
                        <th class="pixel-card p-2 bg-gray-300 text-center border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students->keys() as $index => $student)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-2 border text-center">{{ $index + 1 }}</td>
                            <td class="p-2 border font-bold">{{ $student->name }}</td>
                            <td class="p-2 border text-xs text-gray-600">{{ $student->email }}</td>
                            <td class="p-2 border text-center">
                                <a href="{{ route('bendahara.students.edit', $student->id) }}" 
                                   class="pixel-button px-3 py-1 bg-blue-400 text-black text-xs hover:bg-blue-300">
                                    ✏️ Edit
                                </a>
                                <form method="POST" action="{{ route('bendahara.students.delete', $student->id) }}" 
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus siswa ini?')">
                                    @csrf
                                    <button type="submit" class="pixel-button px-3 py-1 bg-red-400 text-white text-xs hover:bg-red-300">
                                        �️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-4 border text-center text-gray-500">
                                Tidak ada data siswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($students->hasPages())
            <div class="flex justify-center mt-6">
                {{ $students->links() }}
            </div>
        @endif
        
        <!-- Back to Dashboard -->
        <div class="text-center mt-6">
            <a href="{{ route('bendahara.dashboard') }}" class="pixel-button px-6 py-3 bg-purple-400 text-black pixel-font text-xs">
                🔙 KEMBALI KE DASHBOARD
            </a>
        </div>
    </div>
</div>
@endsection
