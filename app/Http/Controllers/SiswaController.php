<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $student = auth()->user();
        
        // Get attendance history for current month
        $attendances = Attendance::where('student_id', $student->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->orderBy('date', 'desc')
            ->get();
        
        // Calculate attendance statistics
        $totalHadir = $attendances->where('status', 'hadir')->count();
        $totalSakit = $attendances->where('status', 'sakit')->count();
        $totalIzin = $attendances->where('status', 'izin')->count();
        $totalAlpha = $attendances->where('status', 'alpha')->count();
        $totalDays = $attendances->count();
        
        // Get today's attendance status
        $todayAttendance = Attendance::where('student_id', $student->id)
            ->where('date', now()->format('Y-m-d'))
            ->first();
            
        $statusHariIni = $todayAttendance ? $todayAttendance->status : 'hadir';
        
        // Get payment/transaction history for current month
        $transactions = Transaction::where('student_id', $student->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->orderBy('date', 'desc')
            ->get();
            
        $totalPemasukan = $transactions->where('type', 'income')->sum('amount');
        $totalPengeluaran = $transactions->where('type', 'expense')->sum('amount');

        return view('siswa.dashboard', compact(
            'attendances', 
            'transactions',
            'totalHadir', 
            'totalSakit', 
            'totalIzin', 
            'totalAlpha', 
            'totalDays',
            'statusHariIni',
            'totalPemasukan',
            'totalPengeluaran'
        ));
    }

    public function getMyStatus()
    {
        $student = auth()->user();
        
        // Get recent attendance data
        $attendances = Attendance::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->take(7)
            ->get()
            ->map(function ($attendance) {
                return [
                    'date' => Carbon::parse($attendance->date)->format('d M Y'),
                    'status' => $attendance->status,
                    'status_text' => $this->getStatusText($attendance->status)
                ];
            });

        // Get recent transaction data
        $transactions = Transaction::where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->take(6)
            ->get()
            ->map(function ($transaction) {
                return [
                    'date' => Carbon::parse($transaction->date)->format('d M Y'),
                    'type' => $transaction->type,
                    'type_text' => $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
                    'amount' => $transaction->amount,
                    'description' => $transaction->description
                ];
            });

        return response()->json([
            'attendances' => $attendances,
            'transactions' => $transactions,
            'total_paid' => Transaction::where('student_id', $student->id)->where('type', 'income')->sum('amount')
        ]);
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

    // Method baru untuk riwayat absensi lengkap
    public function riwayatAbsensi(Request $request)
    {
        $student = auth()->user();
        
        // Query riwayat absensi siswa yang login
        $query = Attendance::where('student_id', $student->id);
        
        // Filter berdasarkan bulan jika ada
        if ($request->has('month') && $request->has('year')) {
            $query->whereMonth('date', $request->month)
                  ->whereYear('date', $request->year);
        }
        
        // Ambil data dengan urutan terbaru
        $attendances = $query->orderBy('date', 'desc')->get();
        
        return view('siswa.riwayat-absensi', compact('attendances'));
    }
}
