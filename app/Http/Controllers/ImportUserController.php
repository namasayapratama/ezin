<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use Illuminate\Support\Facades\Storage;

class ImportUserController extends Controller
{
    public function form()
    {
        return view('admin.import-users');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new UsersImport, $request->file('file'));

        return back()->with('success', 'Data berhasil diimpor.');
    }

    public function downloadTemplate()
    {
        return Storage::download('templates/template-users.xlsx');
    }
}
