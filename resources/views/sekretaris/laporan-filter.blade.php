<!DOCTYPE html>
<html>
<head>
    <title>Pilih Laporan</title>
</head>
<body>

    <h2>Pilih Periode Laporan Absensi</h2>

    <form method="GET" action="{{ route('sekretaris.laporan') }}">
        <label>Bulan:</label>
        <select name="bulan">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>

        <label>Tahun:</label>
        <input type="number" name="tahun" value="{{ date('Y') }}">

        <br><br>

        <button type="submit">Lihat Laporan</button>
    </form>

</body>
</html>