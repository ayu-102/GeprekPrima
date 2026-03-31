<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Struk Pesanan - Geprek Prima</title>

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
            border: 8px solid #ffffff;

        }


        .scroll-area {
            flex-grow: 1;
            overflow-y: auto;
            padding: 30px 20px;
            background-color: #C40C0C;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }


        .receipt-paper {
            background: white;
            padding: 30px 20px;
            border-radius: 20px;
            height: auto;
            min-height: 500px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .dashed-line {
            border-top: 2px dashed #ddd;
            margin: 20px 0;
        }

        .qris-img {
            width: 100%;
            max-width: 250px;
            border-radius: 15px;
            border: 1px solid #eee;
            margin: 15px auto;
            display: block;
        }

        .floating-ayam {
            position: absolute;
            opacity: 0.7;
            width: 100px;
            height: auto;
            pointer-events: none;
        }

        .ayam-2 {
            top: 10%;
            right: 5%;
            transform: rotate(-20deg);
        }

        .ayam-3 {
            top: 10%;
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
            bottom: 10%;
            right: -20px;
            transform: rotate(-15deg);
        }

        .btn-back {
            background: #FF6500;
            color: white;
            border-radius: 20px;
            width: 100%;
            border: none;
            padding: 15px;
            font-weight: 800;
            margin-top: 20px;
            transition: 0.2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-back:hover {
            color: white;
            opacity: 0.9;
        }


        .receipt-header h4 {
            font-weight: 800;
            letter-spacing: 1px;
            color: #C40C0C;
        }

        .receipt-header p {
            font-size: 0.8rem;
            color: #777;
            margin-bottom: 0;
        }

        @media (max-width: 576px) {
            body {
                background-color: #C40C0C;

            }

            .mobile-frame {
                max-width: 100%;
                height: 100vh;

                border-radius: 0;
                border: none;
                margin: 0;
                box-shadow: none;
            }

            .scroll-area {
                padding: 20px 15px;

            }

            .receipt-paper {
                padding: 25px 15px;
                min-height: auto;

            }


            .floating-ayam {
                width: 80px;
                opacity: 0.4;

            }
        }
    </style>
</head>

<body>

    <div class="mobile-frame">

        <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-2">
        <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-3">
        <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-4">
        <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-5">
        <img src="{{ asset('img/ayam-bg.png') }}" class="floating-ayam ayam-6">

        <div class="scroll-area">
            <div class="receipt-paper text-center">
                <div class="receipt-header">
                    <h4 class="mb-1">GEPREK PRIMA</h4>
                    <p>Pesanan #{{ $order->id }}</p>
                    <p>{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>

                <div class="dashed-line"></div>

                <div class="text-start" style="font-size: 0.9rem;">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Pembeli:</span>
                        <span class="fw-bold">{{ $order->nama_pembeli }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted">Metode:</span>
                        <span class="fw-bold text-success">{{ strtoupper($order->metode_bayar) }}</span>
                    </div>
                    @if ($order->id_transaksi)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">ID Trans:</span>
                            <span class="fw-bold" style="font-size: 0.8rem;">#{{ $order->id_transaksi }}</span>
                        </div>
                    @endif
                </div>

                <div class="dashed-line"></div>

                <div class="dashed-line"></div>

                @if ($order->metode_bayar == 'qris')
                    <div class="py-3">
                        <i class="bi bi-check-circle-fill fs-1 text-success mb-2 d-block"></i>
                        <h5 class="fw-bold text-success">PESANAN DITERIMA</h5>
                        <p class="small text-muted">Terima kasih! Bukti bayar kamu sedang diverifikasi oleh kasir.</p>
                    </div>
                @else
                    <div class="py-3">
                        <i class="bi bi-shop fs-1 text-danger mb-2 d-block"></i>
                        <h5 class="fw-bold text-danger">MOHON KE KASIR</h5>
                        <p class="small text-muted">Sebutkan nama <strong>{{ $order->nama_pembeli }}</strong> untuk
                            melakukan pembayaran tunai.</p>
                    </div>
                @endif

                <div class="dashed-line"></div>

                <div class="dashed-line"></div>

                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold">TOTAL</span>
                    <h4 class="fw-extrabold m-0" style="color: #C40C0C;">Rp
                        {{ number_format($order->total_harga, 0, ',', '.') }}</h4>
                </div>

                <div class="mt-4 pt-2">
                    <p class="small text-muted">Terima kasih sudah memesan!<br>Nikmati pedasnya Geprek Prima.</p>
                </div>
            </div>

            <a href="{{ route('menu-user.index') }}" class="btn-back shadow">
                KEMBALI KE MENU
            </a>
        </div>
    </div>

    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('print')) {
            window.print();
            window.onafterprint = function() {
                window.close();
            };
        }
    </script>

</body>

</html>
