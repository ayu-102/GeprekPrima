<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Login - Geprek Prima</title>
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
        }

        .login-card {
            background: white;
            border-radius: 40px;
            width: 100%;
            max-width: 430px;

            height: 92vh;

            position: relative;
            overflow: hidden;
            padding: 40px 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 8px solid #ffffff;

            display: flex;
            flex-direction: column;
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

        .accent-bottom {
            position: absolute;
            bottom: -74px;
            right: -40px;
            width: 150px;
            height: 150px;
            background-color: #FF6B00;
            border-radius: 40px;
            transform: rotate(-40deg);
        }

        .logo-img {
            position: absolute;
            top: 25px;
            right: 25px;
            width: 70px;
            z-index: 2;
        }

        .title-container {
            text-align: center;
            margin-top: 80px;
            margin-bottom: 30px;
        }

        .login-title {
            font-weight: 800;
            font-style: italic;
            font-size: 40px;
            display: inline-block;
            position: relative;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: 5px;
            left: 0;
            width: 100%;
            height: 4px;
            background-color: #FF6B00;
        }

        .form-label {
            font-weight: 700;
            font-style: italic;
            font-size: 1rem;
            margin-left: 10px;
            margin-top: 10px;
        }

        .form-control {
            border: 2px solid #f4f4f4;
            background-color: #f9f9f9;
            border-radius: 20px;
            padding: 12px 20px;
        }

        .btn-login {
            background-color: #C40C0C;
            color: white;
            border-radius: 20px;
            width: 100%;
            padding: 12px;
            font-weight: 800;
            font-size: 1.1rem;
            font-style: italic;
            margin-top: 30px;
            border: none;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #a00a0a;
            transform: translateY(-2px);
        }

        .signup-text {
            text-align: center;
            margin-top: auto;
            margin-bottom: 40px;
            font-weight: 700;
            font-size: 0.85rem;
            position: relative;
            z-index: 2;
        }

        .signup-link {
            color: #C40C0C;
            text-decoration: none;
        }


        @media (max-width: 576px) {
            body {
                background-color: #ffffff;
            }

            .login-card {
                max-width: 100%;
                height: 100vh;
                border-radius: 0;
                border: none;
                margin: 0;
                box-shadow: none;
            }
        }
    </style>
</head>

<body>

    <div class="login-card">
        <div class="accent-top"></div>
        <img src="{{ asset('img/logo.png') }}" class="logo-img" alt="Logo">

        <div class="title-container">
            <h1 class="login-title">LOGIN</h1>
        </div>

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Masukkan email" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control"
                        placeholder="Masukkan password" required style="border-right: none;">
                    <span class="input-group-text bg-light" id="togglePassword"
                        style="border: 2px solid #f4f4f4; border-left: none; border-radius: 0 20px 20px 0; cursor: pointer;">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn-login" style="margin-top: 30px">LOGIN</button>
        </form>

        <p class="signup-text">
            Belum punya akun? <a href="{{ route('register') }}" class="signup-link">Daftar di sini</a>
        </p>

        <div class="accent-bottom"></div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle tipe input
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            // Toggle icon mata
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');
        });
    </script>

</body>

</html>
