<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geprek Prima - Kasir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            margin: 0;
            overflow: hidden;
        }

        #wrapper {
            display: flex;
            width: 100vw;
            height: 100vh;
        }


        #sidebar {
            min-width: 280px;
            max-width: 280px;
            background: #FF6500;
            color: #fff;
            transition: all 0.3s ease-in-out;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        #sidebar.active {
            min-width: 85px;
            max-width: 85px;
        }

        #sidebar.active .nav-text,
        #sidebar.active h4,
        #sidebar.active .sidebar-logo {
            display: none;
        }


        .navbar-custom {
            background-color: #FF6500;
            height: 60px;
            color: white;
            flex-shrink: 0;
        }

        .nav-link {
            font-size: 1.1rem;
            padding: 12px 15px;
            display: flex;
            align-items: center;
            color: white !important;
        }

        .nav-link i {
            width: 30px;
            font-size: 1.3rem;
        }

        #sidebar.active .nav-link {
            justify-content: center;
            padding: 15px 0;
        }


        #content-area {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .scrollable-content {
            padding: 25px;
            overflow-y: auto;
            height: 100%;
        }

        .nav-link.active-menu {
            background-color: white !important;
            color: #FF6500 !important;
            border-radius: 12px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .nav-link:hover:not(.active-menu) {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <nav id="sidebar" class="p-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <button type="button" id="sidebarCollapse" class="btn btn-light btn-sm">
                    <i class="bi bi-list"></i>
                </button>
                <img src="{{ asset('img/logo.png') }}" alt="Logo" class="sidebar-logo"
                    style="height: 60px; width: auto;">
            </div>

            <div class="brand-text-wrapper text-center">
                <h4 class="fw-bold mb-0 text-uppercase" style="font-size: 1.2rem; letter-spacing: 1px;">
                    Geprek Prima
                </h4>
            </div>

            <hr>

            <ul class="nav flex-column mb-auto">
                <li class="nav-item mb-2">
                    <a href="{{ route('pesanan.index') }}"
                        class="nav-link {{ request()->routeIs('pesanan.*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-cart-shopping me-2"></i>
                        <span class="nav-text">Daftar Pesanan</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('riwayat.index') }}"
                        class="nav-link {{ request()->routeIs('riwayat.*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-file-invoice me-2"></i>
                        <span class="nav-text">Riwayat Pesanan</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('menu.index') }}"
                        class="nav-link {{ request()->routeIs('menu.*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-utensils me-2"></i>
                        <span class="nav-text">Menu Makanan</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('keuangan.index') }}"
                        class="nav-link {{ request()->routeIs('keuangan.*') ? 'active-menu' : '' }}">
                        <i class="fa-solid fa-wallet me-2"></i>
                        <span class="nav-text">Keuangan</span>
                    </a>
                </li>
            </ul>

            <div class="mt-auto">
                <hr class="opacity-50">
                <a href="{{ route('pengaturan.index') }}"
                    class="nav-link {{ request()->routeIs('pengaturan.*') ? 'active-menu' : '' }}">
                    <i class="fa-solid fa-gear me-2"></i>
                    <span class="nav-text">Pengaturan</span>
                </a>
            </div>
        </nav>

        <div id="content-area">
            <nav class="navbar-custom d-flex align-items-center px-4 shadow-sm">
                <span class="fw-bold ms-auto">GeprekPrima Kasir</span>
            </nav>

            <div class="scrollable-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const btn = document.getElementById('sidebarCollapse');
            const sidebar = document.getElementById('sidebar');

            btn.addEventListener('click', function() {
                sidebar.classList.toggle('active');
            });
        });
    </script>

</body>

</html>
