<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Keluar</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
    </style>
</head>
<body>
    <h2>Surat Izin Keluar</h2>
    <p>Nama: {{ $izin->user->name }}</p>
    <p>NISN: {{ $izin->user->nisn }}</p>
    <p>Kelas: {{ $izin->user->kelas }}</p>
    <p>Waktu Izin: {{ $izin->waktu_izin }}</p>
    <p>Alasan: {{ $izin->alasan }}</p>
    <br>
    <p>Tanda tangan petugas:</p>
    <p>________________________</p>
</body>
</html>
