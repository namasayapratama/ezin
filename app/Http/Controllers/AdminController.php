<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\IzinMasuk;
use App\Models\IzinKeluar;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Exports\IzinMasukExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\IzinKeluarExport;


class AdminController extends Controller
{
    public function dashboard()
    {
        $hariIni = Carbon::today();
        $mingguIni = Carbon::now()->startOfWeek();
        $bulanIni = Carbon::now()->startOfMonth();

        return view('admin.dashboard', [
            'masukHariIni' => IzinMasuk::whereDate('waktu_izin', $hariIni)->count(),
            'keluarHariIni' => IzinKeluar::whereDate('waktu_izin', $hariIni)->count(),
            'masukMingguIni' => IzinMasuk::where('waktu_izin', '>=', $mingguIni)->count(),
            'keluarMingguIni' => IzinKeluar::where('waktu_izin', '>=', $mingguIni)->count(),
            'masukBulanIni' => IzinMasuk::where('waktu_izin', '>=', $bulanIni)->count(),
            'keluarBulanIni' => IzinKeluar::where('waktu_izin', '>=', $bulanIni)->count(),
            'izinMasuk' => IzinMasuk::latest()->take(5)->with('user')->get(),
            'izinKeluar' => IzinKeluar::latest()->take(5)->with('user')->get(),
        ]);
    }



public function users(Request $request)
{
    $query = User::with('roles');

    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->filled('role')) {
        $query->whereHas('roles', function ($q) use ($request) {
            $q->where('name', $request->role);
        });
    }

    $users = $query->latest()->paginate(10);
    $roles = \Spatie\Permission\Models\Role::pluck('name');

    return view('admin.users', compact('users', 'roles'));
}



public function createUser()
{
    $roles = Role::pluck('name');
    return view('admin.user-create', compact('roles'));
}

public function storeUser(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role' => 'required|exists:roles,name',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'email_orangtua' => $request->email_orangtua,
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
        'jurusan' => $request->jurusan,
        'no_hp' => $request->no_hp,
        'no_hp_orangtua' => $request->no_hp_orangtua,
    ]);

    $user->assignRole($request->role);

    return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
}

public function editUser(User $user)
{
    $roles = Role::pluck('name');
    return view('admin.user-edit', compact('user', 'roles'));
}

public function updateUser(Request $request, User $user)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'role' => 'required|exists:roles,name',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'email_orangtua' => $request->email_orangtua,
        'nisn' => $request->nisn,
        'kelas' => $request->kelas,
        'jurusan' => $request->jurusan,
        'no_hp' => $request->no_hp,
        'no_hp_orangtua' => $request->no_hp_orangtua,
    ]);

    if ($request->filled('password')) {
        $user->update(['password' => Hash::make($request->password)]);
    }

    $user->syncRoles([$request->role]);

    return redirect()->route('admin.users')->with('success', 'User berhasil diperbarui.');
}

public function destroyUser(User $user)
{
    $user->delete();
    return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
}


   
public function izinMasuk(Request $request)
{
    $query = IzinMasuk::with('user');

    // Default: bulan berjalan
    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end = $request->end_date ?? now()->endOfMonth()->toDateString();

        $query->whereDate('waktu_izin', '>=', $start)
          ->whereDate('waktu_izin', '<=', $end);


    // Filter kelas
    if ($request->kelas) {
        $query->whereHas('user', fn ($q) => $q->where('kelas', $request->kelas));
    }

    // Search nama
    if ($request->search) {
        $query->whereHas('user', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
    }

    $izinMasuk = $query->latest()->paginate(10)->withQueryString();

    // Ambil daftar kelas unik
    $daftarKelas = User::whereHas('roles', fn ($q) => $q->where('name', 'siswa'))
        ->distinct()->pluck('kelas')->filter()->sort()->values();

    return view('admin.izin-masuk', compact('izinMasuk', 'start', 'end', 'daftarKelas'));
}




public function izinKeluar(Request $request)
{
    $izinKeluar = $this->filterIzinKeluar($request); // ✅ Panggil method ini

    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end = $request->end_date ?? now()->endOfMonth()->toDateString();

    $daftarKelas = User::whereHas('roles', fn ($q) => $q->where('name', 'siswa'))
        ->distinct()->pluck('kelas')->filter()->sort()->values();

    return view('admin.izin-keluar', compact('izinKeluar', 'start', 'end', 'daftarKelas'));
}



public function exportIzinMasukExcel(Request $request)
{
    $start = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
    $end = $request->input('end_date') ?? now()->endOfMonth()->toDateString();
    $data = IzinMasuk::with('user')
        ->when($start, fn($q) => $q->whereDate('waktu_izin', '>=', $start))
        ->when($end, fn($q) => $q->whereDate('waktu_izin', '<=', $end))
        ->get();

    $export = new IzinMasukExport($data, $start, $end, setting('school_name'));

    return Excel::download($export, 'rekap_izin_masuk.xlsx');
}

public function exportIzinMasukPdf(Request $request)
{
    $data = $this->filterIzinMasuk($request);
    $pdf = PDF::loadView('admin.exports.izin-masuk-pdf', ['izinMasuk' => $data]);
    return $pdf->download('izin-masuk.pdf');
}

protected function filterIzinMasuk(Request $request)
{
    $query = IzinMasuk::with('user');

    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end = $request->end_date ?? now()->endOfMonth()->toDateString();
    $query->whereBetween('waktu_izin', [$start, $end]);

    if ($request->kelas) {
        $query->whereHas('user', fn ($q) => $q->where('kelas', $request->kelas));
    }

    if ($request->search) {
        $query->whereHas('user', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
    }

    return $query->latest()->get();
}

public function exportIzinKeluarExcel(Request $request)
{
    $start = $request->input('start_date') ?? now()->startOfMonth()->toDateString();
    $end = $request->input('end_date') ?? now()->endOfMonth()->toDateString();
    $data = IzinKeluar::with('user')
        ->when($start, fn($q) => $q->whereDate('waktu_izin', '>=', $start))
        ->when($end, fn($q) => $q->whereDate('waktu_izin', '<=', $end))
        ->get();

    $export = new IzinKeluarExport($data, $start, $end, setting('school_name'));

    return Excel::download($export, 'rekap_izin_keluar.xlsx');
}

public function exportIzinKeluarPdf(Request $request)
{
    $data = $this->filterIzinKeluar($request);
    $pdf = PDF::loadView('admin.exports.izin-keluar-pdf', ['izinKeluar' => $data]);
    return $pdf->download('izin-keluar.pdf');
}

protected function filterIzinKeluar(Request $request)
{
    $query = IzinKeluar::with('user');

    $start = $request->start_date ?? now()->startOfMonth()->toDateString();
    $end = $request->end_date ?? now()->endOfMonth()->toDateString();
    $query->whereDate('waktu_izin', '>=', $start)
          ->whereDate('waktu_izin', '<=', $end);

    if ($request->kelas) {
        $query->whereHas('user', fn ($q) => $q->where('kelas', $request->kelas));
    }

    if ($request->search) {
        $query->whereHas('user', fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'));
    }

    if ($request->has('belum_kembali')) {
        $query->whereNull('kembali_pada');
    }

    return $query->latest()->paginate(10)->withQueryString(); // ✅ gunakan paginate
}

    
 
}
