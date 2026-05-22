@extends('layouts.pelanggan')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between mb-4 d-print-none">
        <a href="{{ route('home') }}" class="btn btn-light rounded-pill px-3">
            <i class="bi bi-house-door me-1"></i> Kembali ke Beranda
        </a>
        <button onclick="window.print()" class="btn btn-dark rounded-pill px-4">
            <i class="bi bi-printer me-2"></i> Cetak Invoice
        </button>
    </div>

    <div class="card shadow-sm border-0 rounded-4 p-4 p-lg-5 bg-white">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h5 class="text-muted text-uppercase mb-1">Invoice</h5>
                <h3 class="fw-bold text-primary">#INV-{{ $transaksi->id_transaksi }}-{{ date('Ymd', strtotime($transaksi->tanggal)) }}</h3>
            </div>
            <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                <h5 class="fw-bold text-dark mb-1">Status Pembayaran:</h5>
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                    Menunggu Pembayaran ({{ strtoupper($transaksi->metode_pembayaran) }})
                </span>
            </div>
        </div>

        <hr class="text-muted opacity-25 my-4">

        <div class="row mb-4">
            <div class="col-sm-6">
                <h6 class="text-muted mb-2">Diterbitkan Untuk:</h6>
                <p class="fw-bold text-dark mb-0">{{ $transaksi->pelanggan->name }}</p>
                <p class="text-secondary small mb-0">{{ $transaksi->pelanggan->email }}</p>
            </div>
            <div class="col-sm-6 text-sm-end mt-3 mt-sm-0">
                <h6 class="text-muted mb-2">Informasi Pengiriman:</h6>
                <p class="fw-bold text-danger mb-0">Akun Tujuan: {{ $transaksi->data_tujuan ?? '-' }}</p>
                <p class="text-secondary small mb-0">Metode: {{ $transaksi->metode_pengiriman ?? 'Online (Digital)' }}</p>
                <p class="text-muted small">Tanggal Transaksi: {{ date('d F Y', strtotime($transaksi->tanggal)) }}</p>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr class="table-light text-secondary small text-uppercase">
                        <th>Nama Produk</th>
                        <th class="text-center">Harga Satuan</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transaksi->detail as $item)
                        <tr>
                            <td>
                                <span class="fw-bold text-dark d-block">{{ $item->produk->nama }}</span>
                                <small class="text-muted">{{ $item->produk->kategori ?? 'Umum' }}</small>
                            </td>
                            <td class="text-center text-secondary">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                            <td class="text-center text-secondary">{{ $item->jumlah }}</td>
                            <td class="text-end fw-semibold text-dark">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                    <tr class="border-0">
                        <td colspan="2" class="border-0"></td>
                        <td class="text-center fw-bold border-0 py-3">Total Tagihan:</td>
                        <td class="text-end fw-bold text-success border-0 py-3 fs-5">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if($transaksi->pesan)
            <div class="alert alert-light border-0 rounded-3 p-3 mb-4">
                <h6 class="fw-bold text-dark mb-1"><i class="bi bi-chat-left-text me-2"></i>Catatan Pembeli:</h6>
                <p class="text-secondary small mb-0">{{ $transaksi->pesan }}</p>
            </div>
        @endif

        {{-- LOGIKA PERCABANGAN TAMPILAN PEMBAYARAN --}}
        @if($transaksi->metode_pembayaran === 'dana')
            <div class="row align-items-center bg-info-subtle rounded-4 p-4 mt-4 border border-info-subtle">
                <div class="col-md-3 text-center mb-3 mb-md-0">
                    <i class="bi bi-wallet2 text-info" style="font-size: 5rem;"></i>
                </div>
                <div class="col-md-9">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-box-arrow-in-right me-2 text-info"></i>Instruksi Pembayaran DANA</h5>
                    <p class="text-secondary small mb-3">Silakan lakukan transfer manual ke nomor akun DANA admin berikut:</p>
                    
                    <div class="d-inline-block border border-2 border-info border-dashed p-2 px-4 rounded-3 bg-white mb-3">
                        <span class="small text-muted d-block text-uppercase fw-semibold" style="font-size: 10px;">Nomor DANA Admin:</span>
                        <h4 class="fw-bold text-dark mb-0 letter-spacing-1">081460367229</h4>
                    </div>

                    <p class="text-danger small fw-semibold mb-0"><i class="bi bi-exclamation-triangle me-1"></i> Pastikan jumlah transfer tepat sebesar <span class="fs-6 text-dark fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></p>
                    <small class="text-muted d-block mt-2"><i class="bi bi-info-circle me-1"></i> Setelah sukses transfer, simpan bukti pembayaran lalu konfirmasi ke admin agar proses top-up segera dikirim.</small>
                </div>
            </div>
        @else
            <div class="row align-items-center bg-light rounded-4 p-4 mt-4 border border-light-subtle">
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <img src="{{ asset('assets/qris.jpeg') }}" class="img-fluid rounded-3 shadow-sm border bg-white p-2" style="max-width: 200px;" alt="QRIS Payment">
                </div>
                <div class="col-md-8">
                    <h5 class="fw-bold text-dark mb-2"><i class="bi bi-qr-code-scan me-2 text-primary"></i>Metode Pembayaran QRIS</h5>
                    <p class="text-secondary small mb-2">Silakan scan kode QRIS di samping menggunakan aplikasi m-Banking (BCA, Mandiri, BRI) atau E-Wallet (Gopay, OVO, Dana, LinkAja) Anda.</p>
                    <p class="text-danger small fw-semibold mb-0"><i class="bi bi-exclamation-triangle me-1"></i> Pastikan nominal transfer pas sebesar <span class="fs-6 text-dark fw-bold">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span></p>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
.letter-spacing-1 {
    letter-spacing: 1px;
}
@media print {
    body {
        background-color: #fff;
    }
    .d-print-none {
        display: none !important;
    }
    .card {
        box-shadow: none !important;
        padding: 0 !important;
    }
}
</style>
@endsection