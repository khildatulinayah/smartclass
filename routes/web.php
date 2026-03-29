<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BendaharaController;
use App\Http\Controllers\SekretarisController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ReportController;

// Login routes
Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return redirect('/');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('email', 'password');

    if (auth()->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
})->name('login.post');

Route::post('/logout', function (Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;
        return redirect()->route($role . '.dashboard');
    });

    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/students', [AdminController::class, 'students'])->name('students');
        Route::get('/students/create', [AdminController::class, 'createStudent'])->name('students.create');
        Route::post('/students', [AdminController::class, 'storeStudent'])->name('students.store');
        Route::get('/students/{student}/edit', [AdminController::class, 'editStudent'])->name('students.edit');
        Route::put('/students/{student}', [AdminController::class, 'updateStudent'])->name('students.update');
        Route::delete('/students/{student}', [AdminController::class, 'deleteStudent'])->name('students.delete');
        
        // Reports route
        Route::get('/reports', [ReportController::class, 'attendanceReport'])->name('reports');
    });

    // Bendahara routes - CLEAN VERSION
    Route::middleware('role:bendahara')->prefix('bendahara')->name('bendahara.')->group(function () {
        Route::get('/dashboard', [BendaharaController::class, 'dashboard'])->name('dashboard');
        
        // Simple cash management (NEW SYSTEM)
        Route::get('/kas', [BendaharaController::class, 'simpleCash'])->name('kas');
        Route::post('/kas/store', [BendaharaController::class, 'storeSimpleTransaction'])->name('kas.store');
        Route::get('/api/transactions', [BendaharaController::class, 'getTransactions'])->name('api.transactions');
        Route::delete('/transactions/{id}', [BendaharaController::class, 'deleteTransaction'])->name('transactions.delete');
        
        // NEW: Tracking pembayaran mingguan
        Route::get('/weekly-payments', [BendaharaController::class, 'weeklyPayments'])->name('weekly.payments');
        Route::get('/arrears', [BendaharaController::class, 'arrearsList'])->name('arrears.list');
        Route::post('/process-payment', [BendaharaController::class, 'processWeeklyPayment'])->name('process.payment');
        
        // Financial report
        Route::get('/laporan', [BendaharaController::class, 'financialReport'])->name('laporan');
        
            });

    // Sekretaris routes - CLEAN VERSION
    Route::middleware('role:sekretaris')->prefix('sekretaris')->name('sekretaris.')->group(function () {
        Route::get('/dashboard', [SekretarisController::class, 'dashboard'])->name('dashboard');
        
        // Simple daily attendance (NEW SYSTEM)
        Route::get('/absensi', [SekretarisController::class, 'dailyAttendance'])->name('absensi');
        Route::post('/absensi/update', [SekretarisController::class, 'quickUpdateAttendance'])->name('absensi.update');
        Route::get('/api/absensi-hari-ini', [SekretarisController::class, 'getTodayAttendance'])->name('api.absensi_hari_ini');
        
            });

    // Siswa routes
    Route::middleware('role:siswa')->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/api/status-saya', [SiswaController::class, 'getMyStatus'])->name('api.status_saya');
        Route::get('/riwayat-absensi', [SiswaController::class, 'riwayatAbsensi'])->name('riwayat.absensi');
    });
});

// Public API routes for reporting
Route::middleware('auth')->prefix('api')->name('api.')->group(function () {
    Route::get('/reports/attendance', [ReportController::class, 'attendanceReport'])->name('reports.attendance');
    Route::get('/reports/cash', [ReportController::class, 'cashReport'])->name('reports.cash');
    Route::get('/reports/summary', [ReportController::class, 'summaryReport'])->name('reports.summary');
});
