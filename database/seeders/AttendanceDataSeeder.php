<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendanceDataSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        Attendance::query()->delete();
        
        // Ambil semua siswa
        $students = User::where('role', 'siswa')->get();
        
        // Generate data untuk 3 bulan: Januari, Februari, Maret 2026
        $months = [1, 2, 3]; // Jan, Feb, Mar
        $year = 2026;
        
        foreach ($months as $month) {
            // Get total days in month
            $totalDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            
            foreach ($students as $student) {
                for ($day = 1; $day <= $totalDays; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
                    $carbonDate = \Carbon\Carbon::parse($date);
                    
                    // Skip weekends
                    if ($carbonDate->isWeekend()) {
                        continue;
                    }
                    
                    // Random status dengan probabilitas yang realistis
                    $rand = mt_rand(1, 100);
                    $status = 'hadir';
                    $attendanceTime = null;
                    
                    if ($rand <= 75) {
                        // 75% hadir
                        $status = 'hadir';
                        // Random jam kedatangan antara 07:00 - 08:30
                        $hour = mt_rand(7, 8);
                        $minute = ($hour == 7) ? mt_rand(0, 59) : mt_rand(0, 30);
                        $attendanceTime = sprintf('%02d:%02d:%02d', $hour, $minute, mt_rand(0, 59));
                    } elseif ($rand <= 85) {
                        // 10% sakit
                        $status = 'sakit';
                    } elseif ($rand <= 93) {
                        // 8% izin
                        $status = 'izin';
                    } elseif ($rand <= 98) {
                        // 5% alpha
                        $status = 'alpha';
                    } else {
                        // 2% belum absen (untuk hari-hari terakhir)
                        $status = 'belum_absen';
                    }
                    
                    Attendance::create([
                        'student_id' => $student->id,
                        'date' => $date,
                        'status' => $status,
                        'attendance_time' => $attendanceTime,
                        'created_by' => 1 // Admin
                    ]);
                }
            }
        }
        
        $this->command->info('Data absensi palsu untuk Januari, Februari, Maret 2026 berhasil dibuat!');
        $this->command->info('Total siswa: ' . $students->count());
        $this->command->info('Total records: ' . Attendance::count());
    }
}
