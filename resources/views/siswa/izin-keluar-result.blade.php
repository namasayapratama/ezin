@extends('layouts.app')

@section('content')
@if(session('email_error'))
    <div class="bg-yellow-100 text-yellow-700 p-3 mb-4 rounded">
        {{ session('email_error') }}
    </div>
@endif

<h2 class="text-xl font-bold mb-4">Izin Keluar Dikirim</h2>
<p>Scan QR Code di workstation untuk mencetak surat izin.</p>

<div class="mt-4">
    {!! QrCode::size(200)->generate($izin->uuid) !!}
</div>
@endsection
