<!DOCTYPE html>
<html>
<head>
    <title>Pilih Laporan</title>
</head>
<body>

    <h2>Pilih Periode Laporan Absensi</h2>

    <form method="GET" action="<?php echo e(route('sekretaris.laporan')); ?>">
        <label>Bulan:</label>
        <select name="bulan">
            <?php for($i = 1; $i <= 12; $i++): ?>
                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
            <?php endfor; ?>
        </select>

        <label>Tahun:</label>
        <input type="number" name="tahun" value="<?php echo e(date('Y')); ?>">

        <br><br>

        <button type="submit">Lihat Laporan</button>
    </form>

</body>
</html><?php /**PATH C:\laragon\www\projectsc\resources\views/sekretaris/laporan-filter.blade.php ENDPATH**/ ?>