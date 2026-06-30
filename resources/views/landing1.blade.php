<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkita Digital</title>

    <style>
        :root {
            --bg: #f8f3ea;
            --text: #222222;
            --muted: #666666;
            --white: #ffffff;
            --primary: #2a9d8f;
            --orange: #e76f51;
            --yellow: #f4a261;
            --blue: #457b9d;
            --shadow: 0 18px 50px rgba(0, 0, 0, 0.10);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text);
        }

        a {
            text-decoration: none;
        }

        .container {
            width: min(1120px, 90%);
            margin: auto;
        }

        .navbar {
            padding: 24px 0;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -1.5px;
            color: var(--text);
        }

        .logo-rang {
            color: #242424;
        }

        .logo-kita span {
            display: inline-block;
            margin-left: -4px;
        }

        .k1 {
            color: var(--orange);
        }

        .k2 {
            color: var(--yellow);
        }

        .k3 {
            color: var(--primary);
        }

        .k4 {
            color: var(--blue);
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .nav-links a {
            color: #333;
            font-size: 15px;
            font-weight: 700;
        }

        .nav-button {
            background: var(--text);
            color: var(--white) !important;
            padding: 11px 18px;
            border-radius: 999px;
        }

        .hero {
            padding: 70px 0 90px;
        }

        .hero .container {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            align-items: center;
            gap: 60px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--white);
            color: var(--primary);
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 10px 30px rgba(0,0,0,0.07);
            margin-bottom: 24px;
        }

        .hero-title {
            font-size: clamp(42px, 6vw, 68px);
            line-height: 1.03;
            letter-spacing: -3px;
            margin-bottom: 24px;
        }

        .hero-title span {
            color: var(--orange);
        }

        .hero-desc {
            font-size: 18px;
            line-height: 1.8;
            color: var(--muted);
            max-width: 570px;
            margin-bottom: 34px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 15px 24px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 15px;
        }

        .btn-primary {
            background: var(--primary);
            color: var(--white);
            box-shadow: 0 12px 30px rgba(42,157,143,0.25);
        }

        .btn-secondary {
            background: var(--white);
            color: var(--text);
            border: 1px solid rgba(0,0,0,0.08);
        }

        .hero-visual {
            background: var(--white);
            border-radius: 32px;
            padding: 28px;
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .hero-visual::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(42, 157, 143, 0.12);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .visual-top {
            background: linear-gradient(135deg, var(--orange), var(--yellow));
            color: var(--white);
            border-radius: 24px;
            padding: 28px;
            position: relative;
            z-index: 1;
            margin-bottom: 20px;
        }

        .visual-top h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .visual-top p {
            line-height: 1.7;
            opacity: 0.95;
        }

        .visual-list {
            display: grid;
            gap: 14px;
            position: relative;
            z-index: 1;
        }

        .visual-item {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #fbf7f0;
            padding: 16px;
            border-radius: 18px;
            font-weight: 800;
        }

        .icon-box {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            display: grid;
            place-items: center;
            background: var(--white);
            box-shadow: 0 8px 20px rgba(0,0,0,0.06);
        }

        @media (max-width: 900px) {
            .nav-links {
                display: none;
            }

            .hero {
                padding: 40px 0 70px;
            }

            .hero .container {
                grid-template-columns: 1fr;
                gap: 40px;
                text-align: center;
            }

            .hero-desc {
                margin-left: auto;
                margin-right: auto;
            }

            .hero-actions {
                justify-content: center;
            }

            .hero-title {
                letter-spacing: -2px;
            }
        }

        @media (max-width: 520px) {
            .logo {
                font-size: 26px;
            }

            .hero-title {
                font-size: 40px;
            }

            .hero-desc {
                font-size: 16px;
            }

            .btn {
                width: 100%;
            }

            .hero-visual {
                padding: 20px;
                border-radius: 24px;
            }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="container">
            <a href="#" class="logo">
                <span class="logo-rang">Rang</span>
                <span class="logo-kita">
                    <span class="k1">k</span>
                    <span class="k2">i</span>
                    <span class="k3">t</span>
                    <span class="k4">a</span>
                </span>
            </a>

            <nav class="nav-links">
                <a href="#">Beranda</a>
                <a href="#">Produk</a>
                <a href="#">Artikel</a>
                <a href="#">Kontak</a>
                <a href="#" class="nav-button">Mulai Sekarang</a>
            </nav>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="container">
                <div class="hero-content">
                    <div class="badge">
                        ✨ Solusi digital simpel & rapi
                    </div>

                    <h1 class="hero-title">
                        Bikin kebutuhan digital jadi lebih <span>mudah.</span>
                    </h1>

                    <p class="hero-desc">
                        Rangkita Digital membantu kamu membuat undangan online,
                        latihan soal CPNS, produk digital, dan artikel SEO dalam satu tempat
                        yang simpel, modern, dan gampang dipakai.
                    </p>

                    <div class="hero-actions">
                        <a href="#" class="btn btn-primary">Lihat Produk</a>
                        <a href="#" class="btn btn-secondary">Hubungi Kami</a>
                    </div>
                </div>

                <div class="hero-visual">
                    <div class="visual-top">
                        <h2>Rangkita Digital</h2>
                        <p>
                            Platform kecil yang dirancang buat bantu kebutuhan digital harian,
                            dari undangan sampai produk siap jual.
                        </p>
                    </div>

                    <div class="visual-list">
                        <div class="visual-item">
                            <div class="icon-box">💌</div>
                            <span>Undangan Online</span>
                        </div>

                        <div class="visual-item">
                            <div class="icon-box">📚</div>
                            <span>Latihan Soal CPNS</span>
                        </div>

                        <div class="visual-item">
                            <div class="icon-box">🛒</div>
                            <span>Produk Digital</span>
                        </div>

                        <div class="visual-item">
                            <div class="icon-box">📝</div>
                            <span>Artikel SEO</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

</body>
</html>