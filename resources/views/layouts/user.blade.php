<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geprek Prima</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #C40C0C;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: white;
        }

        .top-decoration {
            width: 100%;
            height: 8px;
            background: linear-gradient(90deg, #FF6500, #FF6500);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 9999;
        }

        .navbar {
            background: transparent;
            padding-top: 25px;
        }

        .content-wrapper {
            padding-top: 10px;
            padding-bottom: 100px;
        }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #FF6500; }
        ::-webkit-scrollbar-thumb { background: #FF6500; border-radius: 10px; }
    </style>
</head>
<body>

    <div class="top-decoration"></div>

    <nav class="navbar navbar-expand-lg navbar-dark pt-4 px-4">
    <div class="container-fluid d-flex align-items-center">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('menu-user.index') }}">
            <div>
                <span class="fw-bold d-block" style="line-height: 1; font-size: 1.2rem;">
                    Geprek <span style="color: #FF6500;">Prima</span>
                </span>
                <small class="text-white-50" style="font-size: 0.7rem;">Cita Rasa Juara</small>
            </div>
        </a>

        <div class="ms-auto">
            <img src="{{ asset('img/logo.png') }}"
                alt="Logo"
                width="70"
                height="70"
                style="object-fit: contain; border-radius: 12px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));">
        </div>
    </div>
</nav>

    <main class="content-wrapper container">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
