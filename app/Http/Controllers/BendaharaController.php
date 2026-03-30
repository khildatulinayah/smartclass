<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\WeeklyPayment;
use Illuminate\Http\Request;

class BendaharaController extends Controller
{
    public function dashboard()
    {
        return view('bendahara.dashboard');
    }

    // Manajemen Kas Sederhana
    public function simpleCash()
    {
        $transactions = Transaction::with(['student', 'creator'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        
        return view('bendahara.simple-cash', compact('transactions', 'totalIncome', 'totalExpense', 'balance', 'students'));
    }

    public function storeSimpleTransaction(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    // API for payment processing
    public function getTransactions()
    {
        $transactions = Transaction::with(['student', 'creator'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalIncome = $transactions->where('type', 'income')->sum('amount');
        $totalExpense = $transactions->where('type', 'expense')->sum('amount');
        $balance = $totalIncome - $totalExpense;
        
        return response()->json([
            'transactions' => $transactions,
            'summary' => compact('totalIncome', 'totalExpense', 'balance')
        ]);
    }

    public function deleteTransaction($id)
    {
        Transaction::findOrFail($id)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Transaksi berhasil dihapus'
        ]);
    }

    // Daftar Siswa
    public function studentList()
    {
        $students = User::where('role', 'siswa')->orderBy('name')->get();
        return view('bendahara.student-list', compact('students'));
    }

    // Laporan Keuangan
    public function financialReport()
    {
        $incomes = Transaction::where('type', 'income')->orderBy('date', 'desc')->get();
        $expenses = Transaction::where('type', 'expense')->orderBy('date', 'desc')->get();
        $totalIncome = $incomes->sum('amount');
        $totalExpense = $expenses->sum('amount');
        $balance = $totalIncome - $totalExpense;

        return view('bendahara.financial_report', compact('incomes', 'expenses', 'totalIncome', 'totalExpense', 'balance'));
    }

    // Pembayaran Mingguan
    public function weeklyPayments()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        
        // Generate tagihan jika belum ada
        $this->generateMonthlyBills($currentMonth, $currentYear);
        
        $payments = WeeklyPayment::with(['student', 'transaction'])
            ->where('month', $currentMonth)
            ->where('year', $currentYear)
            ->orderBy('week_number')
            ->orderBy('student_id')
            ->get();
        
        $paymentsByStudent = $payments->groupBy('student_id');
        
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

    private function generateMonthlyBills($month, $year)
    {
        $existingCount = WeeklyPayment::where('month', $month)->where('year', $year)->count();
        if ($existingCount > 0) {
            return 0;
        }
        
        $students = User::where('role', 'siswa')->get();
        $generatedCount = 0;
        
        foreach ($students as $student) {
            for ($week = 1; $week <= 4; $week++) {
                WeeklyPayment::create([
                    'student_id' => $student->id,
                    'week_number' => $week,
                    'month' => $month,
                    'year' => $year,
                    'amount' => 5000,
                    'status' => 'unpaid',
                    'payment_date' => null,
                    'transaction_id' => null,
                    'created_by' => 1,
                ]);
                $generatedCount++;
            }
        }
        
        return $generatedCount;
    }

    public function processWeeklyPayment(Request $request)
    {
        $request->validate([
            'payment_id' => 'required|exists:weekly_payments,id',
            'transaction_id' => 'required|exists:transactions,id'
        ]);
        
        $payment = WeeklyPayment::find($request->payment_id);
        $transaction = Transaction::find($request->transaction_id);
        
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

    public function processArrears(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        try {
            $transaction = Transaction::findOrFail($request->transaction_id);
            
            // Get all unpaid payments for this student
            $unpaidPayments = WeeklyPayment::where('student_id', $request->student_id)
                                        ->where('status', 'unpaid')
                                        ->get();
            
            foreach ($unpaidPayments as $payment) {
                $payment->update([
                    'status' => 'paid',
                    'transaction_id' => $transaction->id,
                    'paid_at' => now()
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Tunggakan berhasil dilunasi!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
