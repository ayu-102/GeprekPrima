<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Checkout - Geprek Prima</title>

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
            background-color: #ffffff;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            border-radius: 40px;
            border: 8px solid #ffffff;
        }

        .header {
            background: #C40C0C;
            color: white;
            padding: 30px 20px 50px 20px;
            flex-shrink: 0;
            text-align: center;
            position: relative;
        }

        .back-btn {
            position: absolute;
            left: 20px;
            top: 25px;
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .scroll-area {
            flex-grow: 1;
            overflow-y: auto;
            padding: 0 20px 30px 20px;
            margin-top: -30px;
        }

        .scroll-area::-webkit-scrollbar {
            display: none;
        }

        .card-order {
            border-radius: 25px;
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            background: white;
            padding: 20px;
        }

        .btn-add-menu {
            border: 2px dashed #FF6500;
            color: #FF6500;
            border-radius: 15px;
            font-weight: 600;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
            padding: 10px;
            margin-top: 15px;
            font-size: 0.85rem;
        }

        .method-box {
            border: 2px solid #f0f0f0;
            border-radius: 20px;
            padding: 15px;
            cursor: pointer;
            transition: 0.3s;
            position: relative;
            height: 100%;
        }

        input[type="radio"]:checked+.method-box {
            border-color: #FF6500;
            background: #fff8f4;
        }

        input[type="radio"]:checked+.method-box::after {
            content: "\f26a";
            font-family: "bootstrap-icons";
            position: absolute;
            top: 8px;
            right: 12px;
            color: #FF6500;
            font-size: 1rem;
        }

        .btn-pay {
            background: #C40C0C;
            color: white;
            border-radius: 20px;
            padding: 18px;
            font-weight: 800;
            width: 100%;
            border: none;
            font-size: 1rem;
            box-shadow: 0 8px 20px rgba(196, 12, 12, 0.25);
            transition: 0.2s;
            margin-bottom: 20px;
        }

        .btn-pay:active {
            transform: scale(0.96);
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
        <div class="header shadow-sm">
            <a href="javascript:history.back()" class="back-btn">
                <i class="bi bi-arrow-left fs-3"></i>
            </a>
            <h5 class="fw-bold m-0 mt-1">Pesanan Saya</h5>
        </div>

        <div class="scroll-area">
            <div class="card card-order mb-4">
                <h6 class="fw-bold mb-3 border-bottom pb-2" style="font-size: 0.9rem;">RINCIAN PESANAN</h6>

                @foreach ($cart as $id => $details)
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div style="flex: 1;">
                            <h6 class="mb-0 fw-bold" style="font-size: 0.85rem;">{{ $details['nama_menu'] }}</h6>
                            @if (!empty($details['catatan']))
                                <small class="text-primary d-block mt-1" style="font-size: 0.75rem;">
                                    <i class="bi bi-pencil-square"></i> {{ $details['catatan'] }}
                                </small>
                            @endif
                            <small class="text-muted">x{{ $details['quantity'] }}</small>
                        </div>
                        <span class="fw-bold text-dark" style="font-size: 0.85rem;">
                            Rp {{ number_format($details['harga'] * $details['quantity'], 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach

                <hr class="my-3" style="border-style: dashed;">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-secondary">Total Tagihan</span>
                    <h5 class="fw-bold text-danger m-0">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                </div>

                <a href="{{ route('menu-user.index') }}" class="btn-add-menu">
                    <i class="bi bi-plus-circle me-1"></i> Tambah Menu Lain
                </a>
            </div>

            <form action="{{ route('order.process') }}" method="POST" enctype="multipart/form-data" id="orderForm">
                @csrf
                <h6 class="fw-bold mb-3 small">METODE PEMBAYARAN</h6>
                <div class="row g-2 mb-4">
                    <div class="col-6">
                        <input type="radio" name="payment_method" value="cash" id="pay_cash" class="d-none"
                            checked>
                        <label for="pay_cash" class="method-box text-center d-block">
                            <span class="fs-3 d-block">💵</span>
                            <span class="small fw-bold">Tunai</span>
                        </label>
                    </div>
                    <div class="col-6">
                        <input type="radio" name="payment_method" value="qris" id="pay_qris" class="d-none">
                        <label for="pay_qris" class="method-box text-center d-block">
                            <span class="fs-3 d-block">📱</span>
                            <span class="small fw-bold">QRIS</span>
                        </label>
                    </div>
                </div>

                <div id="qris-upload-area" style="display: none;">
                    <div class="alert alert-warning border-0 d-flex align-items-start mb-3"
                        style="border-radius: 12px; background-color: #fff3cd;">
                        <i class="bi bi-shield-lock-fill me-2 mt-1 text-warning"></i>
                        <div style="font-size: 0.7rem; line-height: 1.4;">
                            <strong>Verifikasi Manual:</strong> Kasir akan mengecek mutasi bank. Pastikan nama pengirim
                            dan bukti sesuai.
                        </div>
                    </div>

                    <div class="card p-3 mb-3"
                        style="border-radius: 15px; border: 2px dashed #FF6500; background: #fffcf9;">
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-dark">Nama Pemilik Rekening/E-wallet</label>
                            <input type="text" name="nama_pengirim" id="nama_pengirim"
                                class="form-control form-control-sm shadow-none border-0 bg-white"
                                placeholder="Contoh: Budi Santoso" style="border-radius: 8px;">
                        </div>
                        <div class="mb-3">
                            <label class="fw-bold mb-1 small text-dark">Id Transaksi</label>
                            <input type="text" name="id_transaksi" id="id_transaksi"
                                class="form-control form-control-sm shadow-none border-0 bg-white"
                                placeholder="Contoh: 0987654(opsional)" style="border-radius: 8px;">
                            <small style="font-size: 0.65rem;" class="text-muted">*Lihat di struk transfer bank/e-wallet
                                kamu</small>
                        </div>

                        <div class="mb-0">
                            <label class="fw-bold mb-1 small text-dark">Upload Bukti Screenshot</label>
                            <input type="file" name="bukti_pembayaran" id="bukti_input"
                                class="form-control form-control-sm border-0 bg-white" accept="image/*"
                                style="border-radius: 8px;">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-pay">KONFIRMASI SEKARANG</button>
            </form>
        </div>
    </div>
    <div class="modal fade" id="modalQRIS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px;">
                <div class="modal-body text-center p-4">
                    <h6 class="fw-bold mb-3">Silakan Scan QRIS</h6>
                    <img src="{{ asset('img/qris.jpeg') }}" class="img-fluid rounded-3 mb-3"
                        style="border: 1px solid #eee;">
                    <div class="bg-light p-2 rounded mb-3">
                        <small class="text-muted">Total:</small>
                        <h5 class="fw-bold text-danger">Rp {{ number_format($total, 0, ',', '.') }}</h5>
                    </div>
                    <button type="button" class="btn btn-danger w-100 text-white fw-bold"
                        data-bs-dismiss="modal">SAYA SUDAH BAYAR</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const qrisRadio = document.getElementById('pay_qris');
        const cashRadio = document.getElementById('pay_cash');
        const uploadArea = document.getElementById('qris-upload-area');
        const buktiInput = document.getElementById('bukti_input');
        const namaInput = document.getElementById('nama_pengirim');
        const qrisModal = new bootstrap.Modal(document.getElementById('modalQRIS'));

        qrisRadio.addEventListener('change', function() {
            if (this.checked) {
                qrisModal.show();
                uploadArea.style.display = 'block';
                buktiInput.setAttribute('required', 'required');
                namaInput.setAttribute('required', 'required');
            }
        });

        cashRadio.addEventListener('change', function() {
            if (this.checked) {
                uploadArea.style.display = 'none';
                buktiInput.removeAttribute('required');
                namaInput.removeAttribute('required');
            }
        });
    </script>
</body>

</html>
