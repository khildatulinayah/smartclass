<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeeklyPayment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WeeklyPaymentSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        WeeklyPayment::query()->delete();
        
        // Ambil semua siswa
        $students = User::where('role', 'siswa')->get();
        
        // Bulan Maret 2026
        $month = 3;
        $year = 2026;
        
        // Tanggal Rabu di bulan Maret 2026: 5, 12, 19, 26
        $wednesdays = [
            1 => ['date' => '2026-03-05', 'paid' => true],  // Minggu 1 - Sudah bayar
            2 => ['date' => '2026-03-12', 'paid' => true],  // Minggu 2 - Sudah bayar  
            3 => ['date' => '2026-03-19', 'paid' => false], // Minggu 3 - Belum bayar
            4 => ['date' => '2026-03-26', 'paid' => false], // Minggu 4 - Belum bayar (masih akan datang)
        ];
        
        foreach ($students as $index => $student) {
            // Generate 4 minggu tagihan untuk Maret
            for ($week = 1; $week <= 4; $week++) {
                $weekData = $wednesdays[$week];
                $isPaid = $weekData['paid'];
                
                // Beberapa siswa sudah bayar untuk minggu 1-2
                if ($isPaid && $index < 15) { // 15 siswa pertama sudah bayar
                    // Buat transaksi pembayaran
                    $transaction = Transaction::create([
                        'student_id' => $student->id,
                        'type' => 'income',
                        'amount' => 5000,
                        'date' => $weekData['date'],
                        'description' => "Pembayaran kas minggu ke-$week Maret 2026",
                        'created_by' => 1,
                    ]);
                    
                    WeeklyPayment::create([
                        'student_id' => $student->id,
                        'week_number' => $week,
                        'month' => $month,
                        'year' => $year,
                        'amount' => 5000,
                        'status' => 'paid',
                        'payment_date' => $weekData['date'],
                        'transaction_id' => $transaction->id,
                        'created_by' => 1,
                    ]);
                } else {
                    // Siswa belum bayar
                    WeeklyPayment::create([
                        'student_id' => $student->id,
                        'week_number' => $week,
                        'month' => $month,
                        'year' => $year,
                        'amount' => 5000,
                        'status' => 'unpaid',
                        'payment_date' => null,
                        'transaction_id' => null,
                        'created_by' => 1,
                    ]);
                }
            }
        }
        
        $this->command->info('Weekly payment bills generated for Maret 2026');
        $this->command->info('15 students sudah bayar minggu 1-2, 22 students masih menunggak');
    }
}
