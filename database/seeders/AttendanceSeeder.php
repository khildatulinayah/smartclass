<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing attendance data for March 2026
        Attendance::whereMonth('date', 3)->whereYear('date', 2026)->delete();
        
        // Get all students
        $students = User::where('role', 'siswa')->get();
        
        // Generate attendance data for March 2026
        $year = 2026;
        $month = 3; // March
        
        // Get all weekdays in March 2026
        $attendances = [];
        
        for ($day = 1; $day <= 31; $day++) {
            $date = Carbon::create($year, $month, $day);
            
            // Skip weekends (Saturday, Sunday)
            if ($date->isWeekend()) {
                continue;
            }
            
            // Generate realistic attendance patterns
            foreach ($students as $student) {
                $attendanceStatus = $this->generateAttendanceStatus($student->id, $date, $day);
                
                if ($attendanceStatus) {
                    $attendances[] = [
                        'student_id' => $student->id,
                        'date' => $date->format('Y-m-d'),
                        'status' => $attendanceStatus['status'],
                        'attendance_time' => $attendanceStatus['time'],
                        'created_by' => 1, // Admin user
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        
        // Insert all attendance data
        if (!empty($attendances)) {
            Attendance::insert($attendances);
        }
        
        $this->command->info('Attendance data for March 2026 has been seeded!');
        $this->command->info('Total attendance records: ' . count($attendances));
    }
    
    private function generateAttendanceStatus($studentId, $date, $day)
    {
        // Create realistic patterns based on student ID and day
        $studentHash = $studentId % 10;
        $dayHash = $day % 7;
        
        // Different patterns for different students
        if ($studentHash == 0) {
            // Good student - mostly hadir
            if ($dayHash == 0) return ['status' => 'sakit', 'time' => null];
            if ($dayHash == 3) return ['status' => 'izin', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((15 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 1) {
            // Average student - some absences
            if ($dayHash == 1) return ['status' => 'alpha', 'time' => null];
            if ($dayHash == 4) return ['status' => 'sakit', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((20 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 2) {
            // Often late but present
            if ($dayHash == 2) return ['status' => 'izin', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((25 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 3) {
            // Sometimes sick
            if ($dayHash == 0) return ['status' => 'sakit', 'time' => null];
            if ($dayHash == 5) return ['status' => 'sakit', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((10 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 4) {
            // Good student - always present
            return ['status' => 'hadir', 'time' => '07:' . str_pad((5 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 5) {
            // Sometimes absent
            if ($dayHash == 1) return ['status' => 'alpha', 'time' => null];
            if ($dayHash == 6) return ['status' => 'izin', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((30 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 6) {
            // Often has permission
            if ($dayHash == 2) return ['status' => 'izin', 'time' => null];
            if ($dayHash == 5) return ['status' => 'izin', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((12 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 7) {
            // Mixed pattern
            if ($dayHash == 3) return ['status' => 'alpha', 'time' => null];
            if ($dayHash == 6) return ['status' => 'sakit', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((18 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 8) {
            // Mostly present, sometimes late
            if ($dayHash == 4) return ['status' => 'izin', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((22 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        if ($studentHash == 9) {
            // Good student with occasional issues
            if ($dayHash == 1) return ['status' => 'alpha', 'time' => null];
            if ($dayHash == 5) return ['status' => 'sakit', 'time' => null];
            return ['status' => 'hadir', 'time' => '07:' . str_pad((8 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
        }
        
        // Default to hadir
        return ['status' => 'hadir', 'time' => '07:' . str_pad((15 + $studentHash), 2, '0', STR_PAD_LEFT) . ':00'];
    }
}
