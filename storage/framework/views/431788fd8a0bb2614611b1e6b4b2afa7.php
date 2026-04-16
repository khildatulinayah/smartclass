<div class="mt-16 pt-8 border-t-4 border-black pixel-border">
    <h2 class="text-3xl font-bold text-center mb-12 pixel-font text-xs uppercase tracking-wider text-gray-900">🌟 DASHBOARD UNIVERSAL KELAS 🌟</h2>

    
    <section class="mb-16">
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h3 class="text-2xl font-bold pixel-font text-xs uppercase">📸 GALERI FOTO KELAS</h3>
            <?php if(auth()->user()->role === 'admin'): ?>
                <form action="<?php echo e(route('admin.gallery.store')); ?>" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 mt-4 md:mt-0" class="space-x-2">
                    <?php echo csrf_field(); ?>
                    <input type="file" name="photo" accept="image/*" required class="pixel-button px-4 py-2 bg-blue-400 text-black file:mr-2">
                    <input type="text" name="caption" placeholder="Caption (opsional)" maxlength="255" class="px-4 py-2 border-3 border-black rounded pixel-border w-48">
                    <button type="submit" class="pixel-button px-6 py-2 bg-green-400 text-black">UPLOAD</button>
                </form>
            <?php endif; ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $galleries ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="group relative overflow-hidden rounded-lg pixel-border hover:scale-105 transition-all">
                    <img src="<?php echo e(Storage::url('galleries/' . $gallery->photo)); ?>" alt="<?php echo e($gallery->caption); ?>" class="w-full h-48 object-cover pixelated">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all flex items-end p-4">
                        <p class="text-white text-sm opacity-0 group-hover:opacity-100 transition-all"><?php echo e(Str::limit($gallery->caption, 60)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full text-center py-12 text-gray-500">
                    📷 Belum ada foto kelas. Admin bisa upload di atas!
                </div>
            <?php endif; ?>
        </div>
    </section>

    
    <section class="mb-16">
        <h3 class="text-2xl font-bold pixel-font text-xs uppercase mb-8">📊 STATISTIK CEPAT</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <?php if (isset($component)) { $__componentOriginalc04e6956087c3840dbb4407b8e5948c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pixel-card','data' => ['bg' => 'bg-gradient-to-br from-blue-400 to-blue-500 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pixel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => 'bg-gradient-to-br from-blue-400 to-blue-500 text-white']); ?>
                 <?php $__env->slot('icon', null, []); ?> <div class="text-3xl">👥</div> <?php $__env->endSlot(); ?>
                <div>
                    <div class="text-2xl font-bold"><?php echo e($totalStudents ?? '0'); ?></div>
                    <div class="text-sm opacity-90">Total Siswa</div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $attributes = $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $component = $__componentOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc04e6956087c3840dbb4407b8e5948c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pixel-card','data' => ['bg' => 'bg-gradient-to-br from-green-400 to-green-500 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pixel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => 'bg-gradient-to-br from-green-400 to-green-500 text-white']); ?>
                 <?php $__env->slot('icon', null, []); ?> <div class="text-3xl">💰</div> <?php $__env->endSlot(); ?>
                <div>
                    <div class="text-2xl font-bold">Rp <?php echo e(number_format($totalKas ?? 0, 0, ',', '.')); ?></div>
                    <div class="text-sm opacity-90">Total Kas</div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $attributes = $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $component = $__componentOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc04e6956087c3840dbb4407b8e5948c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pixel-card','data' => ['bg' => 'bg-gradient-to-br from-emerald-400 to-emerald-500 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pixel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => 'bg-gradient-to-br from-emerald-400 to-emerald-500 text-white']); ?>
                 <?php $__env->slot('icon', null, []); ?> <div class="text-3xl">📅</div> <?php $__env->endSlot(); ?>
                <div>
                    <div class="text-2xl font-bold"><?php echo e($todayAttendance ?? '?'); ?>/30</div>
                    <div class="text-sm opacity-90">Hadir Hari Ini</div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $attributes = $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $component = $__componentOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc04e6956087c3840dbb4407b8e5948c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.pixel-card','data' => ['bg' => 'bg-gradient-to-br from-purple-400 to-purple-500 text-white']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('pixel-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => 'bg-gradient-to-br from-purple-400 to-purple-500 text-white']); ?>
                 <?php $__env->slot('icon', null, []); ?> <div class="text-3xl">⚡</div> <?php $__env->endSlot(); ?>
                <div>
                    <div class="text-2xl font-bold"><?php echo e($activeUsers ?? '0'); ?></div>
                    <div class="text-sm opacity-90">User Aktif</div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $attributes = $__attributesOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__attributesOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7)): ?>
<?php $component = $__componentOriginalc04e6956087c3840dbb4407b8e5948c7; ?>
<?php unset($__componentOriginalc04e6956087c3840dbb4407b8e5948c7); ?>
<?php endif; ?>
        </div>
    </section>

    
    <section>
        <h3 class="text-2xl font-bold pixel-font text-xs uppercase mb-8">📋 AKTIVITAS TERBARU</h3>
        <?php if (isset($component)) { $__componentOriginalc8463834ba515134d5c98b88e1a9dc03 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8463834ba515134d5c98b88e1a9dc03 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.data-table','data' => ['title' => 'Log Aktivitas']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('data-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Log Aktivitas']); ?>
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-4 text-left font-bold text-xs uppercase">Waktu</th>
                        <th class="px-6 py-4 text-left font-bold text-xs uppercase">User</th>
                        <th class="px-6 py-4 text-left font-bold text-xs uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $recentLogs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 border-b transition-colors">
                            <td class="px-6 py-4 text-sm"><?php echo e($log->created_at->format('d/m H:i')); ?></td>
                            <td class="px-6 py-4 font-medium text-sm"><?php echo e($log->user_name); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($log->description); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-500 text-sm">Belum ada aktivitas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8463834ba515134d5c98b88e1a9dc03)): ?>
<?php $attributes = $__attributesOriginalc8463834ba515134d5c98b88e1a9dc03; ?>
<?php unset($__attributesOriginalc8463834ba515134d5c98b88e1a9dc03); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8463834ba515134d5c98b88e1a9dc03)): ?>
<?php $component = $__componentOriginalc8463834ba515134d5c98b88e1a9dc03; ?>
<?php unset($__componentOriginalc8463834ba515134d5c98b88e1a9dc03); ?>
<?php endif; ?>
    </section>
</div>

<?php /**PATH C:\laragon\www\projectsc\resources\views/components/universal-dashboard.blade.php ENDPATH**/ ?>