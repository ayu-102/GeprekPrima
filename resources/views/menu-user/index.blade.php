<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Geprek Prima - Menu</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #ffffff;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .mobile-frame {
            width: 100%;
            max-width: 430px;
            height: 92vh;
            background-color: #C40C0C;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border-radius: 40px;
            border: 8px solid #C40C0C;
        }

        .app-header {
            background-color: #FF6500;
            padding: 20px 15px;
            border-radius: 0 0 30px 30px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-text h2 {
            font-size: 1.5rem;
            margin: 0;
            font-weight: 800;
            /* Extra Bold */
            line-height: 1.2;
        }

        .scroll-area {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            padding-bottom: 100px;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        .btn-category {
            border: 2px solid #ffffff;
            color: #ffffff;
            border-radius: 50px;
            padding: 6px 18px;
            font-weight: 600;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-category.active {
            background-color: #FF6500;
            color: white;
        }


        .card-menu {
            border-radius: 25px;
            background-color: #FF6500;
            border: 1px solid #FF6500;
            text-decoration: none;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: 0.2s;
        }


        .menu-info {
            padding: 10px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .menu-name {
            font-weight: 600;
            color: #ffffff;
            font-size: 0.85rem;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .menu-price {
            font-weight: 800;
            color: #ffffff;
            font-size: 1.1rem;
            margin: 0;
        }


        .floating-ayam {
            position: absolute;
            opacity: 0.3;
            width: 100px;
            height: auto;
            pointer-events: none;
        }

        .ayam-2 {
            top: 15%;
            right: 5%;
            transform: rotate(-20deg);
        }

        .ayam-3 {
            top: 35%;
            left: -20px;
            transform: rotate(45deg);
        }

        .ayam-4 {
            bottom: 20%;
            right: 25%;
            transform: rotate(-10deg);
        }

        .ayam-5 {
            bottom: 10%;
            left: 10%;
            transform: rotate(30deg);
        }

        .ayam-6 {
            bottom: 8%;
            right: -20px;
            transform: rotate(-15deg);
        }

        @media (max-width: 576px) {
            body {
                background-color: #fff;
            }

            .mobile-frame {
                height: 100vh;
                max-width: 100%;
                border-radius: 0;
                border: none;
            }
        }
    </style>
</head>

<body>


    <div class="mobile-frame">
        <div class="app-header shadow-sm">

            <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-2">
            <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-3">
            <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-4">
            <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-5">
            <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-6">


            <div class="header-text">
                <h4 style="font-size: 0.8rem; margin-buttom:2px; font-weight: 400;">Selamat Datang di</h4>
                <h2>Geprek Prima.</h2>
            </div>
            <img src="{{ asset('img/logo.png') }}" alt="Logo"
                style="width: 85px; height: 80px; object-fit: contain;">
        </div>

        <div class="scroll-area">
            <div class="d-flex gap-2 mb-4 overflow-auto pb-2" style="scrollbar-width: none;">
                <a href="{{ route('menu-user.index') }}"
                    class="btn-category {{ !request('kategori') ? 'active' : '' }}">Semua</a>
                <a href="{{ route('menu-user.index', ['kategori' => 'makanan']) }}"
                    class="btn-category {{ request('kategori') == 'makanan' ? 'active' : '' }}">Makanan</a>
                <a href="{{ route('menu-user.index', ['kategori' => 'minuman']) }}"
                    class="btn-category {{ request('kategori') == 'minuman' ? 'active' : '' }}">Minuman</a>
            </div>

            <h6 class="fw-bold mb-3" style="font-size: 1rem; color: #ffffff;">PILIHAN MENU</h6>

            <div class="row g-3">
                @forelse($menus as $item)
                    <div class="col-6">
                        <a href="{{ route('menu-user.detail', $item->id) }}" class="card-menu shadow-sm">
                            <div class="p-2">
                                <img src="{{ $item->foto && file_exists(public_path('storage/' . $item->foto))
                                    ? asset('storage/' . $item->foto)
                                    : asset('img/' . ($item->foto ?: 'es.png')) }}"
                                    class="img-fluid w-100"
                                    style="height: 110px; object-fit: contain; border-radius: 20px;">
                            </div>
                            <div class="menu-info">
                                <p class="menu-name">{{ $item->nama_menu }}</p>
                                <p class="menu-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="text-center py-5 w-100">
                        <p class="text-muted">Menu belum tersedia.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</body>

</html>
