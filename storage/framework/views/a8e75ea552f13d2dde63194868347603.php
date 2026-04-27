<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ DASHBOARD ADMIN ~</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">
        <a href="<?php echo e(route('admin.students')); ?>" class="pixel-card p-6 bg-white hover:bg-blue-50 transition-colors block">
            <h2 class="pixel-font text-sm mb-2 text-blue-700">👥 MANAJEMEN SISWA</h2>
            <p class="text-gray-600 text-xs">Kelola data siswa aktif</p>
        </a>
        
        <a href="<?php echo e(route('admin.reports')); ?>" class="pixel-card p-6 bg-white hover:bg-green-50 transition-colors block">
            <h2 class="pixel-font text-sm mb-2 text-green-700">📊 LAPORAN</h2>
            <p class="text-gray-600 text-xs">Lihat laporan lengkap</p>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>