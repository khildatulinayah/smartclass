# TODO Perbaikan Tracker

## Masalah
1. Tombol "Lihat Detail" gagal memuat data (muncul "Gagal memuat data")
2. Navigasi Previous/Next tidak menangani perubahan tahun
3. Selector bulan hanya ada Jan-Mar, tidak lengkap
4. Tahun tidak dibaca dari parameter request

## Perbaikan
- [x] Analisis kode tracker, controller, routes
- [x] Fix method `getStudentAttendance` di SekretarisController
- [x] Fix navigasi bulan & tahun di tracker.blade.php
- [x] Fix tombol Previous/Next (handle pergantian tahun)
- [x] Tambah selector bulan April-Desember
