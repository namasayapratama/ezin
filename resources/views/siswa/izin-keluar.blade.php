@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Form Izin Keluar</h2>
<form action="{{ route('siswa.izin-keluar.store') }}" method="POST">
    @csrf
    <label class="block mb-2">Alasan Izin:</label>
    <input type="text" name="alasan" class="border p-2 w-full mb-4" required>
    <button class="bg-blue-500 text-white px-4 py-2">Kirim</button>
</form>
@endsection
