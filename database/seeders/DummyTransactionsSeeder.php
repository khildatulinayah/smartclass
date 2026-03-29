<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DummyTransactionsSeeder extends Seeder
{
    public function run()
    {
        // Hapus transaksi lama yang tidak terpakai
        Transaction::query()->delete();
        
        // Ambil siswa untuk testing
        $students = User::where('role', 'siswa')->take(10)->get();
        
        // Buat transaksi dummy untuk testing pembayaran
        foreach ($students as $index => $student) {
            // Transaksi untuk minggu 3 (19 Maret) - belum digunakan
            Transaction::create([
                'student_id' => $student->id,
                'type' => 'income',
                'amount' => 5000,
                'date' => '2026-03-19',
                'description' => "Pembayaran kas minggu ke-3 Maret 2026 - {$student->name}",
                'created_by' => 1,
            ]);
            
            // Transaksi untuk minggu 4 (26 Maret) - belum digunakan
            Transaction::create([
                'student_id' => $student->id,
                'type' => 'income',
                'amount' => 5000,
                'date' => '2026-03-26',
                'description' => "Pembayaran kas minggu ke-4 Maret 2026 - {$student->name}",
                'created_by' => 1,
            ]);
        }
        
        $this->command->info('Created 20 dummy transactions for testing payment processing');
    }
}
