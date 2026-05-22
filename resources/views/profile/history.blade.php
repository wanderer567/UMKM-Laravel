@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-print-none" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-print-none" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <div class="col-lg-3 d-print-none">
            <div class="card shadow-sm border-0 rounded-4 p-3 bg-white">
                <div class="text-center my-3">
                    <div class="d-inline-block p-2 bg-light rounded-circle mb-3">
                        <i class="bi bi-person-circle display-4 text-primary"></i>
                    </div>
                    
                    <h6 class="fw-bold text-dark mb-1 d-flex align-items-center justify-content-center gap-1">
                        {{ Auth::user()->nama }}
                        @if(Auth::user()->is_vip == 1)
                            <span class="badge bg-warning text-dark border border-warning-subtle rounded-pill shadow-sm" style="font-size: 9px; padding: 3px 6px;" data-bs-toggle="tooltip" title="Kamu mendapat diskon 30% untuk semua produk!">
                                <i class="bi bi-crown-fill text-danger"></i> VIP
                            </span>
                        @endif
                    </h6>
                    
                    <small class="text-muted">@<span>{{ Auth::user()->username ?? 'username' }}</span></small>
                </div>
                
                <hr class="text-muted opacity-25 my-3">
                
                <div class="nav flex-column nav-pills gap-1">
                    <a href="{{ route('profile.edit') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('profile.edit') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-person-gear me-2"></i> Pengaturan Akun
                    </a>
                    <a href="{{ route('transaksi.history') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('transaksi.history') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-bag-check me-2"></i> Riwayat Transaksi
                    </a>
                    <a href="{{ route('cs.index') }}" class="nav-link rounded-3 fw-semibold {{ request()->routeIs('cs.*') ? 'active bg-primary text-white' : 'text-secondary bg-light-subtle' }}">
                        <i class="bi bi-headset me-2"></i> Customer Service
                    </a>
                    <a href="{{ route('home') }}" class="nav-link rounded-3 fw-semibold text-secondary">
                        <i class="bi bi-arrow-left-circle me-2"></i> Kembali Belanja
                    </a>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card shadow-sm border-0 rounded-4 p-4 bg-white">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-clock-history me-2 text-primary"></i>Riwayat Transaksi Belanja</h5>
                    <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 d-print-none shadow-sm">
                        <i class="bi bi-printer me-2"></i> Cetak Dokumen
                    </button>
                </div>

                @if($transaksi->isEmpty())
                    <div class="text-center py-5">
                        <div class="d-inline-block p-3 bg-light rounded-circle mb-3">
                            <i class="bi bi-bag-x display-4 text-muted"></i>
                        </div>
                        <h5 class="fw-bold text-secondary">Belum ada transaksi</h5>
                        <p class="text-muted small">Kamu belum pernah melakukan pembelian produk di toko kami.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 btn-sm mt-2 shadow-sm">Mulai Belanja</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 px-3" style="width: 8%;">No.</th>
                                    <th class="py-3">Tanggal</th>
                                    <th class="py-3" style="width: 45%;">Daftar Produk</th>
                                    <th class="py-3">Total Belanja</th>
                                    <th class="py-3 text-center d-print-none">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaksi as $index => $item)
                                    <tr>
                                        <td class="fw-bold px-3">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                                            <small class="text-muted">ID: #TRX-{{ $item->id_transaksi }}</small>
                                        </td>
                                        <td>
                                            <ul class="list-unstyled mb-0 bg-light p-2 rounded-3" style="font-size: 0.85rem;">
                                                @foreach($item->detail as $detail)
                                                    <li class="text-secondary d-flex justify-content-between align-items-center mb-1 pb-1 border-bottom border-white">
                                                        <span>
                                                            <i class="bi bi-check2-circle text-success me-1"></i>
                                                            {{ $detail->produk->nama ?? 'Produk Dihapus' }} 
                                                            <strong class="text-dark">x{{ $detail->jumlah }}</strong>
                                                        </span>
                                                        
                                                        @if(isset($detail->produk->id))
                                                            <button type="button" 
                                                                    class="btn btn-link text-warning p-0 ms-2 text-decoration-none d-print-none small btn-ulas" 
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#modalUlasan" 
                                                                    data-id="{{ $detail->produk->id }}" 
                                                                    data-nama="{{ $detail->produk->nama }}">
                                                                <i class="bi bi-star-fill me-1"></i>Beri Ulasan
                                                            </button>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-primary">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="text-center d-print-none">
                                            <a href="{{ route('transaksi.invoice', $item->id_transaksi) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 shadow-sm" target="_blank">
                                                <i class="bi bi-file-earmark-text me-1"></i> Invoice
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<div class="modal fade d-print-none" id="modalUlasan" tabindex="-1" aria-labelledby="modalUlasanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-light bg-light rounded-top-4">
                <h5 class="modal-title fw-bold text-dark" id="modalUlasanLabel"><i class="bi bi-chat-heart text-primary me-2"></i>Beri Ulasan Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('ulasan.storePelanggan') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <input type="hidden" name="id_produk" id="modal_id_produk">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-1">Produk Yang Diulas</label>
                        <input type="text" id="modal_nama_produk" class="form-control bg-light border-0 fw-bold text-dark rounded-3" readonly>
                    </div>

                    <div class="mb-3 text-center">
                        <label class="form-label d-block text-secondary small fw-medium mb-2">Berikan Rating Bintang</label>
                        <div class="star-rating fs-3 text-muted d-inline-flex flex-row-reverse justify-content-center">
                            <input type="radio" name="rating" id="star5" value="5" class="d-none" required /><label for="star5" class="bi bi-star mx-1 cursor-pointer"></label>
                            <input type="radio" name="rating" id="star4" value="4" class="d-none" /><label for="star4" class="bi bi-star mx-1 cursor-pointer"></label>
                            <input type="radio" name="rating" id="star3" value="3" class="d-none" /><label for="star3" class="bi bi-star mx-1 cursor-pointer"></label>
                            <input type="radio" name="rating" id="star2" value="2" class="d-none" /><label for="star2" class="bi bi-star mx-1 cursor-pointer"></label>
                            <input type="radio" name="rating" id="star1" value="1" class="d-none" /><label for="star1" class="bi bi-star mx-1 cursor-pointer"></label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="komentar" class="form-label text-secondary small fw-medium mb-1">Tulis Komentar / Ulasan Anda</label>
                        <textarea class="form-control rounded-3" name="komentar" id="komentar" rows="4" placeholder="Ceritakan pengalaman kamu menggunakan produk HOYOHOYO ini..." required minlength="5"></textarea>
                    </div>
                </div>
                <div class="modal-footer border-light p-3 bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 btn-sm shadow-sm"><i class="bi bi-send me-1"></i> Kirim Ulasan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Logika menyuntikkan data produk secara otomatis ke dalam pop-up modal
        const tombolUlas = document.querySelectorAll('.btn-ulas');
        tombolUlas.forEach(button => {
            button.addEventListener('click', function() {
                const idProduk = this.getAttribute('data-id');
                const namaProduk = this.getAttribute('data-nama');
                
                document.getElementById('modal_id_produk').value = idProduk;
                document.getElementById('modal_nama_produk').value = namaProduk;
            });
        });
    });
</script>

<style>
/* Style Kustom Efek Hover Klik Bintang Rating */
.star-rating label {
    cursor: pointer;
    transition: color 0.2s ease-in-out;
}
.star-rating label:before {
    content: "\f586"; /* Icon bintang kosong bootstrap */
    font-family: "bootstrap-icons";
}
.star-rating input:checked ~ label:before,
.star-rating label:hover ~ label:before,
.star-rating label:hover:before {
    content: "\f588" !important; /* Icon bintang penuh bootstrap */
    color: #ffc107 !important;
}

@media print {
    body {
        background-color: #fff !important;
        background: #fff !important;
    }
    .col-lg-9 {
        width: 100% !important;
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .d-print-none {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection