<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Tracker Absensi</h1>

    <!-- Month Selector -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold">
                <?php echo e(\Carbon\Carbon::create($currentYear, $currentMonth)->locale('id')->format('F Y')); ?>

            </h2>
            <div class="flex gap-2">
                <a href="?month=<?php echo e(max(1, $currentMonth - 1)); ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Previous</a>
                <a href="?month=<?php echo e(min(12, $currentMonth + 1)); ?>" class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300">Next</a>
            </div>
        </div>
        <div class="mt-2 flex gap-2">
            <a href="?month=1" class="px-2 py-1 text-xs <?php echo e($currentMonth == 1 ? 'bg-blue-500 text-white' : 'bg-gray-100'); ?> rounded">Januari</a>
            <a href="?month=2" class="px-2 py-1 text-xs <?php echo e($currentMonth == 2 ? 'bg-blue-500 text-white' : 'bg-gray-100'); ?> rounded">Februari</a>
            <a href="?month=3" class="px-2 py-1 text-xs <?php echo e($currentMonth == 3 ? 'bg-blue-500 text-white' : 'bg-gray-100'); ?> rounded">Maret</a>
        </div>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-green-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-green-700"><?php echo e($totalHadir); ?></div>
            <div class="text-sm text-green-600">Hadir</div>
        </div>
        <div class="bg-yellow-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-yellow-700"><?php echo e($totalSakit); ?></div>
            <div class="text-sm text-yellow-600">Sakit</div>
        </div>
        <div class="bg-blue-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-blue-700"><?php echo e($totalIzin); ?></div>
            <div class="text-sm text-blue-600">Izin</div>
        </div>
        <div class="bg-red-100 p-4 rounded text-center">
            <div class="text-2xl font-bold text-red-700"><?php echo e($totalAlpha); ?></div>
            <div class="text-sm text-red-600">Alpha</div>
        </div>
    </div>

    <!-- Students Summary -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-4 border-b">
            <h2 class="text-lg font-semibold">Ringkasan per Siswa</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Siswa</th>
                        <th class="px-4 py-2 text-center">Hadir</th>
                        <th class="px-4 py-2 text-center">Sakit</th>
                        <th class="px-4 py-2 text-center">Izin</th>
                        <th class="px-4 py-2 text-center">Alpha</th>
                        <th class="px-4 py-2 text-center">Total</th>
                        <th class="px-4 py-2 text-center">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $studentAttendances = $attendances->get($student->id, collect());
                            $hadir = $studentAttendances->where('status', 'hadir')->count();
                            $sakit = $studentAttendances->where('status', 'sakit')->count();
                            $izin = $studentAttendances->where('status', 'izin')->count();
                            $alpha = $studentAttendances->where('status', 'alpha')->count();
                            $total = $studentAttendances->count();
                        ?>
                        <tr class="border-b">
                            <td class="px-4 py-2 font-medium"><?php echo e($student->name); ?></td>
                            <td class="px-4 py-2 text-center text-green-600"><?php echo e($hadir); ?></td>
                            <td class="px-4 py-2 text-center text-yellow-600"><?php echo e($sakit); ?></td>
                            <td class="px-4 py-2 text-center text-blue-600"><?php echo e($izin); ?></td>
                            <td class="px-4 py-2 text-center text-red-600"><?php echo e($alpha); ?></td>
                            <td class="px-4 py-2 text-center font-semibold"><?php echo e($total); ?></td>
                            <td class="px-4 py-2 text-center">
                                <?php if($total > 0): ?>
                                    <button onclick="showDetail(<?php echo e($student->id); ?>)" class="text-blue-500 hover:text-blue-700 text-sm">
                                        Lihat Detail
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Modal -->
    <div id="detailModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold" id="modalTitle">Detail Absensi</h3>
                    <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>
                <div id="modalContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDetail(studentId) {
    const modal = document.getElementById('detailModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalContent = document.getElementById('modalContent');
    
    // Find student name
    const studentNames = {
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo e($student->id); ?>: '<?php echo e($student->name); ?>',
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    };
    
    modalTitle.textContent = 'Detail Absensi - ' + studentNames[studentId];
    
    // Load attendance details
    fetch(`/api/student-attendance/${studentId}?month=<?php echo e($currentMonth); ?>&year=<?php echo e($currentYear); ?>`)
        .then(response => response.json())
        .then(data => {
            let html = '<div class="overflow-x-auto"><table class="w-full"><thead><tr><th class="px-4 py-2 text-left">Tanggal</th><th class="px-4 py-2 text-left">Status</th><th class="px-4 py-2 text-left">Jam</th></tr></thead><tbody>';
            
            data.forEach(attendance => {
                const statusBadge = {
                    'hadir': '<span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">Hadir</span>',
                    'sakit': '<span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">Sakit</span>',
                    'izin': '<span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">Izin</span>',
                    'alpha': '<span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">Alpha</span>',
                    'belum_absen': '<span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">Belum Absen</span>'
                };
                
                html += `<tr>
                    <td class="px-4 py-2">${attendance.date}</td>
                    <td class="px-4 py-2">${statusBadge[attendance.status] || statusBadge['belum_absen']}</td>
                    <td class="px-4 py-2">${attendance.attendance_time || '-'}</td>
                </tr>`;
            });
            
            html += '</tbody></table></div>';
            modalContent.innerHTML = html;
            modal.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Error:', error);
            modalContent.innerHTML = '<p class="text-red-500">Gagal memuat data</p>';
            modal.classList.remove('hidden');
        });
}

function closeModal() {
    document.getElementById('detailModal').classList.add('hidden');
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectsc\resources\views/sekretaris/tracker.blade.php ENDPATH**/ ?>