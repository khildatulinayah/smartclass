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

    {{-- 🔥 TOMBOL --}}
    <div style="margin-bottom: 15px;">
        <a href="{{ route('sekretaris.laporan') }}" class="btn btn-back">
            ← Kembali
        </a>

        <a href="{{ route('sekretaris.laporan.cetak', ['bulan'=>$bulan, 'tahun'=>$tahun]) }}" class="btn btn-print">
            🖨️ Download PDF
    </a>
    </div>

    {{-- 🔥 FORMAT BULAN --}}
    @php
        $namaBulan = [
            1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',
            5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',
            9=>'September',10=>'Oktober',11=>'November',12=>'Desember'
        ];
    @endphp

    {{-- HEADER --}}
    <div class="text-center">
        <h2>LAPORAN ABSENSI SISWA</h2>
        <p>Bulan: {{ $namaBulan[$bulan] }} {{ $tahun }}</p>
    </div>

    {{-- TABEL --}}
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>

                {{-- Header tanggal --}}
                @for ($i = 1; $i <= $jumlahHari; $i++)
                    <th>{{ $i }}</th>
                @endfor

                <th>H</th>
                <th>S</th>
                <th>I</th>
                <th>A</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($laporan as $index => $row)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td class="nama">{{ $row['nama'] }}</td>

                    {{-- Isi absensi --}}
                    @for ($i = 1; $i <= $jumlahHari; $i++)
                        @php
                            $status = $row['hari'][$i];
                        @endphp

                        <td>
                            @if ($status == 'hadir') H
                            @elseif ($status == 'sakit') S
                            @elseif ($status == 'izin') I
                            @elseif ($status == 'alpha') A
                            @else -
                            @endif
                        </td>
                    @endfor

                    {{-- Total --}}
                    <td>{{ $row['total']['hadir'] }}</td>
                    <td>{{ $row['total']['sakit'] }}</td>
                    <td>{{ $row['total']['izin'] }}</td>
                    <td>{{ $row['total']['alpha'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>

    {{-- TTD --}}
    <div style="width: 200px; float: right; text-align: center;">
        <p>Mengetahui,</p>
        <br><br><br>
        <p><b>Sekretaris</b></p>
    </div>

</body>
</html>