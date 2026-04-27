<?php $__env->startSection('content'); ?>
<div class="w-full px-4 py-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Absensi Harian</h1>
        <a href="<?php echo e(route('sekretaris.dashboard')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
            ← Dashboard
        </a>
    </div>
    
    
    <div class="flex items-center justify-between mb-6 bg-white p-4 rounded-lg shadow-sm border">
        <div class="flex items-center space-x-2">
            <a href="<?php echo e(route('sekretaris.absensi', ['date' => \Carbon\Carbon::parse($selectedDate)->subDay()->format('Y-m-d')])); ?>" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                ← Kemarin
            </a>
            <a href="<?php echo e(route('sekretaris.absensi')); ?>" 
               class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                Hari Ini
            </a>
            <a href="<?php echo e(route('sekretaris.absensi', ['date' => \Carbon\Carbon::parse($selectedDate)->addDay()->format('Y-m-d')])); ?>" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition">
                Besok →
            </a>
        </div>
        <p class="text-lg font-semibold text-gray-800">
            <?php echo e(\Carbon\Carbon::parse($selectedDate)->locale('id')->format('l, d F Y')); ?>

        </p>
    </div>

    <?php if(session('success')): ?>
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($holiday): ?>
        <div class="bg-red-100 border-2 border-red-400 text-red-800 px-6 py-4 rounded-lg mb-6 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-1">📅 Hari Libur / Hari Merah</h3>
                    <p class="text-lg"><?php echo e($holiday->note); ?></p>
                    <p class="text-sm mt-1 opacity-75">Dibuat oleh: <?php echo e($holiday->creator->name ?? 'Sistem'); ?></p>
                </div>
                <form action="<?php echo e(route('sekretaris.absensi.delete_holiday')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="date" value="<?php echo e($selectedDate); ?>">
                    <button type="submit" class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600 text-sm font-medium" onclick="return confirm('Hapus keterangan libur?')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <!-- Holiday Message -->
        <div class="text-center py-12 bg-white rounded-lg shadow">
            <div class="text-4xl mb-4">📅</div>
            <h2 class="text-2xl font-bold mb-2 text-gray-700">Hari Libur - Tidak Ada Absensi</h2>
            <p class="text-gray-600 mb-4">Siswa libur hari ini sesuai keterangan di atas.</p>
        </div>
    <?php else: ?>
        <!-- Statistics -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
            <div class="bg-green-100 p-4 rounded text-center">
                <div class="text-2xl font-bold text-green-700"><?php echo e($attendances->where('status', 'hadir')->count()); ?></div>
                <div class="text-sm text-green-600">Hadir</div>
            </div>
            <div class="bg-yellow-100 p-4 rounded text-center">
                <div class="text-2xl font-bold text-yellow-700"><?php echo e($attendances->where('status', 'sakit')->count()); ?></div>
                <div class="text-sm text-yellow-600">Sakit</div>
            </div>
            <div class="bg-blue-100 p-4 rounded text-center">
                <div class="text-2xl font-bold text-blue-700"><?php echo e($attendances->where('status', 'izin')->count()); ?></div>
                <div class="text-sm text-blue-600">Izin</div>
            </div>
            <div class="bg-red-100 p-4 rounded text-center">
                <div class="text-2xl font-bold text-red-700"><?php echo e($attendances->where('status', 'alpha')->count()); ?></div>
                <div class="text-sm text-red-600">Alpha</div>
            </div>
            <div class="bg-gray-100 p-4 rounded text-center">
                <div class="text-2xl font-bold text-gray-700"><?php echo e($attendances->where('status', 'belum_absen')->count()); ?></div>
                <div class="text-sm text-gray-600">Belum Absen</div>
            </div>
        </div>

        <!-- Attendance Form -->
        <div class="bg-white rounded-lg shadow">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold">Update Absensi</h2>
            </div>
            
            <form action="<?php echo e(route('sekretaris.absensi.update')); ?>" method="POST" class="p-4">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="date" value="<?php echo e($selectedDate); ?>">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-4 py-2 text-left">Nama Siswa</th>
                                <th class="px-4 py-2 text-center">Status</th>
                                <th class="px-4 py-2 text-center">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $attendance = $attendances->get($student->id);
                                    $status = $attendance ? $attendance->status : 'belum_absen';
                                    $time = $attendance ? $attendance->attendance_time : '-';
                                ?>
                                <tr class="border-b">
                                    <td class="px-4 py-3 font-medium"><?php echo e($student->name); ?></td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1 justify-center">
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[<?php echo e($student->id); ?>]" value="belum_absen" <?php echo e($status == 'belum_absen' ? 'checked' : ''); ?> class="peer sr-only">
                                                <span class="px-2 py-1 text-xs rounded border border-gray-300 bg-gray-100 text-gray-700 peer-checked:bg-gray-500 peer-checked:text-white peer-checked:border-gray-500 transition select-none">Belum</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[<?php echo e($student->id); ?>]" value="hadir" <?php echo e($status == 'hadir' ? 'checked' : ''); ?> class="peer sr-only">
                                                <span class="px-2 py-1 text-xs rounded border border-green-300 bg-green-100 text-green-700 peer-checked:bg-green-600 peer-checked:text-white peer-checked:border-green-600 transition select-none">Hadir</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[<?php echo e($student->id); ?>]" value="sakit" <?php echo e($status == 'sakit' ? 'checked' : ''); ?> class="peer sr-only">
                                                <span class="px-2 py-1 text-xs rounded border border-yellow-300 bg-yellow-100 text-yellow-700 peer-checked:bg-yellow-500 peer-checked:text-white peer-checked:border-yellow-500 transition select-none">Sakit</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[<?php echo e($student->id); ?>]" value="izin" <?php echo e($status == 'izin' ? 'checked' : ''); ?> class="peer sr-only">
                                                <span class="px-2 py-1 text-xs rounded border border-blue-300 bg-blue-100 text-blue-700 peer-checked:bg-blue-600 peer-checked:text-white peer-checked:border-blue-600 transition select-none">Izin</span>
                                            </label>
                                            <label class="cursor-pointer">
                                                <input type="radio" name="status[<?php echo e($student->id); ?>]" value="alpha" <?php echo e($status == 'alpha' ? 'checked' : ''); ?> class="peer sr-only">
                                                <span class="px-2 py-1 text-xs rounded border border-red-300 bg-red-100 text-red-700 peer-checked:bg-red-600 peer-checked:text-white peer-checked:border-red-600 transition select-none">Alpha</span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center text-sm text-gray-600">
                                        <?php echo e($time != '-' ? \Carbon\Carbon::parse($time)->format('H:i') : '-'); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-6 flex flex-col sm:flex-row gap-2 justify-end items-end">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 flex-1 sm:flex-none">
                        Update Absensi
                    </button>
                    
                    
                    <div class="w-full sm:w-auto">
                        <textarea name="holiday_note" placeholder="Keterangan jika hari libur/merah (kosongkan jika tidak)" 
                                  rows="2" class="w-full p-2 border rounded resize-vertical focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/sekretaris/absensi.blade.php ENDPATH**/ ?>