<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Rangkita')</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: Arial, sans-serif;
            background: #fff7fb;
            color: #1f1635;
            line-height: 1.6;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            width: 100%;
            padding: 22px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #ffffffd9;
            backdrop-filter: blur(14px);
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid #f2d8e8;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .brand-logo {
            width: 38px;
            height: 38px;
            object-fit: contain;
        }

        .logo {
            font-size: 28px;
            font-weight: 800;
            color: #160B46;
            letter-spacing: 0.5px;
        }



        .logo .k {
            color: #FF3F70;
        }

        .logo .i {
            color: #7138F6;
        }

        .logo .t {
            color: #5366FF;
        }

        .logo .a {
            color: #FF7A2D;
        }

        .nav-menu {
            display: flex;
            gap: 24px;
        }

        .nav-menu a {
            color: #4d405f;
            font-weight: 600;
        }

        .nav-menu a:hover {
            color: #ff4f87;
        }

        .page {
            min-height: 80vh;
            padding: 80px 8%;
        }

        .page-title {
            font-size: 46px;
            line-height: 1.1;
            margin-bottom: 16px;
        }

        .page-desc {
            font-size: 18px;
            color: #5c516d;
            max-width: 760px;
            line-height: 1.8;
            margin-bottom: 36px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .card {
            background: white;
            padding: 28px;
            border-radius: 28px;
            box-shadow: 0 14px 40px rgba(31, 22, 53, 0.08);
            border: 1px solid #f0d9ea;
        }

        .card-icon {
            font-size: 34px;
            margin-bottom: 16px;
        }

        .card h3 {
            font-size: 21px;
            margin-bottom: 10px;
        }

        .card p {
            color: #6d617c;
        }

        .btn-primary {
            background: linear-gradient(90deg, #ff4f87, #7a4dff);
            color: white;
            padding: 14px 22px;
            border-radius: 16px;
            font-weight: 800;
            box-shadow: 0 12px 30px rgba(122, 77, 255, 0.25);
            display: inline-block;
        }

        .footer {
            padding: 32px 8%;
            text-align: center;
            color: #6d617c;
        }

        @media (max-width: 1000px) {
            .grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .nav-menu {
                display: none;
            }

            .page-title {
                font-size: 36px;
            }

            .brand-logo {
                width: 34px;
                height: 34px;
            }

            .logo {
                font-size: 24px;
            }
        }

        @media (max-width: 650px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <x-navbar />

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <p>© 2026 Rangkita Digital. Rangkai kebutuhan digitalmu dalam satu tempat.</p>
    </footer>

</body>

</html>
