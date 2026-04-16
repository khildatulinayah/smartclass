<div class="pixel-card p-6 rounded-lg <?php echo e($bg ?? 'bg-white'); ?> <?php echo e($shadow ?? 'shadow-2xl'); ?> <?php echo e($borderColor ?? 'border-black'); ?> hover:-translate-y-1 transition-all duration-200 <?php echo e($class ?? ''); ?>">
    <div class="flex items-start <?php echo e($iconPosition ?? 'gap-4'); ?>">
        <?php echo e($icon ?? ''); ?>

        <div class="flex-1 min-w-0">
            <?php echo e($slot); ?>

        </div>
    </div>
</div>

<?php /**PATH C:\laragon\www\projectsc\resources\views/components/pixel-card.blade.php ENDPATH**/ ?>