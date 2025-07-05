@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Dashboard Workstation</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-blue-600">Izin Masuk Hari Ini</h3>
        <p class="text-4xl font-bold text-blue-700">{{ $masukHariIni }}</p>
    </div>
    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold text-teal-600">Izin Keluar Hari Ini</h3>
        <p class="text-4xl font-bold text-teal-700">{{ $keluarHariIni }}</p>
    </div>
</div>

{{-- TABEL Izin Masuk --}}
<div class="mt-8">
    <h3 class="text-lg font-semibold mb-3">Izin Masuk Terbaru Hari Ini</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded text-sm">
            <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Jam</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                @forelse ($recentMasuk as $izin)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $izin->user->name }}</td>
                        <td class="p-3">{{ $izin->user->kelas }}</td>
                        <td class="p-3">{{ $izin->alasan }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-500">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- TABEL Izin Keluar --}}
<div class="mt-8">
    <h3 class="text-lg font-semibold mb-3">Izin Keluar Terbaru Hari Ini</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded text-sm">
            <thead class="bg-blue-600 text-white text-center">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Kelas</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Jam</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                @forelse ($recentKeluar as $izin)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $izin->user->name }}</td>
                        <td class="p-3">{{ $izin->user->kelas }}</td>
                        <td class="p-3">{{ $izin->alasan }}</td>
                        <td class="p-3">{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('H:i') }}</td>
                        <td class="p-3">
                            @if ($izin->kembali_pada)
                                <span class="text-green-600 font-semibold">Sudah</span>
                            @else
                                <span class="text-red-600 font-semibold">Belum</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
