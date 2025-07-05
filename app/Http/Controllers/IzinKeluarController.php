<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\IzinKeluar;
use App\Mail\IzinKeluarNotification;
use Illuminate\Support\Facades\Mail;
use App\Helpers\WhatsappHelper;


class IzinKeluarController extends Controller
{
    public function create()
    {
        return view('siswa.izin-keluar');
    }

public function store(Request $request)
{
    $request->validate(['alasan' => 'required|string|max:255']);

    $izin = \App\Models\IzinKeluar::create([
        'user_id' => auth()->id(),
        'uuid' => Str::uuid(),
        'alasan' => $request->alasan,
        'waktu_izin' => now(),
    ]);
    WhatsappHelper::send($izin->user->no_hp_orangtua, "Siswa a.n:".$izin->user->name. " mengajukan izin keluar pada ".$izin->waktu_izin." dengan alasan:".$izin->alasan.". Pastikan anda menerima notifikasi kembali saat siswa telah kembali ");

    try {
        Mail::to($izin->user->email)->send(new IzinKeluarNotification($izin));

        if ($izin->user->email_orangtua) {
            Mail::to($izin->user->email_orangtua)->send(new IzinKeluarNotification($izin));
        }

    } catch (\Exception $e) {
        
        return view('siswa.izin-keluar-result', compact('izin'))
            ->with('email_error', '⚠️ Email notifikasi gagal dikirim.');
    }
    
    return view('siswa.izin-keluar-result', compact('izin'));
}

    public function riwayat()
{
    $riwayat = \App\Models\IzinKeluar::where('user_id', auth()->id())
        ->orderByDesc('waktu_izin')
        ->get();

    return view('siswa.riwayat-izin-keluar', compact('riwayat'));
}

}

