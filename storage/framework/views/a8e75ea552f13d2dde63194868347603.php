<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl text-center font-bold mb-6">Dashboard Admin</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl">
        <a href="<?php echo e(route('admin.students')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">👥 Manajemen Siswa</h2>
            <p class="text-gray-600">Kelola data siswa</p>
        </a>
        
        <a href="<?php echo e(route('admin.reports')); ?>" class="bg-white p-6 rounded-lg shadow hover:shadow-md transition-shadow block">
            <h2 class="text-lg font-semibold mb-2">📊 Laporan</h2>
            <p class="text-gray-600">Lihat laporan lengkap</p>
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>