<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'Irsyad Website UMKM') }} - Pelanggan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f6f8fc;
            color: #212529;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }

        /* NAVBAR FULL GRADASI UNGU KE BIRU */
        .navbar-gradient {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%) !important;
            box-shadow: 0 4px 20px rgba(106, 17, 203, 0.15);
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Warna teks nama toko di navbar */
        .navbar-brand-custom {
            color: #ffffff !important;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* Link menu navigasi (Default Putih Transparan) */
        .nav-link-custom {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 50px;
            transition: all 0.2s ease;
        }

        /* Menu aktif / ketika di-hover (Putih Terang & Background Agak Gelap Transparan) */
        .nav-link-custom:hover, 
        .nav-link-custom.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Dropdown Nama User */
        .dropdown-toggle-custom {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.2) !important;
            font-weight: 600;
        }
        .dropdown-toggle-custom:hover {
            background-color: rgba(255, 255, 255, 0.3) !important;
        }

        /* Tombol Daftar/Aksi dengan Putih Bersih */
        .btn-light-custom {
            background-color: #ffffff;
            color: #6a11cb !important;
            font-weight: 600;
            border: none;
            transition: all 0.2s ease;
        }
        .btn-light-custom:hover {
            background-color: #f1f4ff;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
        }

        /* Tombol Utama di Halaman Dalam (Beli Sekarang, dll) */
        .btn-custom {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: white;
            border: none;
            font-weight: 500;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .btn-custom:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(106, 17, 203, 0.35);
        }

        /* Teks Gradasi untuk Footer / Judul Halaman */
        .text-gradient-brand {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Animasi Transisi Halus Antar Halaman */
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-gradient sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-brand-custom fs-4 d-flex align-items-center" href="{{ route('home') }}">
                <i class="bi bi-shop me-2"></i>
                <span>HOYOHOYO</span>
            </a>
            <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2" style="color: white;"></i>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1 mt-3 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="bi bi-house-door me-1"></i> Beranda
                        </a>
                    </li>
                    @auth
                                        <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('keranjang.index') ? 'active' : '' }}" href="{{ route('keranjang.index') }}">
                            <i class="bi bi-cart3 me-1"></i> Keranjang 
                            @if(auth()->check() && \App\Models\Keranjang::where('user_id', auth()->id())->count() > 0)
                                <span class="badge bg-danger rounded-circle p-1" style="font-size: 9px;">
                                    {{ \App\Models\Keranjang::where('user_id', auth()->id())->sum('jumlah') }}
                                </span>
                            @endif
                        </a>
                    </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('cs.*') ? 'active' : '' }}" href="{{ route('cs.index') }}">
                                <i class="bi bi-headset me-1"></i> Customer Service
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle dropdown-toggle-custom px-3 rounded-pill" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i> {{ Auth::user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2 rounded-3" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                        <i class="bi bi-gear me-2 text-muted"></i> Pengaturan Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider opacity-50"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger py-2">
                                            <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom me-2" href="{{ route('login') }}">Masuk</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light-custom btn-sm rounded-pill px-4" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4 fade-in">
        @yield('content')
    </main>

    <footer class="bg-white border-top border-light py-4 mt-5">
        <div class="container text-center">
            <p class="text-muted small mb-0">
                &copy; {{ date('Y') }} <strong class="text-gradient-brand">HOYOHOYO</strong>. Hak Cipta Dilindungi.
            </p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>