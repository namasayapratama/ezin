<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Http;

class WhatsappHelper
{
   public static function send($to, $message)
{
    if (setting('whatsapp_enabled') != '1') {
        Log::info('📴 WhatsApp notifikasi dimatikan oleh admin.');
        return;
    }

    $url = setting('whatsapp_api_url');
    $token = setting('whatsapp_token');

    Log::info('📤 Kirim WA', [
    'url' => $url,
    'full_request' => [
        'headers' => [
            'Authorization' => $token,
            'Content-Type' => 'application/json',
        ],
        'payload' => [
            'phone' => $to,
            'message' => $message,
            'secret' => false,
            'priority' => false,
        ],
    ],
]);


    $response = Http::withHeaders([
        'Authorization' => $token,
        'Content-Type' => 'application/json',
    ])->post($url, [
        'phone' => $to,
        'message' => $message,
        'secret' => false,
        'priority' => false,
    ]);

    if (!$response->successful()) {
        Log::error('❌ Gagal kirim WA', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    } else {
        Log::info('✅ WA sukses terkirim', [
            'body' => $response->body(),
        ]);
    }

    return $response->json();
}
}