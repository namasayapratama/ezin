@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-4">QR Izin Masuk</h2>

@if(session('email_error'))
    <div class="bg-yellow-100 text-yellow-700 p-3 mb-4 rounded">
        {{ session('email_error') }}
    </div>
@endif

<p>Silakan scan QR berikut di workstation untuk cetak surat izin.</p>

<div class="mt-6">
    {!! QrCode::size(200)->generate($izin->uuid) !!}
</div>
@endsection
