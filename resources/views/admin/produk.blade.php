@extends('layouts.admin')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold">Manajemen Produk</h2>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-2"></i> Tambah Produk
    </button>
</div>

{{-- Alert bawaan kita hapus, ganti dengan SweetAlert di bawah --}}

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $item)
                <tr>
                    <td class="ps-4">
                        <img src="{{ asset('gambar_produk/'.$item->poto) }}" width="50" height="50" class="rounded-3" style="object-fit: cover;">
                    </td>
                    <td class="fw-bold">{{ $item->nama }}</td>
                    <td><span class="badge bg-info bg-opacity-10 text-info">{{ $item->kategori }}</span></td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ $item->stok }} unit</td>
                    <td class="text-center">
                        <a href="{{ route('produk.edit', $item->id) }}" class="btn btn-sm btn-outline-warning rounded-pill me-1">
                            <i class="bi bi-pencil-square"></i>
                        </a>

                        {{-- Tombol Hapus dengan SweetAlert --}}
                        <form id="delete-form-{{ $item->id }}" action="{{ route('produk.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-outline-danger rounded-pill" onclick="confirmDeleteProduk('{{ $item->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">Data produk masih kosong.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH PRODUK (Tetap Sama) --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    {{-- ... isi modal tambah ... --}}
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header border-0 bg-primary text-white rounded-top-4">
                <h5 class="modal-title fw-bold">Tambah Produk Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Produk</label>
                            <input type="text" name="nama" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori</label>
                            <select name="kategori" class="form-select rounded-3">
                                <option value="Genshin Impact">Genshin Impact</option>
                                <option value="Honkai Star Rail">Honkai Star Rail</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Harga</label>
                            <input type="number" name="harga" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control rounded-3" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Foto Produk</label>
                            <input type="file" name="poto" class="form-control rounded-3" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control rounded-3" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SWEETALERT --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Fungsi Konfirmasi Hapus Produk
    function confirmDeleteProduk(id) {
        Swal.fire({
            title: 'Hapus Produk?',
            text: "Produk ini akan hilang dari daftar selamanya!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    // Alert Sukses Otomatis
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>

@endsection