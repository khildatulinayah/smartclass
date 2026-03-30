<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\WeeklyPayment;
use Illuminate\Database\Seeder;

class WeeklyPaymentSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        WeeklyPayment::query()->delete();
        
        // Ambil semua siswa
        $students = User::where('role', 'siswa')->get();
        
        // Bulan dan tahun sekarang
        $month = now()->month;
        $year = now()->year;
        
        foreach ($students as $student) {
            // Generate 4 minggu tagihan
            for ($week = 1; $week <= 4; $week++) {
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
        
        $this->command->info('Weekly payment bills generated for ' . $month . '/' . $year);
        $this->command->info('Total students: ' . $students->count());
        $this->command->info('Total bills: ' . ($students->count() * 4));
    }
}
