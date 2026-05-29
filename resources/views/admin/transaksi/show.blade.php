@extends('layouts.admin')

<style>
    @media print {
        /* Sembunyikan Sidebar, Header, dan Tombol-tombol */
        .btn, 
        header, 
        .sidebar, 
        nav,
        hr {
            display: none !important;
        }

        /* Hilangkan bayangan dan border card agar lebih bersih saat diprint */
        .card {
            border: none !important;
            shadow: none !important;
        }

        /* Atur agar konten memenuhi halaman */
        .container-fluid {
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Opsional: Tambahkan judul "Invoice" jika ingin tampil di kertas saja */
        .print-only-title {
            display: block !important;
            text-align: center;
            margin-bottom: 20px;
        }
    }

    /* Sembunyikan judul cetak saat di layar monitor biasa */
    .print-only-title {
        display: none;
    }
</style>

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary rounded-circle me-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-bold mb-0">Detail Transaksi #TRX-{{ $transaksi->id_transaksi }}</h2>
    </div>

    <div class="row">
        <!-- Info Pelanggan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Informasi Pelanggan</h5>
                    <hr>
                    <p class="mb-1 text-muted small">Nama Lengkap</p>
                    <p class="fw-bold">{{ $transaksi->pelanggan->nama }} 
                        @if($transaksi->pelanggan->is_vip) 
                            <span class="badge bg-warning text-dark ms-1">VIP</span> 
                        @endif
                    </p>
                    
                    <p class="mb-1 text-muted small">WhatsApp / HP</p>
                    <p class="fw-bold">{{ $transaksi->pelanggan->hp }}</p>
                    
                    <p class="mb-1 text-muted small">Alamat Pengiriman</p>
                    <p class="fw-bold">{{ $transaksi->pelanggan->alamat }}</p>
                </div>
            </div>
        </div>

        <!-- Info Pembayaran -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Rincian Pembayaran</h5>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tanggal Transaksi</span>
                        <span class="fw-bold">{{ date('d F Y', strtotime($transaksi->tanggal)) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Status</span>
                        <span class="badge bg-success">Selesai</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <h5 class="mb-0">Total Bayar</h5>
                        <h4 class="text-primary fw-bold mb-0">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</h4>
                    </div>
                    
                    @if($transaksi->pelanggan->is_vip)
                    <div class="mt-2 text-end">
                        <small class="text-success">*Sudah termasuk potongan harga VIP 30%</small>
                    </div>
                    @endif
                </div>
            </div>
            
            <div class="mt-4 text-end">
                <button onclick="window.print()" class="btn btn-light rounded-pill px-4 me-2">
                    <i class="bi bi-printer me-2"></i> Cetak Invoice
                </button>
            </div>
        </div>

        <!-- Tambahkan ini di bawah baris Rincian Pembayaran di show.blade.php -->

<div class="row mt-4">
    <div class="col-12">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-box-seam me-2"></i>Produk yang Dibeli</h5>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Nama Produk</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksi->detail as $item)
                            <tr>
                                <td>{{ $item->produk->nama }}</td>
                                <td>{{ $item->jumlah }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Bagian Pesan Pembeli
                <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-primary">
                    <h6 class="fw-bold mb-2 small text-uppercase text-muted">Pesan dari Pembeli:</h6>
                    <p class="mb-0 italic">"{{ $pesanPembeli ?? 'Tidak ada pesan khusus.' }}"</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bagian Pesan Pembeli di show.blade.php -->
<!-- <div class="mt-4 p-3 bg-light rounded-3 border-start border-4 border-primary">
    <h6 class="fw-bold mb-2 small text-uppercase text-muted">Pesan dari Pembeli:</h6>
    <p class="mb-0">
        @if($transaksi->pesan)
            "{{ $transaksi->pesan }}"
        @else
            <span class="text-muted italic">Tidak ada pesan khusus dari pelanggan.</span>
        @endif
    </p>
</div> --> 
    </div>
</div>
@endsection