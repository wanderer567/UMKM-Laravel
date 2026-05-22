@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    <h3 class="fw-bold mb-4 text-gray-800"><i class="bi bi-cart3 me-2 text-primary"></i>Keranjang Belanja Anda</h3>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                @if($keranjang->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-cart-x display-2 text-muted opacity-50"></i>
                        <h5 class="mt-3 text-muted">Keranjang belanja kamu masih kosong</h5>
                        <p class="text-secondary small">Yuk, cari produk menarik di beranda!</p>
                        <a href="{{ route('home') }}" class="btn btn-custom rounded-pill px-4 mt-2">Mulai Belanja</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table align-middle border-0">
                            <thead>
                                <tr class="text-secondary small text-uppercase border-bottom border-light">
                                    <th scope="col" style="min-width: 250px;">Produk</th>
                                    <th scope="col" class="text-center">Harga</th>
                                    <th scope="col" class="text-center" style="width: 130px;">Jumlah</th>
                                    <th scope="col" class="text-center">Subtotal</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($keranjang as $item)
                                    <tr class="border-bottom border-light-subtle">
                                        <td class="py-3">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('gambar_produk/'.$item->produk->poto) }}" class="rounded-3 object-fit-cover me-3 shadow-sm" style="width: 60px; height: 60px;" alt="">
                                                <div>
                                                    <h6 class="fw-bold mb-0 text-dark text-truncate" style="max-width: 180px;">{{ $item->produk->nama }}</h6>
                                                    <small class="text-muted text-uppercase" style="font-size: 11px;">{{ $item->produk->kategori ?? 'Umum' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center text-secondary">
                                            Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="d-flex align-items-center justify-content-center">
                                                @csrf
                                                @method('PUT')
                                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="form-control form-control-sm rounded-3 text-center me-1" style="width: 60px;" onchange="this.form.submit()">
                                            </form>
                                        </td>
                                        <td class="text-center fw-semibold text-dark">
                                            Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-link text-danger p-0 border-0">
                                                    <i class="bi bi-trash3 fs-5"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('home') }}" class="btn btn-link text-decoration-none text-primary p-0 fw-semibold">
                            <i class="bi bi-arrow-left me-1"></i> Lanjut Cari Barang Lain
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="sumber" value="keranjang">

                    <h5 class="fw-bold mb-4 text-gray-800">Checkout Info</h5>
                    
                    {{-- INPUT DATA TUJUAN TOP UP --}}
                    <div class="mb-4">
                        <label for="data_tujuan" class="form-label small fw-bold text-secondary text-uppercase">ID Game / No. HP / Akun Tujuan</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="bi bi-person-vcard"></i></span>
                            <input type="text" name="data_tujuan" id="data_tujuan" class="form-control bg-light border-start-0 rounded-end-3" placeholder="Contoh: 12847192 (Asia) / 0812..." required {{ $keranjang->isEmpty() ? 'disabled' : '' }}>
                        </div>
                    </div>

                    {{-- METODE PENGIRIMAN DIGITAL --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Metode Pengiriman</label>
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-lightning-charge-fill text-warning fs-4 me-3"></i>
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Pengiriman Instan Online</h6>
                                    <small class="text-muted" style="font-size: 11px;">Proses langsung masuk ke akun anda</small>
                                </div>
                            </div>
                            <span class="badge bg-success-subtle text-success rounded-pill px-2">Gratis</span>
                        </div>
                        <input type="hidden" name="metode_pengiriman" value="online_digital">
                    </div>

                    {{-- OPSI CARA MEMBAYAR --}}
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-secondary text-uppercase">Metode Pembayaran</label>
                        
                        <div class="form-check card-radio p-3 border rounded-3 mb-2 d-flex align-items-center">
                            <input class="form-check-input me-3 ms-0" type="radio" name="metode_pembayaran" id="pay_qris" value="qris" checked {{ $keranjang->isEmpty() ? 'disabled' : '' }}>
                            <label class="form-check-label w-100 d-flex align-items-center justify-content-between" for="pay_qris">
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">QRIS All Payment</h6>
                                    <small class="text-muted" style="font-size: 11px;">Scan otomatis lewat semua e-wallet</small>
                                </div>
                                <i class="bi bi-qr-code-scan fs-4 text-primary"></i>
                            </label>
                        </div>

                        <div class="form-check card-radio p-3 border rounded-3 d-flex align-items-center">
                            <input class="form-check-input me-3 ms-0" type="radio" name="metode_pembayaran" id="pay_dana" value="dana" {{ $keranjang->isEmpty() ? 'disabled' : '' }}>
                            <label class="form-check-label w-100 d-flex align-items-center justify-content-between" for="pay_dana">
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem;">Transfer Aplikasi DANA</h6>
                                    <small class="text-muted" style="font-size: 11px;">Manual transfer ke nomor DANA admin</small>
                                </div>
                                <i class="bi bi-wallet2 fs-4 text-info"></i>
                            </label>
                        </div>
                    </div>

                    <hr class="text-muted opacity-25 my-3">

                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Total Barang:</span>
                        <span class="fw-medium text-dark">{{ $keranjang->sum('jumlah') }} Item</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 text-secondary">
                        <span>Total Belanja:</span>
                        <strong>Rp {{ number_format($totalBelanja + ($diskon ?? 0), 0, ',', '.') }}</strong>
                    </div>

                    @if(auth()->user()->is_vip == 1 && ($diskon ?? 0) > 0)
                        <div class="d-flex justify-content-between mb-2 text-success fw-semibold" style="font-size: 0.95rem;">
                            <span><i class="bi bi-crown-fill me-1 text-warning"></i> Diskon Member VIP (30%)</span>
                            <span>- Rp {{ number_format($diskon, 0, ',', '.') }}</span>
                        </div>
                    @endif

                    <hr class="text-muted opacity-25 my-3">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="fw-bold text-dark">Total Bayar</span>
                        <h4 class="fw-bold text-primary mb-0">Rp {{ number_format($totalBelanja, 0, ',', '.') }}</h4>
                    </div>

                    <button type="submit" class="btn btn-custom w-100 btn-lg rounded-pill fs-6 py-2 shadow-sm {{ $keranjang->isEmpty() ? 'disabled' : '' }}">
                        <i class="bi bi-credit-card-2-back me-2"></i> Buat Pesanan Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .card-radio {
        transition: all 0.2s;
        cursor: pointer;
    }
    .card-radio:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd!important;
    }
    .form-check-input:checked + .form-check-label {
        color: #0d6efd;
    }
</style>
@endsection