<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\CashPayment;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function attendanceReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        $students = User::where('role', 'siswa')->get();
        $attendances = Attendance::whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->groupBy('student_id');
        
        $reportData = [];
        foreach ($students as $student) {
            $studentAttendances = $attendances->get($student->id, collect());
            
            $reportData[] = [
                'student' => $student,
                'total_days' => $studentAttendances->count(),
                'hadir' => $studentAttendances->where('status', 'hadir')->count(),
                'sakit' => $studentAttendances->where('status', 'sakit')->count(),
                'izin' => $studentAttendances->where('status', 'izin')->count(),
                'tidak' => $studentAttendances->where('status', 'tidak')->count(),
                'percentage' => $studentAttendances->count() > 0 
                    ? round(($studentAttendances->where('status', 'hadir')->count() / $studentAttendances->count()) * 100, 2)
                    : 0
            ];
        }
        
        return response()->json($reportData);
    }

    public function cashReport(Request $request)
    {
        $month = $request->get('month', Carbon::now()->month);
        $year = $request->get('year', Carbon::now()->year);
        
        $students = User::where('role', 'siswa')->get();
        $payments = CashPayment::where('month', $month)
            ->where('year', $year)
            ->get()
            ->keyBy('student_id');
        
        $reportData = [];
        foreach ($students as $student) {
            $payment = $payments->get($student->id);
            
            $reportData[] = [
                'student' => $student,
                'status' => $payment ? $payment->status : 'unpaid',
                'amount' => $payment ? $payment->amount : 0,
                'paid_at' => $payment ? $payment->created_at->format('d M Y') : '-'
            ];
        }
        
        return response()->json($reportData);
    }

    public function summaryReport()
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        
        // Attendance Summary
        $totalAttendances = Attendance::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
        
        $attendanceStats = [
            'hadir' => Attendance::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'hadir')
                ->count(),
            'sakit' => Attendance::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'sakit')
                ->count(),
            'izin' => Attendance::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'izin')
                ->count(),
            'tidak' => Attendance::whereMonth('date', $currentMonth)
                ->whereYear('date', $currentYear)
                ->where('status', 'tidak')
                ->count(),
        ];
        
        // Cash Summary
        $cashStats = [
            'total_students' => User::where('role', 'siswa')->count(),
            'paid_students' => CashPayment::where('month', $currentMonth)
                ->where('year', $currentYear)
                ->where('status', 'paid')
                ->count(),
            'total_amount' => CashPayment::where('month', $currentMonth)
                ->where('year', $currentYear)
                ->where('status', 'paid')
                ->sum('amount'),
            'expected_amount' => User::where('role', 'siswa')->count() * 5000
        ];
        
        return response()->json([
            'attendance' => [
                'stats' => $attendanceStats,
                'total' => $totalAttendances,
                'percentage' => $totalAttendances > 0 
                    ? round(($attendanceStats['hadir'] / $totalAttendances) * 100, 2)
                    : 0
            ],
            'cash' => [
                'stats' => $cashStats,
                'collection_rate' => $cashStats['total_students'] > 0 
                    ? round(($cashStats['paid_students'] / $cashStats['total_students']) * 100, 2)
                    : 0
            ]
        ]);
    }
}
