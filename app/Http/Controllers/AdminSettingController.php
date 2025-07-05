<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingController extends Controller
{
    public function edit()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.edit')->with('success', 'Pengaturan berhasil disimpan.');
    }
}
