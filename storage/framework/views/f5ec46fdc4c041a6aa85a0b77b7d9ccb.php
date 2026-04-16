

<?php $__env->startSection('content'); ?>
<div class="mb-8 max-w-4xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ TAMBAH SISWA ~</h2>
    
    <form method="POST" action="<?php echo e(route('admin.students.store')); ?>" class="pixel-card p-6 bg-white">
        <?php echo csrf_field(); ?>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">NAMA</label>
            <input type="text" name="name" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">EMAIL</label>
            <input type="email" name="email" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">PASSWORD</label>
            <input type="password" name="password" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-6">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">ROLE</label>
            <select name="role" class="pixel-border w-full px-3 py-2 bg-white text-xs">
                <option value="siswa">SISWA</option>
                <option value="admin">ADMIN</option>
                <option value="bendahara">BENDAHARA</option>
                <option value="sekretaris">SEKRETARIS</option>
            </select>
        </div>
        
        <div class="flex justify-between">
            <a href="<?php echo e(route('admin.students')); ?>" class="pixel-button px-6 py-2 bg-gray-400 text-black pixel-font text-xs">
                🔙 KEMBALI
            </a>
            <button type="submit" class="pixel-button px-6 py-2 bg-green-400 text-black pixel-font text-xs">
                💾 SIMPAN
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/admin/create_student.blade.php ENDPATH**/ ?>