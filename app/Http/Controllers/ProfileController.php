<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil user
     */
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update data profil user
     */
    public function update(Request $request)
    {
        $user = \App\Models\User::findOrFail(Auth::id());

        $user->update($request->only([
            'name',
            'tempat_lahir',
            'tanggal_lahir',
            'jenis_kelamin',
            'no_hp',
            'alamat',
        ]));

        return back()->with('success', 'Profil berhasil diperbarui');
    }



    /**
     * Hapus akun user
     */
    public function destroy(Request $request)
    {
        $user = \App\Models\User::findOrFail(Auth::id());

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Akun berhasil dihapus');
    }
}
