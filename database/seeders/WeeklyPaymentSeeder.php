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
        
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        foreach ($students as $student) {
            // Generate 4 minggu tagihan untuk bulan ini
            for ($week = 1; $week <= 4; $week++) {
                WeeklyPayment::create([
                    'student_id' => $student->id,
                    'week_number' => $week,
                    'month' => $currentMonth,
                    'year' => $currentYear,
                    'amount' => 5000, // Rp 5.000 per minggu
                    'status' => 'unpaid', // Default belum bayar
                    'payment_date' => null,
                    'transaction_id' => null,
                    'created_by' => 1, // Admin user
                ]);
            }
        }
        
        $this->command->info('Weekly payment bills generated for ' . $students->count() . ' students');
    }
}
