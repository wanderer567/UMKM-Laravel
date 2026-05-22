<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - HOYOHOYO</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            --sidebar-bg: #1e1e2f;
            --main-bg: #f4f7fe;
        }

        body {
            background-color: var(--main-bg);
            font-family: 'figtree', sans-serif;
        }

        /* SIDEBAR STYLING */
        .sidebar {
            height: 100vh;
            width: 260px;
            position: fixed;
            background: var(--sidebar-bg);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.7);
            margin: 5px 15px;
            border-radius: 10px;
            padding: 12px 15px;
            transition: 0.3s;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: var(--primary-gradient);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* MAIN CONTENT STYLING */
        .main-content {
            margin-left: 260px;
            padding: 30px;
        }

        /* STATISTIC CARDS */
        .stat-card {
            border: none;
            border-radius: 20px;
            padding: 20px;
            color: white;
            background: var(--primary-gradient);
            box-shadow: 0 10px 20px rgba(106, 17, 203, 0.2);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 2rem;
            opacity: 0.5;
            position: absolute;
            right: 20px;
            bottom: 10px;
        }

        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .logout-btn {
            background: rgba(255, 59, 48, 0.1);
            color: #ff3b30;
            border: none;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background: #ff3b30;
            color: white;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
   <div class="sidebar d-flex flex-column p-3">
    <div class="px-3 py-4 text-center">
        <h4 class="fw-bold text-white mb-0">HOYO<span style="color: #00d2ff;">ADMIN</span></h4>
    </div>
    <hr class="text-white-50">
    <ul class="nav nav-pills flex-column mb-auto">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('transaksi.index') }}" class="nav-link {{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                <i class="bi bi-cart-check"></i> Transaksi
            </a>
        </li>
        <li>
            <a href="{{ route('produk.index') }}" class="nav-link {{ request()->routeIs('produk.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam"></i> Produk
            </a>
        </li>
        <li>
            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Pelanggan
            </a>
        </li>
        <li>
            <a href="{{ route('pesan.index') }}" class="nav-link {{ request()->routeIs('pesan.*') ? 'active' : '' }}">
                <i class="bi bi-chat-dots"></i> Pesan Pembelian
                @php $notifPesan = \App\Models\Pesan::where('status', 'unread')->count(); @endphp
                @if($notifPesan > 0)
                    <span class="badge bg-danger rounded-pill ms-auto">{{ $notifPesan }}</span>
                @endif
            </a>
        </li>
        <li>
            <a href="{{ route('ulasan.index') }}" class="nav-link {{ request()->routeIs('ulasan.*') ? 'active' : '' }}">
                <i class="bi bi-star"></i> Rating Pelanggan
            </a>
        </li>
    </ul>
    <hr class="text-white-50">
    <form action="{{ route('logout') }}" method="POST" class="px-3 mb-3">
        @csrf
        <button class="btn logout-btn w-100 rounded-pill fw-bold">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </button>
    </form>
</div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">Ringkasan Statistik</h2>
                <p class="text-muted">Selamat datang kembali, Admin Irsyad!</p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-dark shadow-sm p-2 px-3 rounded-pill">
                    <i class="bi bi-calendar3 me-2"></i> {{ date('d M Y') }}
                </span>
            </div>
        </div>

        <!-- 6 DATA STATISTIK (CARD) -->
        <div class="row g-4 mb-5">
            <!-- 1. Total Transaksi -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative">
                    <p class="mb-1 small opacity-75">Total Transaksi</p>
                    <h4 class="fw-bold mb-0">{{ $totalTransaksi ?? 0 }}</h4>
                    <i class="bi bi-receipt stat-icon"></i>
                </div>
            </div>
            <!-- 2. Total Pendapatan -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative">
                    <p class="mb-1 small opacity-75">Pendapatan</p>
                    <h4 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h4>
                    <i class="bi bi-wallet2 stat-icon"></i>
                </div>
            </div>
            <!-- 3. Order Berhasil -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative">
                    <p class="mb-1 small opacity-75">Order Berhasil</p>
                    <h4 class="fw-bold mb-0">{{ $produkTerlaris->nama ?? 0 }}</h4>
                    <i class="bi bi-check-circle stat-icon"></i>
                </div>
            </div>
            <!-- 4. Order Pending -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                    <p class="mb-1 small opacity-75">Order Pending</p>
                    <h4 class="fw-bold mb-0">{{ $orderPending ?? 0 }}</h4>
                    <i class="bi bi-clock-history stat-icon"></i>
                </div>
            </div>
            <!-- 5. User Aktif -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative">
                    <p class="mb-1 small opacity-75">User Aktif</p>
                    <h4 class="fw-bold mb-0">{{ $userAktif ?? 0 }}</h4>
                    <i class="bi bi-people stat-icon"></i>
                </div>
            </div>
            <!-- 6. Produk Terlaris -->
            <div class="col-md-4 col-xl-2 col-6">
                <div class="stat-card position-relative">
                    <p class="mb-1 small opacity-75">Terlaris</p>
                    <h4 class="fw-bold mb-0">{{ $produkTerlaris->nama ?? '-' }}</h4>
                    <i class="bi bi-fire stat-icon"></i>
                </div>
            </div>
        </div>

        <!-- CHART & ADDITIONAL DATA -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card card-custom p-4 shadow-sm h-100">
                    <h5 class="fw-bold mb-4">Statistik Penjualan Per Minggu</h5>
                    <canvas id="weeklyChart" height="150"></canvas>
                </div>
            </div>
            
            <div class="card card-custom p-4 shadow-sm h-100 bg-white">
    <h5 class="fw-bold mb-4">Aktivitas Terakhir</h5>
    <ul class="list-unstyled">
        @forelse($aktivitasTerakhir ?? [] as $log)
            <li class="mb-3 d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-2 rounded me-3 text-primary">
                    <i class="bi bi-clock-history"></i>
                </div>
                <div>
                    <p class="mb-0 small fw-bold">{{ $log->keterangan }}</p>
                    <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                </div>
            </li>
        @empty
            <li class="text-center py-4">
                <i class="bi bi-info-circle text-muted mb-2 d-block fs-4"></i>
                <p class="text-muted small">Belum ada aktivitas terbaru</p>
            </li>
        @endforelse
    </ul>
</div>
        </div>
    </div>

    <!-- SCRIPT UNTUK CHART -->
    <script>
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    
    // Data ini akan mengambil nilai dari controller. 
    // Jika variabel belum ada/kosong, akan default ke array berisi 0.
    const chartData = {{ json_encode($dataMingguan ?? [0, 0, 0, 0, 0, 0, 0]) }};

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Jumlah Transaksi',
                data: chartData, // Sekarang datanya dinamis
                backgroundColor: '#6a11cb',
                borderRadius: 10,
                hoverBackgroundColor: '#2575fc'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { 
                    beginAtZero: true, 
                    grid: { display: false },
                    ticks: { stepSize: 1 } // Biar angka tidak desimal kalau datanya sedikit
                },
                x: { grid: { display: false } }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>