<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Izin Keluar</title>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div id="print-area" class="p-6 text-sm font-sans">
    <h2 class="text-center text-lg font-bold mb-4">Surat Izin Keluar</h2>
    <table class="w-full border-collapse">
        <tr><td><strong>Nama</strong></td><td>{{ $izin->user->name }}</td></tr>
        <tr><td><strong>Kelas</strong></td><td>{{ $izin->user->kelas }}</td></tr>
        <tr><td><strong>Alasan</strong></td><td>{{ $izin->alasan }}</td></tr>
        <tr><td><strong>Waktu</strong></td><td>{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</td></tr>
    </table>

    <br><br>
    <p>Tanda tangan petugas:</p>
    <br><br>
    <p>________________________</p>
</div>

{{-- Tombol manual cetak hanya untuk non-workstation --}}
@if(!auth()->user()->hasRole('workstation'))
    <div class="text-center mt-4">
        <button onclick="window.print()" class="bg-blue-600 text-white px-4 py-2 rounded">
            🖨️ Cetak Surat
        </button>
    </div>
@endif

{{-- Auto cetak untuk workstation --}}
@if(auth()->user()->hasRole('workstation'))
    <script>
        window.onload = function () {
            window.print();
        }
    </script>
@endif

</body>
</html>
