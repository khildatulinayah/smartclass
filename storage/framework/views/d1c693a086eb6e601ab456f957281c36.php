

<?php $__env->startSection('content'); ?>
<div class="mb-8 max-w-6xl mx-auto">
    <h2 class="pixel-font text-center text-yellow-400 mb-8" style="font-size: 24px; letter-spacing: 2px;">~ LAPORAN KEUANGAN ~</h2>

    <?php if(session('success')): ?>
        <div class="pixel-card p-3 bg-green-200 text-green-800 mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="pixel-card p-4 bg-white shadow mb-8">
        <h3 class="pixel-font text-blue-600 text-sm mb-4">TAMBAH TRANSAKSI</h3>
        <form action="<?php echo e(route('bendahara.kas.store')); ?>" method="POST" class="grid gap-4 md:grid-cols-2">
            <?php echo csrf_field(); ?>
            <div>
                <label class="pixel-font text-xs text-gray-700">Jenis</label>
                <select name="type" class="pixel-card w-full p-3 border-2 border-gray-300" required>
                    <option value="income" <?php echo e(old('type') == 'income' ? 'selected' : ''); ?>>Pemasukan</option>
                    <option value="expense" <?php echo e(old('type') == 'expense' ? 'selected' : ''); ?>>Pengeluaran</option>
                </select>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="pixel-font text-xs text-gray-700">Tanggal</label>
                <input type="date" name="date" value="<?php echo e(old('date', now()->format('Y-m-d'))); ?>" class="pixel-card w-full p-3 border-2 border-gray-300" required>
                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="pixel-font text-xs text-gray-700">Jumlah (Rp)</label>
                <input type="number" name="amount" min="1" step="0.01" value="<?php echo e(old('amount')); ?>" class="pixel-card w-full p-3 border-2 border-gray-300" required>
                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="pixel-font text-xs text-gray-700">Deskripsi</label>
                <input type="text" name="description" value="<?php echo e(old('description')); ?>" class="pixel-card w-full p-3 border-2 border-gray-300" required>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="md:col-span-2">
                <button type="submit" class="pixel-button px-6 py-3 bg-blue-500 text-white">SIMPAN TRANSAKSI</button>
            </div>
        </form>
    </div>

    <!-- Pemasukan Section -->
    <div class="mb-8">
        <h3 class="pixel-font text-green-600 text-sm mb-4">PEMASUKAN</h3>
        <div class="pixel-card p-4 bg-green-100 overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="pixel-card px-3 py-2 bg-green-300 text-left text-xs pixel-font">TANGGAL</th>
                        <th class="pixel-card px-3 py-2 bg-green-300 text-left text-xs pixel-font">DESKRIPSI</th>
                        <th class="pixel-card px-3 py-2 bg-green-300 text-right text-xs pixel-font">JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $incomes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $income): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="pixel-card px-3 py-2 bg-white text-xs"><?php echo e($income->date->format('d/m/Y')); ?></td>
                        <td class="pixel-card px-3 py-2 bg-white text-xs"><?php echo e($income->description); ?></td>
                        <td class="pixel-card px-3 py-2 bg-white text-right text-xs font-bold">Rp <?php echo e(number_format($income->amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Pengeluaran Section -->
    <div class="mb-8">
        <h3 class="pixel-font text-red-600 text-sm mb-4">PENGELUARAN</h3>
        <div class="pixel-card p-4 bg-red-100 overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="pixel-card px-3 py-2 bg-red-300 text-left text-xs pixel-font">TANGGAL</th>
                        <th class="pixel-card px-3 py-2 bg-red-300 text-left text-xs pixel-font">DESKRIPSI</th>
                        <th class="pixel-card px-3 py-2 bg-red-300 text-right text-xs pixel-font">JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="pixel-card px-3 py-2 bg-white text-xs"><?php echo e($expense->date->format('d/m/Y')); ?></td>
                        <td class="pixel-card px-3 py-2 bg-white text-xs"><?php echo e($expense->description); ?></td>
                        <td class="pixel-card px-3 py-2 bg-white text-right text-xs font-bold">Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Saldo Akhir -->
    <div class="pixel-card p-6 bg-yellow-200 text-center">
        <h3 class="pixel-font text-xs text-gray-900 mb-2">SALDO AKHIR</h3>
        <p class="pixel-font text-3xl text-yellow-600">Rp <?php echo e(number_format($balance, 0, ',', '.')); ?></p>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/bendahara/financial_report.blade.php ENDPATH**/ ?>