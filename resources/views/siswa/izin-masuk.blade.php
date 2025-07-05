@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Form Izin Masuk (Terlambat)</h2>
@if(session('error'))
    <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('siswa.izin-masuk.store') }}">
    @csrf
    <label class="block mb-2">Alasan:</label>
    <input type="text" name="alasan" class="border p-2 w-full mb-4" required>

    <button class="bg-blue-500 text-white px-4 py-2">Kirim</button>
</form>
@endsection
