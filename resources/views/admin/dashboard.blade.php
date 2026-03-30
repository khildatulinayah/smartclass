@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-2xl">
        <a href="{{ route('admin.students') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">👥 Manajemen Siswa</h2>
            <p class="text-gray-600">Kelola data siswa</p>
        </a>
        
        <a href="{{ route('admin.reports') }}" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📊 Laporan</h2>
            <p class="text-gray-600">Lihat laporan lengkap</p>
        </a>
    </div>
</div>
@endsection
