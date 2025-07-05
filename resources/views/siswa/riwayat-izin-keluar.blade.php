@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Riwayat Izin Keluar</h2>

<table class="w-full border text-sm">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border">Tanggal</th>
            <th class="p-2 border">Alasan</th>
            <th class="p-2 border">Status Kembali</th>
        </tr>
    </thead>
    <tbody>
    @forelse($riwayat as $izin)
        <tr>
            <td class="p-2 border">{{ $izin->waktu_izin }}</td>
            <td class="p-2 border">{{ $izin->alasan }}</td>
            <td class="p-2 border">{{ $izin->kembali_pada ? '✅ Sudah' : '❌ Belum' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="p-4 text-center">Belum ada izin keluar.</td>
        </tr>
    @endforelse
    </tbody>
</table>
@endsection
