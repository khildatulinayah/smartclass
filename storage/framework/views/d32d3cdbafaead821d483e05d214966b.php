

<?php $__env->startSection('content'); ?>
<div class="mb-8 max-w-4xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ EDIT SISWA ~</h2>
    
    <form method="POST" action="<?php echo e(route('admin.students.update', $student->id)); ?>" class="pixel-card p-6 bg-white">
        <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">NAMA</label>
            <input type="text" name="name" value="<?php echo e($student->name); ?>" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">EMAIL</label>
            <input type="email" name="email" value="<?php echo e($student->email); ?>" class="pixel-border w-full px-3 py-2 bg-white text-xs" required>
        </div>
        
        <div class="mb-4">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">PASSWORD</label>
            <input type="password" name="password" class="pixel-border w-full px-3 py-2 bg-white text-xs">
        </div>
        
        <div class="mb-6">
            <label class="pixel-font text-xs text-gray-900 mb-2 block">ROLE</label>
            <select name="role" class="pixel-border w-full px-3 py-2 bg-white text-xs">
                <option value="siswa" <?php echo e($student->role == 'siswa' ? 'selected' : ''); ?>>SISWA</option>
                <option value="admin" <?php echo e($student->role == 'admin' ? 'selected' : ''); ?>>ADMIN</option>
                <option value="bendahara" <?php echo e($student->role == 'bendahara' ? 'selected' : ''); ?>>BENDAHARA</option>
                <option value="sekretaris" <?php echo e($student->role == 'sekretaris' ? 'selected' : ''); ?>>SEKRETARIS</option>
            </select>
        </div>
        
        <div class="flex justify-between">
            <a href="<?php echo e(route('admin.students')); ?>" class="pixel-button px-6 py-2 bg-gray-400 text-black pixel-font text-xs">
                🔙 KEMBALI
            </a>
            <button type="submit" class="pixel-button px-6 py-2 bg-blue-400 text-black pixel-font text-xs">
                💾 UPDATE
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/admin/edit_student.blade.php ENDPATH**/ ?>