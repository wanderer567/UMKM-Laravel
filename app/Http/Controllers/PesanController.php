<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Balasan;
use Illuminate\Http\Request;

class PesanController extends Controller
{
    public function index()
    {
        
        $semuaPesan = Pesan::with('pelanggan')->orderBy('created_at', 'desc')->get();
        
        return view('admin.pesan.index', compact('semuaPesan'));
    }

    public function show($id)
    {
        $pesan = Pesan::with('pelanggan')->findOrFail($id);
        
        // Jika admin membuka pesan, ubah status jadi 'read' otomatis
        if($pesan->status == 'unread') {
            $pesan->update(['status' => 'read']);
        }

        return view('admin.pesan.show', compact('pesan'));
    }

    public function destroy($id)
    {
        $pesan = Pesan::findOrFail($id);
        $pesan->delete();

        return redirect()->route('pesan.index')->with('success', 'Pesan berhasil dihapus.');
    }

    public function balasPesan(Request $request, $id)
{
    $request->validate(['pesan_balasan' => 'required']);

    \App\Models\Balasan::create([
        'id_pesan' => $id,
        'pesan_balasan' => $request->pesan_balasan,
        'pengirim' => 'admin'
    ]);

    // Update status pesan utama menjadi 'replied'
    \App\Models\Pesan::where('id_pesan', $id)->update(['status' => 'replied']);

    return back()->with('success', 'Balasan terkirim!');
}
}
