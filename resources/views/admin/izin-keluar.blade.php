@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Data Izin Keluar</h2>

<form method="GET" class="mb-6 flex flex-wrap gap-4 items-end">
    <div>
        <label class="block text-sm">Cari Nama</label>
        <input type="text" name="search" value="{{ request('search') }}"
            class="border rounded p-2 w-48" placeholder="Nama Siswa">
    </div>

    <div>
        <label class="block text-sm">Kelas</label>
        <select name="kelas" class="border rounded p-2 w-40">
            <option value="">Semua</option>
            @foreach($daftarKelas as $kelas)
                <option value="{{ $kelas }}" {{ request('kelas') == $kelas ? 'selected' : '' }}>
                    {{ $kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm">Dari Tanggal</label>
        <input type="date" name="start_date" value="{{ $start }}" class="border rounded p-2">
    </div>

    <div>
        <label class="block text-sm">Sampai Tanggal</label>
        <input type="date" name="end_date" value="{{ $end }}" class="border rounded p-2">
    </div>

    <div class="flex items-center">
        <input type="checkbox" name="belum_kembali" id="belum_kembali" value="1"
               {{ request('belum_kembali') ? 'checked' : '' }}
               class="mr-2">
        <label for="belum_kembali">Hanya yang belum kembali</label>
    </div>

    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
         <a href="{{ route('admin.izin-keluar') }}"
       class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
       Reset Filter
    </a>
    </div>

</form>

<div class="mb-4 flex gap-2">
    <a href="{{ route('admin.izin-keluar.export.excel', request()->query()) }}"
       class="bg-green-600 text-white px-4 py-2 rounded text-sm fa fa-file-excel-o"> Export Excel</a>

    <a href="{{ route('admin.izin-keluar.export.pdf', request()->query()) }}"
       class="bg-red-600 text-white px-4 py-2 rounded text-sm fa fa-file-pdf-o" > Export PDF</a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow rounded overflow-hidden">
        <thead class="bg-blue-600 text-white text-sm uppercase text-center">
            <tr>
                <th class="p-3">Nama</th>
                <th class="p-3">Kelas</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Alasan</th>
                <th class="p-3">Status</th> {{-- ✅ Tambah ini --}}
            </tr>
        </thead>
        <tbody class="text-gray-700 text-sm text-center">
            @forelse ($izinKeluar as $izin)
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-3">{{ $izin->user->name }}</td>
                    <td class="p-3">{{ $izin->user->kelas }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d-m-Y H:i') }}</td>
                    <td class="p-3">{{ $izin->alasan }}</td>
                    <td class="p-3">
                @if (is_null($izin->kembali_pada))
                    <span class="text-orange-500 font-semibold">Belum</span>
                @else
                    <span class="text-green-600 font-semibold">Sudah</span>
                @endif
            </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $izinKeluar->links() }}
</div>
@endsection
