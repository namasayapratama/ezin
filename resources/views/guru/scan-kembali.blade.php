@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center  px-4">
    <h2 class="text-xl font-bold mb-4 text-center">Scan QR Anda</h2>

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>

    <div id="reader" class="w-full max-w-md mx-auto mb-4"></div>

    <div x-data="{ showScanForm: false }" class="space-y-4 w-full max-w-md">
        <div class="flex justify-center gap-4">
            <button 
                @click="showScanForm = true; $nextTick(() => $refs.qrInput.focus())" 
                class="bg-blue-600 text-white px-4 py-2 rounded">
                Scan dengan perangkat scanner
            </button>
            <button 
                @click="showScanForm = false" 
                class="bg-blue-400 text-white px-4 py-2 rounded">
                Sembunyikan Form
            </button>
        </div>

        <div x-show="showScanForm" x-transition>
            <form method="POST" action="{{ route('guru.scan.submit') }}" x-ref="scanForm" class="w-full">
                @csrf
                <label class="block text-sm font-medium mb-1 text-center">Scan Kode QR</label>
                <input 
                    type="text" 
                    name="uuid"
                    x-ref="qrInput"
                    x-on:keydown.enter.prevent="$refs.scanForm.submit()"
                    class="border p-2 w-full rounded"
                    placeholder="Scan kode QR..." required>
            </form>
        </div>
    </div>

    <form id="scanForm" action="{{ route('guru.scan.submit') }}" method="POST" class="hidden">
        @csrf
        <input type="hidden" name="uuid" id="qr-result">
    </form>

    <script>
        function onScanSuccess(decodedText, decodedResult) {
            document.getElementById('qr-result').value = decodedText;
            document.getElementById('scanForm').submit();
        }

        const html5QrCode = new Html5Qrcode("reader");

        Html5Qrcode.getCameras().then(cameras => {
            if (cameras && cameras.length) {
                html5QrCode.start(
                    cameras[0].id,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    onScanSuccess
                );
            }
        }).catch(err => {
            console.error("Camera error:", err);
        });
    </script>

    @if(session('error'))
        <p class="text-red-500 mt-2 text-center">{{ session('error') }}</p>
    @endif
</div>
@endsection
