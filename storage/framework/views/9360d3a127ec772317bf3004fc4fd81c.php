<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Bendahara</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 max-w-6x2">
        <a href="<?php echo e(route('bendahara.kas')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">💰 Kas</h2>
            <p class="text-gray-600">Manajemen keuangan kelas</p>
        </a>
        
        <a href="<?php echo e(route('bendahara.weekly.payments')); ?>" class="bg-white p-6 rounded-lg shadow <?php echo e(isset($isWednesday) && $isWednesday ? 'ring-4 ring-red-500 shadow-2xl animate-pulse border-4 border-red-400' : 'hover:shadow-md'); ?> transition-all block">
            <h2 class="text-lg font-semibold mb-2">📊 Pembayaran Mingguan</h2>
            <?php if(isset($isWednesday) && $isWednesday): ?>
                <p class="text-red-700 font-bold text-sm animate-pulse">🚨 HARI RABU PEMBAYARAN!</p>
                <p class="text-gray-700 font-medium"><?php echo e($currentWeekUnpaid); ?> siswa belum bayar minggu ini</p>
            <?php else: ?>
                <p class="text-gray-600">Selanjutnya: Rabu, <?php echo e($nextWednesday); ?></p>
                <p class="text-sm text-gray-500"><?php echo e($currentWeekUnpaid); ?> belum bayar minggu ini</p>
            <?php endif; ?>
        </a>

        <a href="<?php echo e(route('bendahara.laporan')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📈 Laporan Pembayaran</h2>
            <p class="text-gray-600">Laporan & cetak pembayaran mingguan</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/bendahara/dashboard.blade.php ENDPATH**/ ?>