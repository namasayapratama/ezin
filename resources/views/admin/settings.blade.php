@extends('layouts.app')

@section('content')
<h2 class="text-xl font-bold mb-6">Pengaturan Aplikasi</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-4 max-w-xl">
    @csrf

    <h3 class="text-lg font-semibold mt-6">Identitas Sekolah</h3>

    <div>
        <label class="block text-sm">Nama Sekolah</label>
        <input type="text" name="school_name" class="w-full border rounded p-2"
               value="{{ $settings['school_name'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Alamat Sekolah</label>
        <input type="text" name="school_address" class="w-full border rounded p-2"
               value="{{ $settings['school_address'] ?? '' }}">
    </div>

    <h3 class="text-lg font-semibold mt-6">Pengaturan Email</h3>

    <div>
        <label class="block text-sm">Mail Host</label>
        <input type="text" name="mail_host" class="w-full border rounded p-2"
               value="{{ $settings['mail_host'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Mail Port</label>
        <input type="text" name="mail_port" class="w-full border rounded p-2"
               value="{{ $settings['mail_port'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Username</label>
        <input type="text" name="mail_username" class="w-full border rounded p-2"
               value="{{ $settings['mail_username'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Password</label>
        <input type="password" name="mail_password" class="w-full border rounded p-2"
               value="{{ $settings['mail_password'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Encryption</label>
        <input type="text" name="mail_encryption" class="w-full border rounded p-2"
               value="{{ $settings['mail_encryption'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Dari Email</label>
        <input type="text" name="mail_from_address" class="w-full border rounded p-2"
               value="{{ $settings['mail_from_address'] ?? '' }}">
    </div>

    <div>
        <label class="block text-sm">Nama Pengirim</label>
        <input type="text" name="mail_from_name" class="w-full border rounded p-2"
               value="{{ $settings['mail_from_name'] ?? '' }}">
    </div>
    <div>
    <input type="hidden" name="whatsapp_enabled" value="0">
    <input type="checkbox" name="whatsapp_enabled" value="1"
    {{ setting('whatsapp_enabled') == '1' ? 'checked' : '' }}>
Aktifkan Notifikasi WhatsApp
    </div>  
    <div>
        <label class="font-semibold">WhatsApp API URL</label>
        <input type="text" name="whatsapp_api_url" class="border w-full rounded p-2"
               value="{{ $settings['whatsapp_api_url'] ?? '' }}">
    </div>

    <div>
        <label class="font-semibold">WhatsApp Token</label>
        <input type="text" name="whatsapp_token" class="border w-full rounded p-2"
               value="{{ $settings['whatsapp_token'] ?? '' }}">
    </div> 
    <div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
            Simpan Pengaturan
        </button>
    </div>

  
</form>
@endsection
