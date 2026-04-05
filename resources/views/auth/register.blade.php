<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Register - Geprek Master</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,700;1,800&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .register-card {
            background: white;
            border-radius: 40px;
            width: 100%;
            max-width: 900px;
            min-height: 600px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 8px solid #ffffff;
            display: flex;
            flex-direction: row;
        }


        .info-panel {
            flex: 1;
            background-color: #FF6B00;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            padding: 40px;
            text-align: center;
            z-index: 2;
        }

        .form-panel {
            flex: 1;
            padding: 40px 60px;
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 2;
            background: white;
        }

        .desktop-logo {
            width: 150px;
            margin-bottom: 25px;
            filter: drop-shadow(0 5px 15px rgba(0, 0, 0, 0.3));
        }

        .logo-img-mobile {
            display: none;
        }

        .accent-bottom {
            position: absolute;
            bottom: -74px;
            right: -40px;
            width: 150px;
            height: 150px;
            background-color: #FF6B00;
            border-radius: 40px;
            transform: rotate(-40deg);
            z-index: 1;
        }


        .accent-top {
            display: none;
        }

        .title-container {
            margin-bottom: 30px;
        }

        .register-title {
            font-weight: 800;
            font-style: italic;
            font-size: 35px;
            display: inline-block;
            position: relative;
            margin: 0;
        }

        .register-title::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #FF6B00;
        }


        form {
            width: 100%;
            max-width: 400px;
        }



        .form-label {
            font-weight: 700;
            font-style: italic;
            font-size: 0.9rem;
            margin-left: 10px;
        }

        .form-control {
            border: 2px solid #f4f4f4;
            background-color: #f9f9f9;
            border-radius: 20px;
            padding: 10px 20px;
            font-size: 0.9rem;
        }

        .btn-signup {
            background-color: #C40C0C;
            color: white;
            border-radius: 20px;
            width: 100%;
            padding: 12px;
            font-weight: 800;
            font-style: italic;
            border: none;
            transition: 0.3s;
            margin-top: 25px;
        }

        .btn-signup:hover {
            background-color: #a00a0a;
            transform: translateY(-2px);
        }

        .login-text {
            text-align: center;
            margin-top: auto;
            font-weight: 700;
            font-size: 0.85rem;
            padding-bottom: 20px;
        }

        .login-link {
            color: #C40C0C;
            text-decoration: none;
        }


        @media (max-width: 991px) {
            body {
                overflow: auto;
            }


            .register-card {
                max-width: 430px;
                height: 92vh;
                flex-direction: column;
            }

            .info-panel {
                display: none;
            }


            .accent-top {
                display: block;
            }


            .logo-img-mobile {
                display: block;
                position: absolute;
                top: 25px;
                right: 25px;
                width: 60px;
                z-index: 3;
            }

            .form-panel {
                padding: 80px 30px 40px 30px;
                width: 100%;
                height: 100%;
                overflow-y: auto;
            }


            .form-panel::-webkit-scrollbar {
                width: 0px;
            }

            .title-container {
                text-align: center;
                margin-top: 20px;
            }

            .signup-text {
                margin-top: auto;
                margin-bottom: 40px;
                text-align: center;
            }
        }

        @media (max-width: 576px) {
            .register-card {
                max-width: 100%;
                height: 100vh;
                border-radius: 0;
                border: none;
                margin: 0;
                box-shadow: none;
            }
        }


        .accent-top {
            position: absolute;
            top: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background-color: #FF6B00;
            border-radius: 40px;
            transform: rotate(-40deg);
            z-index: 1;
        }
    </style>
</head>

<body>

    <div class="register-card">
        <div class="info-panel">
            <img src="{{ asset('img/logo.png') }}" class="desktop-logo" alt="Logo">
            <h2 style="font-weight: 800; font-style: italic;">GEPREK PRIMA</h2>
            <p style="font-weight: 500; opacity: 0.9;">Solusi Cerdas Transaksi Digital<br>Kelola Bisnis Jadi Lebih Mudah
            </p>
        </div>

        <div class="form-panel">
            <div class="accent-top"></div>
            <img src="{{ asset('img/logo.png') }}" class="logo-img-mobile" alt="Logo">

            <div class="title-container">
                <h1 class="register-title">REGISTER</h1>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Username</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}"
                        placeholder="Username" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                        placeholder="Email" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control"
                            placeholder="Masukkan password" required style="border-right: none;">
                        <span class="input-group-text bg-light" id="btnPass"
                            style="border: 2px solid #f4f4f4; border-left: none; border-radius: 0 20px 20px 0; cursor: pointer;">
                            <i class="bi bi-eye-slash" id="iconPass"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" placeholder="Konfirmasi password" required style="border-right: none;">
                        <span class="input-group-text bg-light" id="btnConfirm"
                            style="border: 2px solid #f4f4f4; border-left: none; border-radius: 0 20px 20px 0; cursor: pointer;">
                            <i class="bi bi-eye-slash" id="iconConfirm"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn-signup" style="margin-bottom: 5px">DAFTAR SEKARANG</button>
            </form>

            <p class="login-text">
                Sudah punya akun? <a href="{{ route('login') }}" class="login-link">Login di sini</a>
            </p>

            <div class="accent-bottom"></div>
        </div>
    </div>

    <script>
        function createToggle(btnId, inputId, iconId) {
            const btn = document.querySelector(btnId);
            const input = document.querySelector(inputId);
            const icon = document.querySelector(iconId);

            btn.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
            });
        }

        createToggle('#btnPass', '#password', '#iconPass');
        createToggle('#btnConfirm', '#password_confirmation', '#iconConfirm');
    </script>
</body>

</html>
