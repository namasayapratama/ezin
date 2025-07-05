<?php

// 📁 app/Http/Controllers/WorkstationController.php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\IzinMasuk;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\IzinKeluar;

class WorkstationController extends Controller
{
public function scanIzinKeluarForm()
{
    return view('workstation.scan-keluar');
}

public function scanIzinKeluar(Request $request)
{
    $request->validate(['uuid' => 'required|uuid']);

    $izin = IzinKeluar::where('uuid', $request->uuid)->first();

    if (!$izin) {
        return back()->with('error', 'Data tidak ditemukan.');
    }

    return view('workstation.result-keluar', compact('izin'));
}

public function cetakIzinKeluar($uuid)
{
    $izin = IzinKeluar::where('uuid', $uuid)->firstOrFail();

    if ($izin->dicetak_pada) {
        return back()->with('error', 'Surat ini sudah dicetak.');
    }

    $izin->update(['dicetak_pada' => now()]);

   //$pdf = Pdf::loadView('workstation.surat-izin-keluar', compact('izin'));
   // return $pdf->download('izin_keluar_' . $izin->user->name . '.pdf');
   return view('workstation.izin-keluar-print', ['izin' => $izin]);

}

public function markAsPrinted($uuid)
{
    $izin = IzinKeluar::where('uuid', $uuid)->firstOrFail();

    if (is_null($izin->dicetak_pada)) {
        $izin->update(['dicetak_pada' => now()]);
    }

    return response()->json(['success' => true]);
}

public function markAsPrintedMasuk($uuid)
{
    $izin = IzinMasuk::where('uuid', $uuid)->firstOrFail();

    if (is_null($izin->dicetak_pada)) {
        $izin->update(['dicetak_pada' => now()]);
    }

    return response()->json(['success' => true]);
}
    public function showScanForm()
    {
        return view('workstation.scan');
    }

    public function findIzin(Request $request)
    {
        $request->validate(['uuid' => 'required|uuid']);

        $izin = IzinMasuk::where('uuid', $request->uuid)->first();

        if (!$izin) {
            return back()->with('error', 'Data tidak ditemukan.');
        }

        return view('workstation.result', compact('izin'));
    }

    public function cetak($uuid)
{
    $izin = IzinMasuk::where('uuid', $uuid)->firstOrFail();

    if ($izin->dicetak_pada) {
        return back()->with('error', 'Surat ini sudah pernah dicetak.');
    }

    $izin->update(['dicetak_pada' => now()]);

    $pdf = Pdf::loadView('workstation.surat-izin', compact('izin'));
    return $pdf->download('surat_izin_' . $izin->user->name . '.pdf');
}

}

