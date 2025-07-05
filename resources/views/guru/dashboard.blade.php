{{-- resources/views/guru/dashboard.blade.php --}}
@extends('layouts.app')
@if (session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

@section('content')
    <h1 class="text-2xl font-bold">Dashboard Guru</h1>
    <p>Selamat datang, {{ Auth::user()->name }}!</p>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded shadow p-4">
        <h2 class="text-lg font-bold mb-2">Izin Masuk Hari Ini</h2>
        <p class="text-3xl text-blue-600 font-semibold">{{ $masukHariIni }}</p>
    </div>

    <div class="bg-white rounded shadow p-4">
        <h2 class="text-lg font-bold mb-2">Izin Keluar Hari Ini</h2>
        <p class="text-3xl text-teal-600 font-semibold">{{ $keluarHariIni }}</p>
    </div>
</div>

<div class="mt-10">
    <h3 class="text-lg font-semibold mb-3">Siswa Belum Kembali Hari Ini</h3>

    @if ($belumKembaliHariIni->isEmpty())
        <p class="text-gray-500">Semua siswa telah kembali.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach ($belumKembaliHariIni as $izin)
                <div class="bg-white rounded shadow p-4">
                    <p class="text-sm text-gray-600">
                        <strong>{{ $izin->user->name }}</strong> – {{ $izin->user->kelas }}
                    </p>
                    <p class="text-sm mt-1">Waktu Izin: {{ \Carbon\Carbon::parse($izin->waktu_izin)->format('H:i') }}</p>
                    <p class="text-sm text-gray-700">Alasan: {{ $izin->alasan }}</p>

                    <form action="{{ route('guru.izin-kembali', $izin->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit"
                                onclick="return confirm('Tandai siswa ini sudah kembali?')"
                                class="bg-green-600 hover:bg-green-700 text-white text-sm px-4 py-2 rounded">
                            Tandai Sudah Kembali
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>


@endsection



