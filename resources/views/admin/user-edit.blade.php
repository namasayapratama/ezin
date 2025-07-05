@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Edit User</h2>

<form action="{{ route('admin.users.update', $user->id) }}" method="POST">
    @csrf @method('PUT')

    <label>Nama</label>
    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 mb-4">

    <label>Email</label>
    <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 mb-4">

    <label>Password (kosongkan jika tidak diubah)</label>
    <input type="password" name="password" class="w-full border p-2 mb-4">

    <label>Email Orang Tua</label>
    <input type="text" name="email_orangtua" value="{{ old('email_orangtua', $user->email_orangtua) }}" class="w-full border p-2 mb-4">

    <label>NISN</label>
    <input type="text" name="nisn" value="{{ old('nisn', $user->nisn) }}" class="w-full border p-2 mb-4">

    <label>Kelas</label>
    <input type="text" name="kelas" value="{{ old('kelas', $user->kelas) }}" class="w-full border p-2 mb-4">

    <label>Jurusan</label>
    <input type="text" name="jurusan" value="{{ old('jurusan', $user->jurusan) }}" class="w-full border p-2 mb-4">
<div>
    <label>No HP</label>
    <input type="text" name="no_hp" class="w-full border rounded p-2" value="{{ old('no_hp', $user->no_hp ?? '') }}">
</div>

<div>
    <label>No HP Orang Tua</label>
    <input type="text" name="no_hp_orangtua" class="w-full border rounded p-2" value="{{ old('no_hp_orangtua', $user->no_hp_orangtua ?? '') }}">
</div>

    <label>Role</label>
    <select name="role" class="w-full border p-2 mb-4">
        @foreach($roles as $role)
            <option value="{{ $role }}" {{ $user->hasRole($role) ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
