<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function editPassword()
    {
        return view('profile.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
    /** @var \App\Models\User $user */
  
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diperbarui.');
    }
}
