<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $menu->nama_menu }} - Geprek Prima</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f4f4f4;

            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden;
        }


        .main-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            width: 100%;
            padding: 40px 0;
        }


        .detail-container {
            width: 100%;
            max-width: 430px;
            margin: auto;
            background-color: #fff;
            height: 92vh;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border-radius: 40px;
            overflow: hidden;
            position: relative;
            border: 8px solid #ffffff;
            display: flex;
            flex-direction: column;
        }


        .img-wrapper {
            background-color: #FF6500;
            padding: 60px 20px;
            position: relative;
            text-align: center;
        }


        .content-area {
            padding: 25px;
            background: white;
            flex-grow: 1;
        }

        .btn-qty {
            border-radius: 12px;
            border: 2px solid #eee;
            background: white;
            font-weight: bold;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-qty {
            border: none;
            font-weight: bold;
            font-size: 1.2rem;
            width: 50px;
            text-align: center;
        }


        @media (max-width: 576px) {
            body {
                background-color: #ffffff;

            }

            .main-wrapper {
                display: block;

                padding: 0;
            }

            .detail-container {
                max-width: 100%;
                height: 100vh;
                margin: 0;
                border: none;
                border-radius: 0 !important;
                display: block;
                overflow-y: auto;
                -webkit-overflow-scrolling: touch;
            }

            .img-wrapper {
                padding-top: 50px !important;
                border-radius: 0;
            }

            .content-area {
                padding-bottom: 80px !important;
                min-height: 60vh;
                border-radius: 30px 30px 0 0;
                margin-top: -30px;
                position: relative;
            }
        }
    </style>
</head>

<body>

    <div class="main-wrapper">
        <div class="detail-container">
            <div class="img-wrapper">
                <a href="{{ route('menu-user.index') }}"
                    class="position-absolute start-0 top-0 m-4 text-white text-decoration-none">
                    <i class="bi bi-arrow-left fs-3"></i>
                </a>
                <img src="{{ $menu->foto && file_exists(public_path('storage/' . $menu->foto))
                    ? asset('storage/' . $menu->foto)
                    : asset('img/' . ($menu->foto ?: 'es.png')) }}"
                    class="img-fluid" style="max-height: 250px; filter: drop-shadow(0 15px 20px rgba(0,0,0,0.2));"
                    alt="{{ $menu->nama_menu }}">
            </div>

            <div class="content-area">
                @if (session('error'))
                    <div class="alert alert-danger d-flex align-items-center mb-3"
                        style="border-radius: 15px; font-size: 0.85rem; border: none; background-color: #ffe5e5; color: #d90429;">
                        <i class="bi bi-exclamation-circle-fill me-2"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="fw-bold m-0" style="font-size: 1.5rem;">{{ $menu->nama_menu }}</h2>
                    <h3 class="fw-bold m-0" style="color: #FF6500; white-space: nowrap; font-size: 1.4rem;">
                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                    </h3>
                </div>

                <p class="text-muted mb-4">
                    {{ $menu->deskripsi ?? 'Menu terbaik dari Geprek Prima, Dibuat dengan bahan segar setiap hari.' }}
                </p>

                <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                    @csrf

                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <label class="fw-bold fs-5">Jumlah Pesanan</label>
                        <div class="d-flex align-items-center bg-light p-1" style="border-radius: 15px;">
                            <button class="btn btn-qty" type="button" onclick="changeQty(-1)">-</button>
                            <input type="number" name="quantity" id="qtyInput" class="input-qty bg-transparent"
                                value="1" min="1" readonly>
                            <button class="btn btn-qty" type="button" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="form-label fw-bold small"><i class="bi bi-pencil-square"></i> Catatan
                            (Opsional)</label>
                        <textarea name="catatan" class="form-control" rows="2" placeholder="Contoh: Sambal dipisah, dada ayam.."
                            style="border-radius: 15px; border: 2px solid #f4f4f4; background-color: #f9f9f9;"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="action" value="add_to_cart"
                            class="btn btn-lg fw-bold py-3 flex-grow-1"
                            style="border-radius: 20px; background-color: #f4f4f4; color: #333; border: none; font-size: 0.9rem;">
                            <i class="bi bi-cart-plus"></i> + Keranjang
                        </button>

                        <button type="submit" name="action" value="buy_now"
                            class="btn btn-lg fw-bold py-3 flex-grow-1"
                            style="border-radius: 20px; background-color: #FF6500; color: white; border: none; font-size: 0.9rem;">
                            Beli Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function changeQty(val) {
            let input = document.getElementById('qtyInput');
            let current = parseInt(input.value);
            if (current + val >= 1) {
                input.value = current + val;
            }
        }
    </script>

</body>

</html>
