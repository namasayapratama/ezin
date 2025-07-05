<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\IzinKeluar;
use App\Mail\IzinKembaliNotification;
use Illuminate\Support\Facades\Mail;
use App\Helpers\WhatsappHelper;

class GuruController extends Controller
{
    public function scanForm()
    {
        return view('guru.scan-kembali');
    }

    public function validasiKembali(Request $request)
{
    $request->validate(['uuid' => 'required|uuid']);

    $izin = \App\Models\IzinKeluar::where('uuid', $request->uuid)->first();

    if (!$izin) {
        return back()->with('error', 'Data tidak ditemukan.');
    }

    if ($izin->kembali_pada) {
        return back()->with('error', 'Siswa sudah ditandai kembali.');
    }

    $izin->update([
        'kembali_pada' => now()
    ]);
    WhatsappHelper::send($izin->user->no_hp_orangtua, "Siswa a.n ".$izin->user->name." telah kembali dari Izin Keluar pada: ".$izin->kembali_pada);
    // Kirim email ke siswa
    try {
    Mail::to($izin->user->email)->send(new IzinKembaliNotification($izin));

// Kirim ke orang tua jika tersedia
if ($izin->user->email_orangtua) {
    Mail::to($izin->user->email_orangtua)->send(new IzinKembaliNotification($izin));
}
} catch (\Exception $e) {
        
        return view('siswa.izin-masuk-result', compact('izin'))
            ->with('email_error', '⚠️ Email notifikasi gagal dikirim.');
    }

    return back()->with('success', 'Berhasil! Siswa sudah ditandai kembali.');
}

}
