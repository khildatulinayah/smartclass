@extends('layouts.app')

@section('content')
<div class="mb-8 max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ KELOLA SISWA ~</h2>
    
    <a href="{{ route('admin.students.create') }}" class="pixel-button px-6 py-3 bg-green-400 text-black pixel-font text-xs inline-block mb-6">+ TAMBAH SISWA</a>
    
    <div class="pixel-card p-4 bg-purple-100 overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr>
                    <th class="pixel-card px-3 py-2 bg-purple-300 text-left text-xs pixel-font">NAMA</th>
                    <th class="pixel-card px-3 py-2 bg-purple-300 text-left text-xs pixel-font">NIS</th>
                    <th class="pixel-card px-3 py-2 bg-purple-300 text-left text-xs pixel-font">KELAS</th>
                    <th class="pixel-card px-3 py-2 bg-purple-300 text-center text-xs pixel-font">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td class="pixel-card px-3 py-2 bg-white text-xs font-bold">{{ $student->name }}</td>
                    <td class="pixel-card px-3 py-2 bg-white text-xs">{{ $student->nis }}</td>
                    <td class="pixel-card px-3 py-2 bg-white text-xs">{{ $student->class }}</td>
                    <td class="pixel-card px-3 py-2 bg-white text-center text-xs">
                        <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-600 font-bold hover:underline">EDIT</a>
                        <form method="POST" action="{{ route('admin.students.delete', $student) }}" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 font-bold hover:underline ml-2">HAPUS</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection