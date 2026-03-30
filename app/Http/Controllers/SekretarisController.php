<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SekretarisController extends Controller
{
    public function dashboard()
    {
        return view('sekretaris.dashboard');
    }

    // Absensi Harian (Simple Version)
    public function simpleAttendance()
    {
        $today = now()->toDateString();
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        $attendances = Attendance::where('date', $today)->get()->keyBy('student_id');
        
        foreach ($students as $student) {
            if (!$attendances->has($student->id)) {
                $attendance = Attendance::create([
                    'student_id' => $student->id,
                    'date' => $today,
                    'status' => 'belum_absen',
                    'attendance_time' => null,
                    'created_by' => auth()->id()
                ]);
                $attendances->put($student->id, $attendance);
            }
        }
        
        return view('sekretaris.absensi', compact('students', 'attendances'));
    }

    public function batchUpdateAttendance(Request $request)
    {
        $today = now()->toDateString();
        $statuses = $request->input('status', []);
        
        foreach ($statuses as $studentId => $status) {
            $attendance = Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'date' => $today
                ],
                [
                    'status' => $status,
                    'attendance_time' => $status === 'hadir' ? now()->format('H:i:s') : null,
                    'created_by' => auth()->id()
                ]
            );
        }
        
        return redirect()->route('sekretaris.absensi')
            ->with('success', 'Absensi berhasil diperbarui!');
    }

    public function quickUpdateAttendance(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'status' => 'required|in:belum_absen,hadir,sakit,izin,alpha'
        ]);

        $today = now()->toDateString();
        
        $attendance = Attendance::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'date' => $today
            ],
            [
                'status' => $request->status,
                'attendance_time' => $request->status === 'hadir' ? now()->format('H:i:s') : null,
                'created_by' => auth()->id()
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Status absensi berhasil diperbarui',
            'attendance' => $attendance
        ]);
    }

    public function getTodayAttendance()
    {
        $today = now()->toDateString();
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        $attendances = Attendance::where('date', $today)->get()->keyBy('student_id');
        
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
            'data' => $data
        ]);
    }

    // Attendance Tracker (Simple Version)
    public function simpleTracker()
    {
        $currentMonth = request('month', now()->month);
        $currentYear = now()->year;
        
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        // Get attendance data for current month
        $attendances = Attendance::whereMonth('date', $currentMonth)
                                ->whereYear('date', $currentYear)
                                ->orderBy('date')
                                ->get()
                                ->groupBy('student_id');
        
        // Calculate statistics
        $totalHadir = 0;
        $totalSakit = 0;
        $totalIzin = 0;
        $totalAlpha = 0;
        
        foreach ($attendances as $studentAttendances) {
            foreach ($studentAttendances as $attendance) {
                switch($attendance->status) {
                    case 'hadir': $totalHadir++; break;
                    case 'sakit': $totalSakit++; break;
                    case 'izin': $totalIzin++; break;
                    case 'alpha': $totalAlpha++; break;
                }
            }
        }
        
        return view('sekretaris.tracker', compact(
            'students',
            'attendances',
            'currentMonth',
            'currentYear',
            'totalHadir',
            'totalSakit',
            'totalIzin',
            'totalAlpha'
        ));
    }

    // API untuk detail attendance siswa
    public function getStudentAttendance($studentId)
    {
        $month = request('month', now()->month);
        $year = request('year', now()->year);
        
        $attendances = Attendance::where('student_id', $studentId)
                                ->whereMonth('date', $month)
                                ->whereYear('date', $year)
                                ->orderBy('date')
                                ->get();
        
        return response()->json($attendances);
    }

    // Daftar Siswa
    public function studentList()
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        return view('sekretaris.student-list', compact('students'));
    }


    // Laporan Absensi
    public function laporanAbsensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        // 🔥 kalau belum pilih bulan → tampilkan halaman filter dulu
        if (!$bulan || !$tahun) {
            return view('sekretaris.laporan-filter');
        }

        // 🔥 kalau sudah pilih → baru generate laporan
        $students = User::where('role', 'siswa')->orderBy('name')->get();

        $attendances = Attendance::whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->get()
            ->groupBy('student_id');

        $jumlahHari = \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;

        $laporan = [];

        foreach ($students as $student) {
            $dataPerHari = [];
            $dataAbsensi = $attendances[$student->id] ?? collect();

            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal = \Carbon\Carbon::create($tahun, $bulan, $i)->toDateString();
                $absen = $dataAbsensi->firstWhere('date', $tanggal);
                $dataPerHari[$i] = $absen ? $absen->status : '-';
            }

            $total = [
                'hadir' => $dataAbsensi->where('status', 'hadir')->count(),
                'sakit' => $dataAbsensi->where('status', 'sakit')->count(),
                'izin'  => $dataAbsensi->where('status', 'izin')->count(),
                'alpha' => $dataAbsensi->where('status', 'alpha')->count(),
            ];

            $laporan[] = [
                'nama' => $student->name,
                'hari' => $dataPerHari,
                'total' => $total
            ];
        }

        return view('sekretaris.laporan', compact(
            'laporan',
            'bulan',
            'tahun',
            'jumlahHari'
        ));
    }

    public function cetakAbsensi(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $students = User::where('role', 'siswa')->orderBy('name')->get();

        $attendances = Attendance::whereMonth('date', $bulan)
            ->whereYear('date', $tahun)
            ->get()
            ->groupBy('student_id');

        $jumlahHari = \Carbon\Carbon::create($tahun, $bulan)->daysInMonth;

        $laporan = [];

        foreach ($students as $student) {
            $dataPerHari = [];
            $dataAbsensi = $attendances[$student->id] ?? collect();

            for ($i = 1; $i <= $jumlahHari; $i++) {
                $tanggal = \Carbon\Carbon::create($tahun, $bulan, $i)->toDateString();
                $absen = $dataAbsensi->firstWhere('date', $tanggal);
                $dataPerHari[$i] = $absen ? $absen->status : '-';
            }

            $total = [
                'hadir' => $dataAbsensi->where('status', 'hadir')->count(),
                'sakit' => $dataAbsensi->where('status', 'sakit')->count(),
                'izin'  => $dataAbsensi->where('status', 'izin')->count(),
                'alpha' => $dataAbsensi->where('status', 'alpha')->count(),
            ];

            $laporan[] = [
                'nama' => $student->name,
                'hari' => $dataPerHari,
                'total' => $total
            ];
        }

        $pdf = Pdf::loadView('sekretaris.laporan', compact(
            'laporan',
            'bulan',
            'tahun',
            'jumlahHari'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("laporan-absensi-$bulan-$tahun.pdf");
    }
}
