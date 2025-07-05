<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class TestWAController extends Controller
{
    public function test()
{
    $url = 'https://texas.wablas.com/api/send-message';
    $token = 'yntZVZ7gBOkebM80LQAZVwULJXkxZDPf7i3NOs5UWIOgTh5P6CLLftt.O3c7WomV';

    $response = Http::withHeaders([
        'Authorization' => $token,
        'Content-Type' => 'application/json',
    ])->post($url, [
        'phone' => '6282116919415',
        'message' => '✅ Hello dari Laravel via POST',
        'secret' => false,
        'priority' => false
    ]);

    return response()->json([
        'status' => $response->status(),
        'response' => $response->json(),
    ]);
}
}