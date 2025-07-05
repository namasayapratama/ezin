@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">Import Data Pengguna</h2>

@if(session('success'))
    <div class="mb-4 text-green-600">{{ session('success') }}</div>
@endif

<form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    <input type="file" name="file" accept=".xlsx,.xls" required>
    <button class="bg-blue-600 text-white px-4 py-2">Import</button>
</form>

<div class="mt-6">
    <a href="{{ route('admin.template.download') }}" class="text-blue-600 underline">📥 Download Template Excel</a>
</div>
@endsection
