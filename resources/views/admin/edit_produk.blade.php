@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('produk.index') }}" class="btn btn-light rounded-pill mb-3">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
        <h2 class="fw-bold">Edit Produk: {{ $produk->nama }}</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            @method('PUT')
            
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Nama Produk</label>
                    <input type="text" name="nama" class="form-control rounded-3" value="{{ $produk->nama }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Kategori</label>
                    <select name="kategori" class="form-select rounded-3">
                        <option value="Genshin Impact" {{ $produk->kategori == 'Genshin Impact' ? 'selected' : '' }}>Genshin Impact</option>
                        <option value="Honkai Star Rail" {{ $produk->kategori == 'Honkai Star Rail' ? 'selected' : '' }}>Honkai Star Rail</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Harga</label>
                    <input type="number" name="harga" class="form-control rounded-3" value="{{ $produk->harga }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">Stok</label>
                    <input type="number" name="stok" class="form-control rounded-3" value="{{ $produk->stok }}" required>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold d-block">Foto Produk Saat Ini</label>
                    <img src="{{ asset('gambar_produk/'.$produk->poto) }}" width="150" class="rounded-3 mb-2 border">
                    <input type="file" name="poto" class="form-control rounded-3">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengganti foto.</small>
                </div>
                <div class="col-12">
                    <label class="form-label fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control rounded-3" rows="5">{{ $produk->deskripsi }}</textarea>
                </div>
                <div class="col-12 text-end mt-4">
                    <button type="submit" class="btn btn-primary rounded-pill px-5">Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection