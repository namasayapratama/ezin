@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Data Pengguna</h2>
<div class="flex justify-between items-center mb-4">
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">+ Tambah User</a>

    <a href="{{ route('admin.import.form') }}" class="bg-green-600 text-white px-4 py-2 rounded">
        ⬆️ Import User
    </a>
</div>


<form method="GET" action="{{ route('admin.users') }}" class="flex items-center gap-4 mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/email"
        class="border p-2 rounded w-64">

    <select name="role" class="border p-2 rounded">
        <option value="">Semua Role</option>
        @foreach ($roles as $role)
            <option value="{{ $role }}" {{ request('role') == $role ? 'selected' : '' }}>
                {{ ucfirst($role) }}
            </option>
        @endforeach
    </select>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
    <a href="{{ route('admin.users') }}" class="text-sm text-gray-500 hover:underline">Reset</a>
</form>

<table class="w-full border text-sm">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-2 border">Nama</th>
            <th class="p-2 border">Email</th>
            <th class="p-2 border">Role</th>
            <th class="p-2 border">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $user)
        <tr>
            <td class="p-2 border">{{ $user->name }}</td>
            <td class="p-2 border">{{ $user->email }}</td>
            <td class="p-2 border">{{ $user->getRoleNames()->first() }}</td>
            <td class="p-2 border space-x-2">
    <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 underline">Edit</a>
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus user ini?')">
        @csrf @method('DELETE')
        <button class="text-red-600 underline">Hapus</button>
    </form>
</td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection
