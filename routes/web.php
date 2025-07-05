<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IzinMasukController;
use App\Http\Controllers\IzinKeluarController;
use App\Http\Controllers\WorkstationController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImportUserController;
use App\Http\Controllers\AdminSettingController;
use App\Models\IzinMasuk;
use App\Models\IzinKeluar;
use App\Http\Controllers\ProfileController;
use App\Helpers\WhatsappHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\IzinKembaliNotification;

Route::get('/', fn () => view('landing'));

Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->hasRole('siswa')) {
        return redirect()->route('siswa.dashboard');
    } elseif ($user->hasRole('guru')) {
        return redirect()->route('guru.dashboard');
    } elseif ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('workstation')) {
        return redirect()->route('workstation.dashboard');
    }

    abort(403);
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:siswa'])->group(function () {
    //Route::get('/siswa/dashboard', fn () => view('siswa.dashboard'))->name('siswa.dashboard');
Route::get('/siswa/dashboard', function () {
    $user = Auth::user();
    $start = now()->startOfMonth();
    $end = now()->endOfMonth();

    $masukBulanIni = \App\Models\IzinMasuk::where('user_id', $user->id)
        ->whereBetween('waktu_izin', [$start, $end])
        ->count();

    $keluarBulanIni = \App\Models\IzinKeluar::where('user_id', $user->id)
        ->whereBetween('waktu_izin', [$start, $end])
        ->count();

    $riwayatMasuk = \App\Models\IzinMasuk::where('user_id', $user->id)
        ->latest('waktu_izin')->take(5)->get();

    $riwayatKeluar = \App\Models\IzinKeluar::where('user_id', $user->id)
        ->latest('waktu_izin')->take(5)->get();

    return view('siswa.dashboard', compact(
        'masukBulanIni',
        'keluarBulanIni',
        'riwayatMasuk',
        'riwayatKeluar'
    ));
})->name('siswa.dashboard');




    Route::get('/siswa/izin-masuk', [IzinMasukController::class, 'create'])->name('siswa.izin-masuk.form');
    Route::post('/siswa/izin-masuk', [IzinMasukController::class, 'store'])->name('siswa.izin-masuk.store');
    Route::get('/siswa/izin-keluar', [IzinKeluarController::class, 'create'])->name('siswa.izin-keluar.form');
    Route::post('/siswa/izin-keluar', [IzinKeluarController::class, 'store'])->name('siswa.izin-keluar.store');
    Route::get('/siswa/riwayat/izin-masuk', [IzinMasukController::class, 'riwayat'])->name('siswa.izin-masuk.riwayat');
    Route::get('/siswa/riwayat/izin-keluar', [IzinKeluarController::class, 'riwayat'])->name('siswa.izin-keluar.riwayat');
});

Route::middleware(['auth', 'role:guru'])->group(function () {
    //Route::get('/guru/dashboard', fn () => view('guru.dashboard'))->name('guru.dashboard');
Route::middleware(['auth', 'role:guru'])->get('/guru/dashboard', function () {
    $today = now()->toDateString();

    $masukHariIni = IzinMasuk::whereDate('waktu_izin', $today)->count();
    $keluarHariIni = IzinKeluar::whereDate('waktu_izin', $today)->count();

    $belumKembaliHariIni = IzinKeluar::with('user')
        ->whereDate('waktu_izin', $today)
        ->whereNull('kembali_pada')
        ->latest('waktu_izin')
        ->get();

    return view('guru.dashboard', compact('masukHariIni', 'keluarHariIni', 'belumKembaliHariIni'));
})->name('guru.dashboard');




    Route::get('/guru/scan-kembali', [GuruController::class, 'scanForm'])->name('guru.scan.form');
    Route::post('/guru/scan-kembali', [GuruController::class, 'validasiKembali'])->name('guru.scan.submit');
});

Route::middleware(['auth', 'role:workstation'])->group(function () {
    //Route::get('/workstation/dashboard', fn () => view('workstation.dashboard'))->name('workstation.dashboard');
    Route::middleware(['auth', 'role:workstation'])->get('/workstation/dashboard', function () {
    $today = now()->toDateString();

    $masukHariIni = IzinMasuk::whereDate('waktu_izin', $today)->count();
    $keluarHariIni = IzinKeluar::whereDate('waktu_izin', $today)->count();

    $recentMasuk = IzinMasuk::with('user')
        ->whereDate('waktu_izin', $today)
        ->latest('waktu_izin')
        ->take(10)
        ->get();

    $recentKeluar = IzinKeluar::with('user')
        ->whereDate('waktu_izin', $today)
        ->latest('waktu_izin')
        ->take(10)
        ->get();

    return view('workstation.dashboard', compact(
        'masukHariIni',
        'keluarHariIni',
        'recentMasuk',
        'recentKeluar'
    ));
})->name('workstation.dashboard');
    //end route dashboard
    Route::get('/workstation/scan', [WorkstationController::class, 'showScanForm'])->name('workstation.scan');
    Route::post('/workstation/scan', [WorkstationController::class, 'findIzin'])->name('workstation.scan.submit');
    Route::get('/workstation/izin/{uuid}/cetak', [WorkstationController::class, 'cetak'])->name('workstation.izin.cetak');
    Route::get('/workstation/scan-keluar', [WorkstationController::class, 'scanIzinKeluarForm'])->name('workstation.keluar.scan.form');
    Route::post('/workstation/scan-keluar', [WorkstationController::class, 'scanIzinKeluar'])->name('workstation.keluar.scan');
    Route::get('/workstation/izin-keluar/{uuid}/cetak', [WorkstationController::class, 'cetakIzinKeluar'])->name('workstation.keluar.cetak');
});


Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/settings', [AdminSettingController::class, 'edit'])->name('admin.settings.edit');
    Route::post('/admin/settings', [AdminSettingController::class, 'update'])->name('admin.settings.update');
});




Route::middleware(['auth'])->group(function () {
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password.edit');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/izin-masuk', [AdminController::class, 'izinMasuk'])->name('admin.izin-masuk');
    Route::get('/izin-keluar', [AdminController::class, 'izinKeluar'])->name('admin.izin-keluar');
   

    Route::get('/import', [ImportUserController::class, 'form'])->name('admin.import.form');
    Route::post('/import', [ImportUserController::class, 'import'])->name('admin.import');
    Route::get('/template-download', [ImportUserController::class, 'downloadTemplate'])->name('admin.template.download');

    Route::get('/export', [AdminController::class, 'export'])->name('admin.export');
    Route::get('/export/mingguan', [AdminController::class, 'exportMingguan'])->name('admin.export.mingguan');
    Route::get('/export/bulanan', [AdminController::class, 'exportBulanan'])->name('admin.export.bulanan');
    Route::get('/export/csv', [AdminController::class, 'exportCSV'])->name('admin.export.csv');
    Route::get('/export/csv/filter', [AdminController::class, 'exportCSVWithFilter'])->name('admin.export.csv.filter');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/izin-masuk', [AdminController::class, 'izinMasuk'])->name('admin.izin-masuk');
    Route::get('/admin/izin-masuk/export/excel', [AdminController::class, 'exportIzinMasukExcel'])->name('admin.izin-masuk.export.excel');
    Route::get('/admin/izin-masuk/export/pdf', [AdminController::class, 'exportIzinMasukPdf'])->name('admin.izin-masuk.export.pdf');
     Route::get('/admin/izin-keluar/export/excel', [AdminController::class, 'exportIzinKeluarExcel'])->name('admin.izin-keluar.export.excel');
    Route::get('/admin/izin-keluar/export/pdf', [AdminController::class, 'exportIzinKeluarPdf'])->name('admin.izin-keluar.export.pdf');

});

Route::middleware(['auth', 'role:guru'])->post('/guru/izin-kembali/{id}', function ($id) {
    $izin = \App\Models\IzinKeluar::findOrFail($id);
    $izin->kembali_pada = now();
    $izin->save();
    WhatsappHelper::send($izin->user->no_hp_orangtua, "Siswa a.n ".$izin->user->name." telah kembali dari Izin Keluar pada: ".$izin->kembali_pada);

        // Kirim email ke siswa
Mail::to($izin->user->email)->send(new IzinKembaliNotification($izin));

// Kirim ke orang tua jika tersedia
if ($izin->user->email_orangtua) {
    Mail::to($izin->user->email_orangtua)->send(new IzinKembaliNotification($izin));
}
    return back()->with('success', 'Siswa telah ditandai kembali.');
})->name('guru.izin-kembali');


Route::post('/izin-keluar/{uuid}/mark-printed', [WorkstationController::class, 'markAsPrinted'])
    ->name('izin-keluar.mark-printed');
Route::post('/izin-masuk/{uuid}/mark-printed-masuk', [WorkstationController::class, 'markAsPrintedMasuk'])
    ->name('izin-masuk.mark-printed');
    
Route::get('/test-wa', [\App\Http\Controllers\TestWAController::class, 'test']);

require __DIR__.'/auth.php';
