@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('home') }}" class="btn btn-light btn-sm rounded-pill px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-5 bg-light d-flex align-items-center justify-content-center">
                <img src="{{ asset('gambar_produk/'.$item->poto) }}" class="img-fluid w-100 object-fit-cover" style="max-height: 450px;" alt="{{ $item->nama }}">
            </div>

            <div class="col-md-7">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-primary-subtle text-primary rounded-pill mb-2 px-3 py-2 text-uppercase fs-7 fw-semibold">
                        {{ $item->kategori ?? 'Umum' }}
                    </span>
                    
                    <h2 class="fw-bold mb-2 text-gray-800">{{ $item->nama }}</h2>
                    
                    <h3 class="text-success fw-bold mb-4">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </h3>

                    <hr class="text-muted opacity-25 mb-4">

                    <h5 class="fw-bold mb-2">Deskripsi Produk</h5>
                    <p class="text-secondary lh-lg mb-4">
                        {{ $item->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                    </p>

                    <div class="mt-5">
    <div class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label for="jumlah" class="col-form-label fw-semibold">Jumlah Beli:</label>
        </div>
        <div class="col-auto" style="width: 100px;">
            <input type="number" id="jumlah_input" class="form-control rounded-3" value="1" min="1" required 
                   oninput="document.querySelectorAll('.jumlah-hidden').forEach(el => el.value = this.value)">
        </div>
    </div>

    <div class="d-flex flex-wrap gap-3">
        <form action="{{ route('keranjang.tambah') }}" method="POST">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $item->id }}">
            <input type="hidden" name="jumlah" class="jumlah-hidden" value="1">
            
            <button type="submit" class="btn btn-outline-primary btn-lg rounded-pill px-4 py-2 fs-6 shadow-sm border-2">
                <i class="bi bi-cart-plus me-2"></i> Masukkan Keranjang
            </button>
        </form>

        <form action="{{ route('checkout.store') }}" method="POST">
    @csrf
    <input type="hidden" name="produk_id" value="{{ $item->id }}">
    <input type="hidden" name="jumlah" class="jumlah-hidden" value="1">
    
    <button type="submit" class="btn btn-custom btn-lg rounded-pill px-4 py-2 fs-6 shadow-sm">
        <i class="bi bi-wallet2 me-2"></i> Lanjutkan Pembayaran
    </button>
</form>
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection