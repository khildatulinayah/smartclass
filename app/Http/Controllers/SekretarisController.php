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

    // NEW: Simple daily attendance method
    public function dailyAttendance()
    {
        $today = Carbon::today()->format('Y-m-d');
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        // Get today's attendance or create default
        $attendances = Attendance::where('date', $today)->get()->keyBy('student_id');
        
        // Create default attendance for students who don't have one yet
        foreach ($students as $student) {
            if (!$attendances->has($student->id)) {
                $attendance = Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'status' => 'hadir', // Default status
                    'created_by' => auth()->id()
                ]);
                $attendances->put($student->id, $attendance);
            }
        }
        
        return view('sekretaris.daily-attendance', compact('students', 'attendances', 'today'));
    }

    // NEW: Quick update attendance status
    public function quickUpdateAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:hadir,sakit,izin,alpha'
        ]);

        $today = Carbon::today()->format('Y-m-d');
        
        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $today
            ],
            [
                'status' => $request->status,
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
        $today = Carbon::today()->format('Y-m-d');
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        $attendances = Attendance::where('date', $today)->get()->keyBy('student_id');
        
        $data = [];
        foreach ($students as $student) {
            $attendance = $attendances->get($student->id);
            $data[] = [
                'id' => $student->id,
                'name' => $student->name,
                'status' => $attendance ? $attendance->status : 'hadir'
            ];
        }
        
        return response()->json($data);
    }

    
    private function getStatusText($status)
    {
        $statusTexts = [
            'hadir' => 'Hadir',
            'sakit' => 'Sakit',
            'izin' => 'Izin',
            'alpha' => 'Alpha'
        ];
        
        return $statusTexts[$status] ?? 'Hadir';
    }

    // NEW: Student list page
    public function studentList()
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        return view('sekretaris.student-list', compact('students'));
    }
}
