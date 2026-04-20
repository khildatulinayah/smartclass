<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Siswa</h1>
    <p class="bg-white rounded-lg shadow mb-8 text-blue-600 mb-8 text-2xl font-semibold">Selamat datang, <?php echo e(auth()->user()->name); ?>!</p>

    <!-- Status Hari Ini -->
    <div class="bg-white rounded-lg shadow mb-8">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Status Hari Ini</h2>
        </div>
        <div class="p-6">
            <div class="text-center">
                <div class="text-4xl mb-2">
                    <?php if($statusHariIni == 'hadir'): ?>
                        ✅
                    <?php elseif($statusHariIni == 'sakit'): ?>
                        🤒
                    <?php elseif($statusHariIni == 'izin'): ?>
                        📝
                    <?php elseif($statusHariIni == 'alpha'): ?>
                        ❌
                    <?php else: ?>
                        ⏳
                    <?php endif; ?>
                </div>
                <div class="text-lg font-semibold mb-2">
                    <?php echo e(ucfirst($statusHariIni)); ?>

                </div>
                <div class="text-sm text-gray-600">
                    <?php echo e(\Carbon\Carbon::now()->locale('id')->format('l, d F Y')); ?>

                </div>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Absensi Bulanan -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Absensi Bulanan</h2>
                <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::now()->locale('id')->format('F Y')); ?></p>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-green-600"><?php echo e($totalHadir); ?></div>
                        <div class="text-sm text-gray-600">Hadir</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600"><?php echo e($totalSakit); ?></div>
                        <div class="text-sm text-gray-600">Sakit</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600"><?php echo e($totalIzin); ?></div>
                        <div class="text-sm text-gray-600">Izin</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600"><?php echo e($totalAlpha); ?></div>
                        <div class="text-sm text-gray-600">Alpha</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pembayaran Kas -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Pembayaran Kas</h2>
                <p class="text-sm text-gray-600"><?php echo e(\Carbon\Carbon::create($currentYear, $currentMonth)->locale('id')->format('F Y')); ?></p>
            </div>
            <div class="p-6">
                <div class="mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium">Status:</span>
                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            <?php echo e($statusKas == 'Lunas' ? 'bg-green-100 text-green-700' : 
                               ($statusKas == 'Belum Bayar' ? 'bg-red-100 text-red-700' : 
                               'bg-yellow-100 text-yellow-700')); ?>">
                            <?php echo e($statusKas); ?>

                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div class="bg-green-500 h-2 rounded-full" style="width: <?php echo e(($paidWeeks / $totalWeeks) * 100); ?>%"></div>
                    </div>
                    <div class="text-center text-sm text-gray-600 mt-1">
                        <?php echo e($paidWeeks); ?> dari <?php echo e($totalWeeks); ?> minggu
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <?php for($week = 1; $week <= 4; $week++): ?>
                        <?php
                            $payment = $weeklyPayments->where('week_number', $week)->first();
                            $isPaid = $payment && $payment->status == 'paid';
                        ?>
                        <div class="flex justify-between items-center p-3 rounded
                            <?php echo e($isPaid ? 'bg-green-50' : 'bg-red-50'); ?>">
                            <div class="flex items-center">
                                <span class="mr-3"><?php echo e($isPaid ? '✅' : '❌'); ?></span>
                                <div>
                                    <div class="font-medium text-sm">Minggu <?php echo e($week); ?></div>
                                    <div class="text-xs text-gray-600">Rp 5.000</div>
                                </div>
                            </div>
                            <div class="text-sm font-medium
                                <?php echo e($isPaid ? 'text-green-600' : 'text-red-600'); ?>">
                                <?php echo e($isPaid ? 'Lunas' : 'Belum'); ?>

                            </div>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-green-100 rounded-full p-3 mr-4">
                    <div class="text-green-600">📅</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Hari Absen</div>
                    <div class="text-xl font-bold"><?php echo e($totalDays); ?></div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 rounded-full p-3 mr-4">
                    <div class="text-blue-600">💰</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Total Kas Bulanan</div>
                    <div class="text-xl font-bold">Rp <?php echo e(number_format($totalKasBulanan, 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="bg-purple-100 rounded-full p-3 mr-4">
                    <div class="text-purple-600">📊</div>
                </div>
                <div>
                    <div class="text-sm text-gray-600">Tunggakan Kas</div>
                    <div class="text-xl font-bold text-red-600">Rp <?php echo e(number_format($kasTunggakan, 0, ',', '.')); ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/siswa/dashboard.blade.php ENDPATH**/ ?>