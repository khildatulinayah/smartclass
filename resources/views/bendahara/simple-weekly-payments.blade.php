@extends('layouts.app')

@section('title', 'Pembayaran Mingguan - Sederhana')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6 text-center">PEMBAYARAN MINGGUAN</h1>
    
    <div class="bg-white shadow-lg rounded-lg border-4 border-gray-200 overflow-hidden">
        <table class="w-full table-auto">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border p-3 text-left font-bold">Siswa</th>
                    <th class="border p-3 text-left font-bold">Minggu 1</th>
                    <th class="border p-3 text-left font-bold">Minggu 2</th>
                    <th class="border p-3 text-left font-bold">Minggu 3</th>
                    <th class="border p-3 text-left font-bold">Minggu 4</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentsByStudent as $studentId => $payments)
                <tr class="hover:bg-gray-50">
                    <td class="border p-3 font-semibold">{{ $payments->first()->student->name }}</td>
                    @for($week = 1; $week <= 4; $week++)
                        @php
                            $payment = $payments->where('week_number', $week)->first();
                            $isPaid = $payment && $payment->status === 'paid';
                        @endphp
                        <td class="border p-3 text-center">
                            @if($isPaid)
                                <span class="text-green-600 font-bold">✓ PAID</span>
                            @else
                                <span class="text-red-600 font-bold">✗ Rp 5.000</span>
                                <br>
                                <button class="mt-1 bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs font-bold w-full">
                                    BAYAR SEKARANG
                                </button>
                            @endif
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div class="mt-8 text-center">
        <a href="{{ route('bendahara.dashboard') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded font-bold">
            ← Kembali Dashboard
        </a>
    </div>
</div>
@endsection