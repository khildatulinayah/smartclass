<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Attendance;
use App\Models\Transaction;
use App\Models\WeeklyPayment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BendaharaController extends Controller
{
    public function dashboard()
    {
        return view('bendahara.dashboard');
    }

    // NEW: Simple cash management methods
    public function simpleCash()
    {
        $today = now();
        $month = $today->month;
        $year = $today->year;
        
        // Get all transactions for current month
        $transactions = Transaction::with(['student', 'creator'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate summary
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        // Get students for dropdown
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        return view('bendahara.simple-cash', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'students'));
    }

    public function storeSimpleTransaction(Request $request)
    {
        $request->validate([
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'description' => 'required|string|max:255',
            'date' => 'required|date',
            'student_id' => 'nullable|exists:users,id'
        ]);

        $transaction = Transaction::create([
            'student_id' => $request->student_id,
            'type' => $request->type,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
            'created_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil ditambahkan',
            'transaction' => $transaction->load(['student', 'creator'])
        ]);
    }

    public function getTransactions()
    {
        $today = now();
        $month = $today->month;
        $year = $today->year;
        
        $transactions = Transaction::with(['student', 'creator'])
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate summary
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        return response()->json([
            'transactions' => $transactions,
            'summary' => [
                'totalIncome' => $totalIncome,
                'totalExpense' => $totalExpense,
                'balance' => $balance
            ]
        ]);
    }

    public function deleteTransaction($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }

    // NEW: API to get all students
    public function getStudents()
    {
        $students = User::where('role', 'siswa')
            ->orderBy('name')
            ->get()
            ->map(function ($student) {
                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'email' => $student->email
                ];
            });

        return response()->json($students);
    }

    // NEW: Student list page
    public function studentList()
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        return view('bendahara.student-list', compact('students'));
    }

    
    public function financialReport()
    {
        $incomes = Transaction::where('type', 'income')->orderBy('date', 'desc')->get();
        $expenses = Transaction::where('type', 'expense')->orderBy('date', 'desc')->get();
        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('bendahara.financial_report', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'balance'));
    }

    // NEW: Tracking pembayaran mingguan
    public function weeklyPayments()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Generate tagihan untuk semua siswa jika belum ada
        $this->generateMonthlyBills($currentMonth, $currentYear);
        
        // Ambil semua pembayaran mingguan bulan ini
        $payments = WeeklyPayment::with(['student', 'transaction'])
                                ->where('month', $currentMonth)
                                ->where('year', $currentYear)
                                ->orderBy('week_number')
                                ->orderBy('student_id')
                                ->get();
        
        // Group by student
        $paymentsByStudent = $payments->groupBy('student_id');
        
        // Hitung statistik
        $totalStudents = User::where('role', 'siswa')->count();
        $totalBills = $payments->count();
        $paidBills = $payments->where('status', 'paid')->count();
        $unpaidBills = $payments->where('status', 'unpaid')->count();
        $totalAmount = $payments->sum('amount');
        $paidAmount = $payments->where('status', 'paid')->sum('amount');
        $unpaidAmount = $payments->where('status', 'unpaid')->sum('amount');
        
        return view('bendahara.weekly-payments', compact(
            'paymentsByStudent',
            'totalStudents',
            'totalBills',
            'paidBills',
            'unpaidBills',
            'totalAmount',
            'paidAmount',
            'unpaidAmount'
        ));
    }

    // Helper: generate tagihan bulanan
    private function generateMonthlyBills($month, $year)
    {
        $students = User::where('role', 'siswa')->get();
        $generatedCount = 0;
        
        foreach ($students as $student) {
            $generatedCount += WeeklyPayment::generateWeeklyBills($student->id, $month, $year);
        }
        
        return $generatedCount;
    }

    // NEW: Proses pembayaran mingguan
    public function processWeeklyPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:weekly_payments,id',
            'transaction_id' => 'required|exists:transactions,id'
        ]);
        
        $payment = WeeklyPayment::find($request->payment_id);
        $transaction = Transaction::find($request->transaction_id);
        
        // Update status pembayaran
        $payment->update([
            'status' => 'paid',
            'payment_date' => $transaction->date,
            'transaction_id' => $transaction->id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dicatat'
        ]);
    }

    // NEW: Daftar siswa yang menunggak
    public function arrearsList()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Generate tagihan jika belum ada
        $this->generateMonthlyBills($currentMonth, $currentYear);
        
        // Ambil siswa yang menunggak
        $studentsWithArrears = User::where('role', 'siswa')
                                   ->whereHas('weeklyPayments', function ($query) use ($currentMonth, $currentYear) {
                                       $query->where('month', $currentMonth)
                                             ->where('year', $currentYear)
                                             ->where('status', 'unpaid');
                                   })
                                   ->with(['weeklyPayments' => function ($query) use ($currentMonth, $currentYear) {
                                       $query->where('month', $currentMonth)
                                             ->where('year', $currentYear)
                                             ->where('status', 'unpaid');
                                   }])
                                   ->get();
        
        // Hitung total tunggakan per siswa
        $arrearsData = $studentsWithArrears->map(function ($student) {
            $totalArrears = $student->weeklyPayments->sum('amount');
            $unpaidCount = $student->weeklyPayments->count();
            
            return [
                'student' => $student,
                'total_arrears' => $totalArrears,
                'unpaid_count' => $unpaidCount,
                'unpaid_weeks' => $student->weeklyPayments->pluck('week_number')
            ];
        });
        
        $totalArrears = $arrearsData->sum('total_arrears');
        
        return view('bendahara.arrears-list', compact(
            'arrearsData',
            'totalArrears'
        ));
    }
}
