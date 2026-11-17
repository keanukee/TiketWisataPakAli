<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Pemesanan Tiket Wisata Pa Ali')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/mazer-custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <aside id="sidebar">
        <div class="sidebar-header d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="brand-title">
                <i class="bi bi-ticket-perforated-fill fs-3"></i>
                <span>Wisata Pa Ali</span>
            </a>
            <button class="btn btn-sm btn-light d-lg-none" onclick="document.getElementById('sidebar').classList.remove('active')">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <ul class="sidebar-menu">
            <li class="sidebar-title">Menu Utama</li>
            <li>
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('katalog') }}" class="sidebar-link {{ request()->routeIs('katalog') ? 'active' : '' }}">
                    <i class="bi bi-compass-fill"></i>
                    <span>Katalog Wisata</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemesanan.create') }}" class="sidebar-link {{ request()->routeIs('pemesanan.create') ? 'active' : '' }}">
                    <i class="bi bi-cart-plus-fill"></i>
                    <span>Pesan Tiket Baru</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemesanan.index') }}" class="sidebar-link {{ request()->routeIs('pemesanan.index') || request()->routeIs('pemesanan.edit') || request()->routeIs('pemesanan.eticket') ? 'active' : '' }}">
                    <i class="bi bi-receipt-cutoff"></i>
                    <span>{{ auth()->user()->isAdmin() ? 'Kelola Pemesanan' : 'Riwayat & E-Ticket' }}</span>
                </a>
            </li>

            @if(auth()->user()->isAdmin())
                <li class="sidebar-title">Panel Pengelola (Admin)</li>
                <li>
                    <a href="{{ route('destinasi.index') }}" class="sidebar-link {{ request()->routeIs('destinasi.*') ? 'active' : '' }}">
                        <i class="bi bi-map-fill"></i>
                        <span>Kelola Destinasi</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('kategori.index') }}" class="sidebar-link {{ request()->routeIs('kategori.*') ? 'active' : '' }}">
                        <i class="bi bi-tags-fill"></i>
                        <span>Kategori Wisata</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('validasi.form') }}" class="sidebar-link {{ request()->routeIs('validasi.*') ? 'active' : '' }}">
                        <i class="bi bi-qr-code-scan"></i>
                        <span>Validasi E-Ticket</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('laporan.index') }}" class="sidebar-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>
                        <span>Laporan Penjualan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('users.index') }}" class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-people-fill"></i>
                        <span>Manajemen User</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>

    <div id="main-content">
        <header class="card card-mazer p-3 mb-4 no-print">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <button id="sidebarToggle" class="btn btn-outline-primary d-lg-none">
                        <i class="bi bi-list"></i>
                    </button>
                    <div>
                        <h5 class="mb-0 fw-bold">@yield('page_title', 'Dashboard')</h5>
                        <small class="text-muted">Sistem Pemesanan Tiket Wisata Pa Ali Secara Online</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="text-end d-none d-md-block">
                        <div class="fw-bold">{{ auth()->user()->name }}</div>
                        <span class="badge {{ auth()->user()->isAdmin() ? 'bg-primary' : 'bg-success' }}">
                            {{ strtoupper(auth()->user()->role) }}
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Keluar">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </header>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm no-print" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm no-print" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm no-print" role="alert">
                <strong>Terjadi kesalahan input:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')

        <footer class="mt-5 text-center text-muted small no-print">
            &copy; {{ date('Y') }} Sistem Pemesanan Tiket Wisata Pa Ali Secara Online &bull; Template Mazer Bootstrap 5
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
