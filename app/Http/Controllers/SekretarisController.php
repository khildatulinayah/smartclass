<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SekretarisController extends Controller
{
    public function dashboard()
    {
        return view('sekretaris.dashboard');
    }

    // NEW: Improved daily attendance method
    public function dailyAttendance()
    {
        $today = Carbon::today();
        
        // Check if today is weekend (Saturday/Sunday)
        if ($today->isWeekend()) {
            return view('sekretaris.weekend-notice', compact('today'));
        }
        
        $todayFormatted = $today->format('Y-m-d');
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        // Get today's attendance or create default
        $attendances = Attendance::where('date', $todayFormatted)->get()->keyBy('student_id');
        
        // Create default attendance for students who don't have one yet
        foreach ($students as $student) {
            if (!$attendances->has($student->id)) {
                $attendance = Attendance::create([
                    'student_id' => $student->id,
                    'date' => $todayFormatted,
                    'status' => 'belum_absen', // Default status
                    'attendance_time' => null,
                    'created_by' => auth()->id()
                ]);
                $attendances->put($student->id, $attendance);
            }
        }
        
        // Check if attendance window is closed (after 08:00)
        $currentTime = Carbon::now();
        $attendanceDeadline = Carbon::today()->setTime(8, 0, 0);
        $isAttendanceClosed = $currentTime->gt($attendanceDeadline);
        
        return view('sekretaris.daily-attendance', compact('students', 'attendances', 'today', 'isAttendanceClosed', 'currentTime'));
    }

    // NEW: Improved quick update attendance status
    public function quickUpdateAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:belum_absen,hadir,sakit,izin,alpha'
        ]);

        $today = Carbon::today();
        
        // Check if today is weekend
        if ($today->isWeekend()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak bisa absen di hari libur (Sabtu/Minggu)'
            ], 403);
        }
        
        // Check if attendance window is closed
        $currentTime = Carbon::now();
        $attendanceDeadline = Carbon::today()->setTime(8, 0, 0);
        
        if ($currentTime->gt($attendanceDeadline) && $request->status === 'hadir') {
            return response()->json([
                'success' => false,
                'message' => 'Batas waktu absen hadir sudah lewat (pukul 08:00)'
            ], 403);
        }
        
        $todayFormatted = $today->format('Y-m-d');
        
        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $todayFormatted
            ],
            [
                'status' => $request->status,
                'attendance_time' => $request->status === 'hadir' ? $currentTime->format('H:i:s') : null,
                'created_by' => auth()->id()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status absensi berhasil diperbarui',
            'attendance' => $attendance
        ]);
    }

    // NEW: Get attendance data for today
    public function getTodayAttendance()
    {
        $today = Carbon::today();
        
        // Check if today is weekend
        if ($today->isWeekend()) {
            return response()->json([
                'success' => false,
                'message' => 'Hari libur - tidak ada absensi',
                'is_weekend' => true
            ]);
        }
        
        $todayFormatted = $today->format('Y-m-d');
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        $attendances = Attendance::where('date', $todayFormatted)->get()->keyBy('student_id');
        
        $data = [];
        foreach ($students as $student) {
            $attendance = $attendances->get($student->id);
            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'status' => $attendance ? $attendance->status : 'belum_absen',
                'attendance_time' => $attendance ? $attendance->attendance_time : null
            ];
        }
        
        return response()->json([
            'success' => true,
            'data' => $data,
            'is_weekend' => false,
            'current_time' => Carbon::now()->format('H:i:s'),
            'attendance_deadline' => Carbon::today()->setTime(8, 0, 0)->format('H:i:s')
        ]);
    }

    
    private function getStatusText($status)
    {
        $statusTexts = [
            'belum_absen' => 'Belum Absen',
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alpha' => 'Alpha'
        ];
        
        return $statusTexts[$status] ?? 'Unknown';
    }

    // NEW: Student list page
    public function studentList()
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        return view('sekretaris.student-list', compact('students'));
    }

    // NEW: Attendance tracker page
    public function attendanceTracker()
    {
        try {
            $currentMonth = 3; // Maret
            $currentYear = 2026;
            
            $students = User::where('role', 'siswa')->orderBy('name')->get();
            
            // Get attendance data for current month
            $attendances = Attendance::whereMonth('date', $currentMonth)
                                    ->whereYear('date', $currentYear)
                                    ->orderBy('date')
                                    ->get()
                                    ->groupBy('student_id');
            
            // Calculate statistics
            $totalDays = 22; // Total weekdays in March 2026
            $totalAttendanceRecords = $attendances->count();
            
            $totalHadir = 0;
            $totalSakit = 0;
            $totalIzin = 0;
            $totalAlpha = 0;
            $totalBelumAbsen = 0;
            
            foreach ($attendances as $studentAttendances) {
                foreach ($studentAttendances as $attendance) {
                    switch($attendance->status) {
                        case 'hadir':
                            $totalHadir++;
                            break;
                        case 'sakit':
                            $totalSakit++;
                            break;
                        case 'izin':
                            $totalIzin++;
                            break;
                        case 'alpha':
                            $totalAlpha++;
                            break;
                        case 'belum_absen':
                            $totalBelumAbsen++;
                            break;
                    }
                }
            }
            
            // Generate calendar data
            $calendarData = [];
            for ($day = 1; $day <= 31; $day++) {
                $date = Carbon::create($currentYear, $currentMonth, $day);
                $isWeekend = $date->isWeekend();
                
                $calendarData[$day] = [
                    'date' => $date,
                    'day' => $day,
                    'dayName' => $date->locale('id')->format('D'),
                    'isWeekend' => $isWeekend,
                    'attendances' => []
                ];
                
                if (!$isWeekend) {
                    $dayAttendances = Attendance::whereDate('date', $date->format('Y-m-d'))
                                                      ->with('student')
                                                      ->get();
                    $calendarData[$day]['attendances'] = $dayAttendances;
                }
            }
            
            return view('sekretaris.attendance-tracker', compact(
                'students',
                'attendances',
                'currentMonth',
                'currentYear',
                'totalDays',
                'totalAttendanceRecords',
                'totalHadir',
                'totalSakit',
                'totalIzin',
                'totalAlpha',
                'totalBelumAbsen',
                'calendarData'
            ));
            
        } catch (\Exception $e) {
            \Log::error('Attendance tracker error: ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
