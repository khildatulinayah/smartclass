<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get real-time statistics
        $totalStudents = User::where('role', 'siswa')->count();
        
        // Attendance statistics for current month
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        $attendances = Attendance::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();
            
        $totalHadir = $attendances->where('status', 'hadir')->count();
        $totalTidakHadir = $attendances->whereIn('status', ['sakit', 'izin', 'alpha'])->count();
        
        // Cash statistics for current month
        $transactions = Transaction::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->get();
            
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalHadir', 
            'totalTidakHadir', 
            'totalIncome', 
            'totalExpense', 
            'balance'
        ));
    }

    public function createStudent()
    {
        return view('admin.create_student');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
        ]);

        // Create default cash transaction for new student
        $this->createDefaultCashTransaction($user->id);

        return redirect()->route('admin.students')->with('success', 'Student created successfully');
    }

    private function createDefaultCashTransaction($studentId)
    {
        Transaction::create([
            'student_id' => $studentId,
            'type' => 'income',
            'amount' => 5000,
            'description' => 'Kas awal siswa',
            'date' => now(),
            'created_by' => auth()->id()
        ]);
    }

    public function editStudent($id)
    {
        $student = User::findOrFail($id);
        return view('admin.edit_student', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
        ]);

        if ($request->password) {
            $student->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
        } else {
            $student->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
        }

        return redirect()->route('admin.students')->with('success', 'Student updated successfully');
    }

    public function deleteStudent($id)
    {
        $student = User::findOrFail($id);
        $student->delete();
        return redirect()->route('admin.students')->with('success', 'Student deleted successfully');
    }

    public function students()
    {
        $students = User::where('role', 'siswa')->get();
        return view('admin.students', compact('students'));
    }

    public function reports(Request $request)
    {
        $type = $request->get('type', 'attendance');
        
        if ($type === 'attendance') {
            $attendances = Attendance::with('user')
                ->orderBy('date', 'desc')
                ->paginate(50);
            return view('admin.reports.attendance', compact('attendances'));
        } elseif ($type === 'financial') {
            $transactions = Transaction::with('user')
                ->orderBy('date', 'desc')
                ->paginate(50);
            return view('admin.reports.financial', compact('transactions'));
        }
        
        // Default view showing all report types
        return view('admin.reports.index');
    }
}
