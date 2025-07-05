@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Dashboard Admin</h2>


{{-- Statistik Izin Masuk --}}
<h1 class="text-lg font-semibold mb-4">Statistik Izin Masuk</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Hari Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $masukHariIni }}</div>
            <p class="text-sm text-gray-500">Izin Masuk Hari Ini</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Minggu Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $masukMingguIni }}</div>
            <p class="text-sm text-gray-500">Izin Masuk Minggu Ini</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Bulan Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $masukBulanIni }}</div>
            <p class="text-sm text-gray-500">Izin Masuk Bulan Ini</p>
        </div>
    </div>
</div>

{{-- Statistik Izin Keluar --}}
<h1 class="text-lg font-semibold mt-10 mb-4">Statistik Izin Keluar</h1>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Hari Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $keluarHariIni }}</div>
            <p class="text-sm text-gray-500">Izin Keluar Hari Ini</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Minggu Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $keluarMingguIni }}</div>
            <p class="text-sm text-gray-500">Izin Keluar Minggu Ini</p>
        </div>
    </div>

    <div class="bg-white shadow rounded p-6">
        <div class="flex justify-between items-center">
            <div class="text-blue-600 text-xl font-semibold">Bulan Ini</div>
        </div>
        <div class="mt-4 text-center">
            <div class="text-3xl font-bold text-blue-700">{{ $keluarBulanIni }}</div>
            <p class="text-sm text-gray-500">Izin Keluar Bulan Ini</p>
        </div>
    </div>
</div>

{{-- Izin Masuk Terbaru --}}
<div class="mt-12">
    <h3 class="text-lg font-semibold mb-2">Izin Masuk Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded overflow-hidden">
            <thead class="bg-blue-600 text-white text-center text-sm uppercase">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Waktu</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                @foreach ($izinMasuk as $izin)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $izin->user->name }}</td>
                        <td class="p-3">{{ $izin->alasan }}</td>
                        <td class="p-3">{{ $izin->waktu_izin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Izin Keluar Terbaru --}}
<div class="mt-10">
    <h3 class="text-lg font-semibold mb-2">Izin Keluar Terbaru</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow rounded overflow-hidden">
            <thead class="bg-blue-600 text-white text-center text-sm uppercase">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Alasan</th>
                    <th class="p-3">Waktu</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-center">
                @foreach ($izinKeluar as $izin)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-3">{{ $izin->user->name }}</td>
                        <td class="p-3">{{ $izin->alasan }}</td>
                        <td class="p-3">{{ $izin->waktu_izin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
