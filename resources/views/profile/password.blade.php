@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Ubah Password</h2>

@if (session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('profile.password.update') }}" class="max-w-md space-y-4">
    @csrf

    <div>
        <label class="block text-sm">Password Lama</label>
        <input type="password" name="current_password"
               class="w-full border rounded p-2" required>
        @error('current_password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-sm">Password Baru</label>
        <input type="password" name="new_password"
               class="w-full border rounded p-2" required>
    </div>

    <div>
        <label class="block text-sm">Konfirmasi Password Baru</label>
        <input type="password" name="new_password_confirmation"
               class="w-full border rounded p-2" required>
        @error('new_password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan Password
        </button>
    </div>
</form>
@endsection
