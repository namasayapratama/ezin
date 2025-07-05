@extends('layouts.app')

@section('content')
<div>
<h2 class=" font-bold text-lg mb-4">Cetak Surat Izin Keluar</h2>
            <table>
                <tr><td><strong>Nama</strong></td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;</td><td>{{ $izin->user->name }}</td></tr>
                <tr><td><strong>Kelas</strong></td></td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; </td><td>{{ $izin->user->kelas }}</td></tr>
                <tr><td><strong>Alasan</strong></td></td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp;&nbsp; </td><td>{{ $izin->alasan }}</td></tr>
                <tr><td><strong>Waktu</strong></td></td><td> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; </td><td>{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</td></tr>
            </table>
<div class="flex gap-2">
    <!--<a href="{{ route('workstation.keluar.cetak', $izin->uuid) }}"
       class="bg-green-600 text-white px-4 py-2 rounded">Cetak Langsung</a>
    -->
 {{-- Jika belum dicetak --}}
@if (is_null($izin->dicetak_pada))
    <button onclick="openPrintModal()" class="bg-blue-600 text-white px-4 py-2 rounded">
        🖨️ Lihat & Cetak Surat
    </button>
@else
    <span class="bg-gray-400 text-white px-4 py-2 rounded inline-block cursor-not-allowed">
        🕒 Sudah Dicetak ({{ \Carbon\Carbon::parse($izin->dicetak_pada)->format('d/m/Y H:i') }})
    </span>
@endif
</div>
</div>
{{-- Modal --}}
<div id="printModal" class="fixed inset-0 bg-black bg-opacity-50 z-[999] flex items-center justify-center hidden">
    <div class="bg-white w-[600px] rounded shadow p-6 relative">
        <button onclick="closePrintModal()" class="absolute top-2 right-2 text-gray-600">✖</button>

        <div id="print-area">
            <h3 class="text-center font-bold text-lg mb-4">{{ \App\Models\Setting::get('school_name') }}</h3>
            
            <h5 class="text-center font-bold text-lg mb-4">Surat Izin Keluar</h5>
            <table class="w-full">
                <tr><td><strong>Nama</strong></td><td> : </td><td>{{ $izin->user->name }}</td></tr>
                <tr><td><strong>Kelas</strong></td></td><td> : </td><td>{{ $izin->user->kelas }}</td></tr>
                <tr><td><strong>Alasan</strong></td></td><td> : </td><td>{{ $izin->alasan }}</td></tr>
                <tr><td><strong>Waktu</strong></td></td><td> : </td><td>{{ \Carbon\Carbon::parse($izin->waktu_izin)->format('d/m/Y H:i') }}</td></tr>
            </table>

            <div class="mt-6">
                <p>Tanda tangan petugas:</p>
                <br><br>
                <p>________________________</p>
            </div>
            <div class="mt-4">
             {!! QrCode::size(150)->generate($izin->uuid) !!}
            </div>
        </div>

        <div class="mt-6 text-center">
            <button onclick="printDiv('print-area')" class="bg-blue-700 text-white px-4 py-2 rounded">
                Cetak
            </button>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    function openPrintModal() {
        document.getElementById('printModal').classList.remove('hidden');
    }

    function closePrintModal() {
        document.getElementById('printModal').classList.add('hidden');
    }

    function printDiv(id) {
    fetch('{{ route('izin-keluar.mark-printed', $izin->uuid) }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    }).then(() => {
        const printContents = document.getElementById(id).innerHTML;
        const originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    });
}
   
</script>
@endpush

