<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Izin</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Laporan Izin Siswa</h2>
    <p>Tanggal: {{ $tanggal }}</p>

    <h3>Izin Masuk</h3>
    <table>
        <thead>
            <tr><th>Nama</th><th>Alasan</th><th>Waktu</th></tr>
        </thead>
        <tbody>
            @forelse($izinMasuk as $izin)
                <tr>
                    <td>{{ $izin->user->name }}</td>
                    <td>{{ $izin->alasan }}</td>
                    <td>{{ $izin->waktu_izin }}</td>
                </tr>
            @empty
                <tr><td colspan="3">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3>Izin Keluar</h3>
    <table>
        <thead>
            <tr><th>Nama</th><th>Alasan</th><th>Waktu</th><th>Kembali?</th></tr>
        </thead>
        <tbody>
            @forelse($izinKeluar as $izin)
                <tr>
                    <td>{{ $izin->user->name }}</td>
                    <td>{{ $izin->alasan }}</td>
                    <td>{{ $izin->waktu_izin }}</td>
                    <td>{{ $izin->kembali_pada ? 'Ya' : 'Belum' }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Tidak ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
