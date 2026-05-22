<?php

namespace App\Http\Controllers;

use App\Models\Pesan;
use App\Models\Balasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelangganPesanController extends Controller
{
    // Tampilan awal: Daftar tiket bantuan yang pernah dibuat pelanggan
    public function index()
    {
        $pesanSaya = Pesan::where('id_pelanggan', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.cs_index', compact('pesanSaya'));
    }

    // Proses kirim tiket pesan bantuan baru ke Admin
    public function store(Request $request)
    {
        $request->validate([
            'subjek' => 'required|string|max:255',
            'tipe' => 'required|in:error,tanya,saran',
            'isi_pesan' => 'required|string',
        ]);

        Pesan::create([
            'id_pelanggan' => Auth::id(),
            'subjek' => $request->subjek,
            'tipe' => $request->tipe,
            'isi_pesan' => $request->isi_pesan,
            'status' => 'unread'
        ]);

        return redirect()->route('cs.index')->with('success', 'Pesan bantuan kamu berhasil dikirim ke Admin!');
    }

    // Melihat isi detail pesan beserta balasan dari Admin
    public function show($id)
    {
        // Memastikan pesan yang dibuka memang benar milik pelanggan yang sedang login
        $pesan = Pesan::where('id_pesan', $id)
            ->where('id_pelanggan', Auth::id())
            ->firstOrFail();

        // Mengambil semua balasan dari admin terkait pesan ini
        $balasan = Balasan::where('id_pesan', $id)->orderBy('created_at', 'asc')->get();

        return view('profile.cs_show', compact('pesan', 'balasan'));
    }
}