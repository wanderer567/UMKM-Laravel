<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil user dengan role pelanggan saja
        $users = User::where('role', 'pelanggan')->get();
        return view('admin.user.index', compact('users'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Validasi dasar
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'hp' => 'required',
            'alamat' => 'required',
        ]);

        // Update semua field sesuai schema tb_users
        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->hp = $request->hp;
        $user->alamat = $request->alamat;
        $user->is_vip = $request->is_vip; // Fitur VIP yang kita tambahkan

        // Update password hanya jika diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return redirect()->back()->with('success', 'Data pelanggan ' . $user->nama . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'Akun pelanggan berhasil dihapus!');
    }

    public function resetPassword($id)
{
    $user = User::findOrFail($id);
    
    // Update password ke default (misal 12345678)
    $user->update([
        'password' => Hash::make('12345678')
    ]);

    return redirect()->back()->with('success', 'Password user ' . $user->username . ' berhasil direset menjadi: 12345678');
}
}