<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    public function index()
{
    
    $produk = Produk::all(); 
    
    
    return view('admin.produk', compact('produk'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric',
            'poto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle Upload Foto
        $poto = $request->file('poto');
        $nama_poto = time() . "_" . $poto->getClientOriginalName();
        $poto->move(public_path('gambar_produk'), $nama_poto);

        // Simpan ke Database
        Produk::create([
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'poto' => $nama_poto,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Hapus file foto dari folder
        $path = public_path('images/' . $produk->poto);
        if (File::exists($path)) {
            File::delete($path);
        }

        $produk->delete();
        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }

    public function edit($id)
{
    $produk = Produk::findOrFail($id);
    return view('admin.edit_produk', compact('produk'));
}


    public function update(Request $request, $id)
{
    $request->validate([
        'nama' => 'required',
        'harga' => 'required|numeric',
        'stok' => 'required|numeric',
    ]);

    $produk = Produk::findOrFail($id);
    

    $data = [
        'nama' => $request->nama,
        'kategori' => $request->kategori,
        'harga' => $request->harga,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
    ];

    
    if ($request->hasFile('poto')) {
        // Hapus foto lama
        $oldPath = public_path('images/' . $produk->poto);
        if (File::exists($oldPath)) {
            File::delete($oldPath);
        }

       
        $poto = $request->file('poto');
        $nama_poto = time() . "_" . $poto->getClientOriginalName();
        $poto->move(public_path('images'), $nama_poto);
        
        $data['poto'] = $nama_poto;
    }

    $produk->update($data);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}
    public function show($id)
    {
        
        $item = Produk::findOrFail($id);

        return view('produk.show', compact('item'));
    }   
}