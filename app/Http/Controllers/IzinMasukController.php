<?php


namespace App\Http\Controllers;

use App\Models\IzinMasuk;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\IzinMasukNotification;
use App\Helpers\WhatsappHelper;


class IzinMasukController extends Controller
{
   public function create()
{
    return view('siswa.izin-masuk');
}

public function store(Request $request)
{
    $request->validate(['alasan' => 'required|string|max:255']);

    $izin = IzinMasuk::create([
        'user_id' => Auth::id(),
        'uuid' => Str::uuid(),
        'alasan' => $request->alasan,
        'waktu_izin' => now(),
    ]);
    WhatsappHelper::send($izin->user->no_hp_orangtua, "Siswa a.n *".$izin->user->name."* mengajukan izin *Masuk Terlambat* pada ".$izin->waktu_izin." dengan alasan: ".$izin->alasan);

    try {
        Mail::to($izin->user->email)->send(new IzinMasukNotification($izin));

        if ($izin->user->email_orangtua) {
            Mail::to($izin->user->email_orangtua)->send(new IzinMasukNotification($izin));
        }

    } catch (\Exception $e) {
        
        return view('siswa.izin-masuk-result', compact('izin'))
            ->with('email_error', '⚠️ Email notifikasi gagal dikirim.');
    }
    
    
    return view('siswa.izin-masuk-result', compact('izin'));
}


public function riwayat()
{
    $riwayat = \App\Models\IzinMasuk::where('user_id', auth()->id())
        ->orderByDesc('waktu_izin')
        ->get();

    return view('siswa.riwayat-izin-masuk', compact('riwayat'));
}


}
