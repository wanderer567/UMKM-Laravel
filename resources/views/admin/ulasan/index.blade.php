@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="fw-bold">Ulasan Pelanggan</h4>
            <p class="text-muted">Apa yang mereka katakan tentang produk Anda.</p>
        </div>
        {{-- Fitur Filter Cepat --}}
        <div class="col-md-4 text-md-end">
            <div class="dropdown">
                <button class="btn btn-white shadow-sm dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                    <i class="bi bi-filter me-2"></i>Filter Bintang
                </button>
                <ul class="dropdown-menu shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('ulasan.index') }}">Semua Rating</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="{{ route('ulasan.filter', 5) }}">⭐ 5 Bintang</a></li>
                    <li><a class="dropdown-item" href="{{ route('ulasan.filter', 4) }}">⭐ 4 Bintang</a></li>
                    <li><a class="dropdown-item" href="{{ route('ulasan.filter', 3) }}">⭐ 3 Bintang</a></li>
                    <li><a class="dropdown-item" href="{{ route('ulasan.filter', 2) }}">⭐ 2 Bintang</a></li>
                    <li><a class="dropdown-item" href="{{ route('ulasan.filter', 1) }}">⭐ 1 Bintang</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($ulasan as $u)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    {{-- Header Card --}}
                    <div class="d-flex align-items-center mb-3">
                        {{-- Memastikan data produk dan fotonya tersedia --}}
                        {{-- CATATAN: Ganti 'poto' di bawah ke 'foto' jika nama kolom database kamu adalah foto --}}
                        @if($u->produk && $u->produk->poto && file_exists(public_path('storage/produk/' . $u->produk->poto)))
                            <img src="{{ asset('storage/produk/' . $u->produk->poto) }}" 
                                 class="rounded-3 me-3" 
                                 style="width: 55px; height: 55px; object-fit: cover;" 
                                 alt="Produk">
                        @else
                            <div class="bg-light border text-secondary rounded-3 me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px;">
                                <i class="bi bi-box fs-4 text-primary"></i>
                            </div>
                        @endif

                        <div>
                            <h6 class="fw-bold mb-0">{{ $u->pelanggan->nama ?? 'User Terhapus' }}</h6>
                            <small class="text-muted">{{ $u->created_at->diffForHumans() }}</small>
                        </div>
                    </div>

                    {{-- Informasi Nama Produk --}}
                    <div class="mb-3">
                        <span class="badge bg-light text-dark fw-normal border px-2 py-1.5 rounded-3">
                            <i class="bi bi-bag me-1 text-primary"></i> {{ $u->produk->nama ?? 'Produk Tidak Ditemukan' }}
                        </span>
                    </div>

                    {{-- Rating Bintang --}}
                    <div class="mb-3">
                        @php $rating = $u->rating; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $rating)
                                <i class="bi bi-star-fill text-warning"></i>
                            @elseif($i - 0.5 <= $rating)
                                <i class="bi bi-star-half text-warning"></i>
                            @else
                                <i class="bi bi-star text-warning"></i>
                            @endif
                        @endfor
                        <span class="ms-2 fw-bold text-dark" style="font-size: 0.9rem;">{{ number_format($rating, 1) }}</span>
                    </div>

                    {{-- Komentar/Alasan Pelanggan --}}
                    <p class="card-text text-secondary mb-0 bg-light p-2 rounded-3 border-start border-primary border-3" style="font-style: italic; font-size: 0.9rem;">
                        "{{ $u->komentar }}"
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08)!important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
</style>
@endsection