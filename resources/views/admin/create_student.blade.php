@extends('layouts.app')

@section('content')
<div class="mb-8 max-w-4xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ TAMBAH SISWA ~</h2>
    
    <form method="POST" action="{{ route('admin.students.store') }}" class="pixel-card p-6 bg-white">
        @csrf
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">NAMA</label>
            <input type="text" name="name" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">EMAIL</label>
            <input type="email" name="email" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">NIS</label>
            <input type="text" name="nis" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-6">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">KELAS</label>
            <input type="text" name="class" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <button type="submit" class="pixel-button px-6 py-2 bg-green-400 text-black pixel-font text-xs">SIMPAN</button>
    </form>
</div>
@endsection