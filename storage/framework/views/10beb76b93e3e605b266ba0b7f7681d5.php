<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .text-center {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 4px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .nama {
            text-align: left;
            padding-left: 8px;
        }
        .btn {
            padding: 6px 12px;
            text-decoration: none;
            margin-right: 10px;
            border-radius: 4px;
        }
        .btn-back {
            background: #ccc;
            color: black;
        }
        .btn-print {
            background: black;
            color: white;
        }
    </style>
</head>
<body>

    
    <div style="margin-bottom: 15px;">
        <a href="<?php echo e(route('sekretaris.laporan')); ?>" class="btn btn-back">
            ← Kembali
        </a>

        <a href="<?php echo e(route('sekretaris.laporan.cetak', ['bulan'=>$bulan, 'tahun'=>$tahun])); ?>" class="btn btn-print">
            🖨️ Download PDF
    </a>
    </div>

    
    <?php
        $namaBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
    ?>

    
    <div class="text-center">
        <h2>LAPORAN ABSENSI SISWA</h2>
        <p>Bulan: <?php echo e($namaBulan[$bulan]); ?> <?php echo e($tahun); ?></p>
    </div>

    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>

                
                <?php for($i = 1; $i <= $jumlahHari; $i++): ?>
                    <th><?php echo e($i); ?></th>
                <?php endfor; ?>

                <th>H</th>
                <th>S</th>
                <th>I</th>
                <th>A</th>
            </tr>
        </thead>

        <tbody>
            <?php $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td class="nama"><?php echo e($row['nama']); ?></td>

                    
                    <?php for($i = 1; $i <= $jumlahHari; $i++): ?>
                        <?php
                            $status = $row['hari'][$i];
                        ?>

                        <td>
                            <?php if($status == 'hadir'): ?> H
                            <?php elseif($status == 'sakit'): ?> S
                            <?php elseif($status == 'izin'): ?> I
                            <?php elseif($status == 'alpha'): ?> A
                            <?php else: ?> -
                            <?php endif; ?>
                        </td>
                    <?php endfor; ?>

                    
                    <td><?php echo e($row['total']['hadir']); ?></td>
                    <td><?php echo e($row['total']['sakit']); ?></td>
                    <td><?php echo e($row['total']['izin']); ?></td>
                    <td><?php echo e($row['total']['alpha']); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <br><br>

    
    <div style="width: 200px; float: right; text-align: center;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><b>Sekretaris</b></p>
    </div>

</body>
</html><?php /**PATH C:\laragon\www\projectsc\resources\views/sekretaris/laporan.blade.php ENDPATH**/ ?>