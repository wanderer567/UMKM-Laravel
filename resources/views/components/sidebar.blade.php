<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
</body>
</html>