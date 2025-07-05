{{-- resources/views/siswa/dashboard.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold">Dashboard Siswa</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="text-lg font-bold mb-2">Izin Masuk Bulan Ini</h2>
        <p class="text-3xl text-blue-600 font-semibold">{{ $masukBulanIni }}</p>
    </div>
    <div class="bg-white rounded shadow p-4">
        <h2 class="text-lg font-bold mb-2">Izin Keluar Bulan Ini</h2>
        <p class="text-3xl text-teal-600 font-semibold">{{ $keluarBulanIni }}</p>
    </div>
</div>

<div class="mt-10">
    <h3 class="text-lg font-semibold mb-3">Riwayat Izin Masuk Terbaru</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($riwayatMasuk as $izin)
            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</p>
                <p class="font-semibold text-gray-800">{{ $izin->alasan }}</p>
            </div>
        @empty
            <div class="col-span-2 text-center text-gray-500">
                Belum ada izin masuk.
            </div>
        @endforelse
    </div>
</div>

<div class="mt-10">
    <h3 class="text-lg font-semibold mb-3">Riwayat Izin Keluar Terbaru</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($riwayatKeluar as $izin)
            <div class="bg-white p-4 rounded shadow">
                <p class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</p>
                <p class="font-semibold text-gray-800">{{ $izin->alasan }}</p>
                <p class="text-sm mt-1">
                    Status:
                    @if (is_null($izin->kembali_pada))
                        <span class="text-yellow-600 font-medium">Belum Kembali</span>
                    @else
                        <span class="text-green-600 font-medium">Sudah Kembali</span>
                    @endif
                </p>
            </div>
        @empty
            <div class="col-span-2 text-center text-gray-500">
                Belum ada izin keluar.
            </div>
        @endforelse
    </div>
</div>

@endsection


