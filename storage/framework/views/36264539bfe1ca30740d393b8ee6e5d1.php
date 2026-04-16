
    <div class="pixel-card overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-bold pixel-font text-xs uppercase tracking-wide"><?php echo e($title); ?></h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <?php echo e($table ?? $slot); ?>

            </table>
        </div>
    </div>


<?php /**PATH C:\laragon\www\projectsc\resources\views/components/data-table.blade.php ENDPATH**/ ?>