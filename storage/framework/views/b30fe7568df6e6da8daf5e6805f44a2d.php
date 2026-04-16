<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            background: white;
            font-size: 8px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 12px;
            margin: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7px;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            word-wrap: break-word;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
        }
        
        td:first-child {
            text-align: center;
            width: 25px;
        }
        
        td:nth-child(2) {
            text-align: left;
            font-weight: bold;
            width: 80px;
        }
        
        .ttd {
            text-align: right;
            margin-top: 30px;
        }
        
        .ttd p {
            font-size: 10px;
            margin: 5px 0;
        }
        
        .ttd .jabatan {
            font-weight: bold;
        }
        
        .hadir { color: #006600; }
        .sakit { color: #cc6600; }
        .izin { color: #0066cc; }
        .alpha { color: #cc0000; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN ABSENSI</h2>
        <p>
            <?php
                $namaBulan = [
                    1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
                    5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
                    9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
                ];
            ?>
            <?php echo e($namaBulan[$bulan]); ?> <?php echo e($tahun); ?>

        </p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">No</th>
                <th style="width: 80px;">Nama</th>
                <?php for($i = 1; $i <= $jumlahHari; $i++): ?>
                    <th style="width: 18px;"><?php echo e($i); ?></th>
                <?php endfor; ?>
                <th style="width: 20px;">H</th>
                <th style="width: 20px;">S</th>
                <th style="width: 20px;">I</th>
                <th style="width: 20px;">A</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $laporan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($row['nama']); ?></td>
                    
                    <?php for($i = 1; $i <= $jumlahHari; $i++): ?>
                        <?php $status = $row['hari'][$i]; ?>
                        <td>
                            <?php if($status == 'hadir'): ?> 
                                <span class="hadir">H</span>
                            <?php elseif($status == 'sakit'): ?> 
                                <span class="sakit">S</span>
                            <?php elseif($status == 'izin'): ?> 
                                <span class="izin">I</span>
                            <?php elseif($status == 'alpha'): ?> 
                                <span class="alpha">A</span>
                            <?php else: ?> 
                                -
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

    <div class="ttd">
        <p>Mengetahui,</p>
        <br><br><br>
        <p class="jabatan">Sekretaris</p>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\projectsc\resources\views/sekretaris/laporan-cetak.blade.php ENDPATH**/ ?>