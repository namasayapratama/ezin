@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Tambah User</h2>

<form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
    @csrf
  
  <!-- Nama -->
  <div>
    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
    <input type="text" id="name" name="name" required
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- Email -->
  <div>
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" id="email" name="email" required
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- Password -->
  <div>
    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
    <input type="password" id="password" name="password" required
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- Email Orang Tua -->
  <div>
    <label for="email_orangtua" class="block text-sm font-medium text-gray-700">Email Orang Tua</label>
    <input type="email" id="email_orangtua" name="email_orangtua"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- NISN -->
  <div>
    <label for="nisn" class="block text-sm font-medium text-gray-700">NISN</label>
    <input type="text" id="nisn" name="nisn"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- Kelas -->
  <div>
    <label for="kelas" class="block text-sm font-medium text-gray-700">Kelas</label>
    <input type="text" id="kelas" name="kelas"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>

  <!-- Jurusan -->
  <div>
    <label for="jurusan" class="block text-sm font-medium text-gray-700">Jurusan</label>
    <input type="text" id="jurusan" name="jurusan"
      class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" />
  </div>
<div>
    <label>No HP</label>
    <input type="text" name="no_hp" class="w-full border rounded p-2" value="{{ old('no_hp', $user->no_hp ?? '') }}">
</div>

<div>
    <label>No HP Orang Tua</label>
    <input type="text" name="no_hp_orangtua" class="w-full border rounded p-2" value="{{ old('no_hp_orangtua', $user->no_hp_orangtua ?? '') }}">
</div>

  <!-- Role -->
  <div>
    <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
    <select name="role" class="w-full border p-2 rounded" required>
        @foreach($roles as $role)
            <option value="{{ $role }}">{{ ucfirst($role) }}</option>
        @endforeach
    </select>
  </div>



    <button class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
</form>
@endsection
