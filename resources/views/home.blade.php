@extends('layouts.pelanggan')

@section('content')

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko HOYOHOYO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --dark-purple: #2d1b4e;
            --light-blue: #00d2ff;
        }

        body {
            background-color: #f4f7fe;
            color: #2d1b4e;
        }

        .card-img-top {
            height: 200px;
            width: 100%;      
            object-fit: cover; 
            object-position: center; 
        }

        /* Navbar dengan gradasi */
        .navbar-custom {
            background: var(--primary-gradient) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
            letter-spacing: 2px;
            color: #ffffff !important;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }

        /* Tombol Cari & Tombol Beli */
        .btn-custom {
            background: var(--primary-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            opacity: 0.9;
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 4px 15px rgba(106, 17, 203, 0.4);
        }

        .text-gradient {
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: bold;
        }

        .card {
            transition: transform 0.3s ease;
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        /* Hover efek khusus link produk ketika sudah login */
        .product-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .product-link:hover .card-title {
            color: #2575fc;
        }

        .dropdown-item-text {
            font-size: 0.9rem;
            color: #6c757d;
        }

        footer {
            background: var(--dark-purple) !important;
        }

        /* ==================== STRUKTUR HERO BANNER & CAROUSEL ==================== */
        .hero-banner-container {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .bg-banner-main {
            width: 100%;
            height: auto;
            display: block;
        }

        .carousel-overlay-wrapper {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 85%;
            max-width: 1200px;
            z-index: 10;
        }

        .carousel-custom {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .carousel-custom .carousel-item img {
            width: 100%;
            height: auto; 
            object-fit: contain;
        }

        .carousel-custom .carousel-control-prev-icon,
        .carousel-custom .carousel-control-next-icon {
            background-color: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 50%;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.2s ease;
        }

        .carousel-custom .carousel-control-prev-icon:hover,
        .carousel-custom .carousel-control-next-icon:hover {
            background-color: rgba(255, 255, 255, 0.4);
            transform: scale(1.1);
        }

        /* Kategori Badge Style */
        .btn-category {
            background-color: #ffffff;
            color: var(--dark-purple);
            border: 1px solid rgba(106, 17, 203, 0.15);
            font-weight: 500;
            padding: 8px 20px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }
        .btn-category:hover, .btn-category.active {
            background: var(--primary-gradient);
            color: #ffffff !important;
            border-color: transparent;
            box-shadow: 0 4px 12px rgba(106, 17, 203, 0.25);
        }
    </style>
</head>
<body>
    
<div class="hero-banner-container">
    <img src="{{ asset('storage/carousel/carousel.png') }}" class="bg-banner-main" alt="Hero Banner Background">
    <div class="carousel-overlay-wrapper">
        <div id="carouselExampleIndicators" class="carousel slide carousel-custom" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('storage/carousel/carousel1.png') }}" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/carousel/carousel2.png') }}" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/carousel/carousel3.png') }}" class="d-block w-100" alt="Slide 3">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('storage/carousel/carousel4.png') }}" class="d-block w-100" alt="Slide 4">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h4 class="fw-bold mb-3">Jelajahi <span class="text-gradient">Kategori</span></h4>
            <div class="d-flex flex-wrap justify-content-center gap-2">
                {{-- Tombol Semua Produk --}}
                <a href="{{ route('home') }}" class="btn btn-category rounded-pill {{ !request('kategori') ? 'active' : '' }}">
                    Semua Produk
                </a>
                
                {{-- Ambil kategori unik langsung dari koleksi data produk --}}
                @foreach($semuaKategori as $kat)
                    <a href="{{ route('home', ['kategori' => $kat]) }}" 
                       class="btn btn-category rounded-pill {{ request('kategori') == $kat ? 'active' : '' }}">
                        {{ ucfirst($kat) }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Produk <span class="text-gradient">Terbaru</span></h3>
    </div>

    <div class="row">
    @forelse($produk as $item)
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card h-100 shadow-sm border-0">
                
                <img src="{{ asset('gambar_produk/'.$item->poto) }}" class="card-img-top rounded-top-4" alt="{{ $item->nama }}">
                
                <div class="card-body px-3">
                    <h5 class="card-title fs-6 text-truncate fw-bold mb-1">{{ $item->nama }}</h5>
                    
                    <p class="text-gradient mb-3">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                    
                    @auth
                        @if(Auth::user()->role == 'pelanggan')
                            <a href="{{ route('produk.show', $item->id) }}" class="btn btn-custom w-100 btn-sm rounded-pill">
                                <i class="bi bi-cart-plus me-1"></i> Beli Sekarang
                            </a>
                        @else
                            <button class="btn btn-secondary w-100 btn-sm rounded-pill" disabled>Admin Mode</button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary w-100 btn-sm rounded-pill">Login untuk Beli</a>
                    @endauth
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <i class="bi bi-box-seam display-1 text-muted"></i>
            <h4 class="mt-3 text-muted">Data produk sedang kosong</h4>
            <p>Nantikan update produk terbaru segera!</p>
        </div>
    @endforelse
</div>
</div>

<!-- <footer class="bg-white border-top border-light py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted small mb-0">
                &copy; {{ date('Y') }} <strong class="text-gradient-brand">HOYOHOYO</strong>. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer> -->


</body>
</html>

@endsection