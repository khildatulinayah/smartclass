<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Dashboard Bendahara</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-4xl">
        <a href="<?php echo e(route('bendahara.kas')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">💰 Kas</h2>
            <p class="text-gray-600">Manajemen keuangan kelas</p>
        </a>
        
        <a href="<?php echo e(route('bendahara.weekly.payments')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📊 Pembayaran Mingguan</h2>
            <p class="text-gray-600">Tracking pembayaran kas mingguan</p>
        </a>
        
        <a href="<?php echo e(route('bendahara.laporan')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📈 Laporan Keuangan</h2>
            <p class="text-gray-600">Laporan keuangan lengkap</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/bendahara/dashboard.blade.php ENDPATH**/ ?>