<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkita - Rangkai Kebutuhan Digitalmu</title>

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

        .logo span {
            display: inline;
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

        .hero {
            min-height: 86vh;
            padding: 80px 8%;
            display: grid;
            grid-template-columns: 1.2fr 0.8fr;
            align-items: center;
            gap: 40px;
        }

        .badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 999px;
            background: #ffe2ed;
            color: #ff3f7f;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: 58px;
            line-height: 1.05;
            margin-bottom: 22px;
        }

        .hero h1 span {
            background: linear-gradient(90deg, #ff4f87, #7a4dff, #ff7a2f);
            -webkit-background-clip: text;
            color: transparent;
        }

        .hero p {
            font-size: 18px;
            color: #5c516d;
            max-width: 620px;
            margin-bottom: 32px;
        }

        .button-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
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

        .btn-secondary {
            background: white;
            color: #1f1635;
            padding: 14px 22px;
            border-radius: 16px;
            font-weight: 800;
            border: 1px solid #ead8f3;
            display: inline-block;
        }

        .hero-card {
            background: white;
            border-radius: 32px;
            padding: 34px;
            box-shadow: 0 24px 70px rgba(31, 22, 53, 0.12);
            position: relative;
            overflow: hidden;
        }

        .hero-card::before {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            background: linear-gradient(135deg, #ff4f87, #7a4dff);
            border-radius: 50%;
            top: -80px;
            right: -80px;
            opacity: 0.22;
        }

        .hero-card h3 {
            font-size: 26px;
            margin-bottom: 18px;
            position: relative;
        }

        .mini-card {
            padding: 18px;
            border-radius: 22px;
            background: #fff7fb;
            margin-bottom: 14px;
            border: 1px solid #f0d9ea;
            position: relative;
        }

        .mini-card p {
            color: #6d617c;
            margin-top: 4px;
        }

        .section {
            padding: 80px 8%;
        }

        .section-title {
            text-align: center;
            margin-bottom: 42px;
        }

        .section-title h2 {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #6d617c;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .product-card {
            background: white;
            padding: 28px;
            border-radius: 28px;
            box-shadow: 0 14px 40px rgba(31, 22, 53, 0.08);
            border: 1px solid #f0d9ea;
            transition: 0.25s;
        }

        .product-tag {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            background: #ffe2ed;
            color: #ff3f70;
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 14px;
        }

        .product-card ul {
            list-style: none;
            margin: 18px 0 22px;
        }

        .product-card ul li {
            color: #5c516d;
            margin-bottom: 9px;
            font-size: 15px;
        }

        .product-card ul li::before {
            content: "✓";
            color: #ff4f87;
            font-weight: 900;
            margin-right: 8px;
        }

        .product-price {
            font-size: 20px;
            font-weight: 900;
            color: #1f1635;
            margin-bottom: 18px;
        }

        .product-price span {
            font-size: 13px;
            color: #8a7a99;
            font-weight: 700;
        }

        .product-action {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 12px 16px;
            border-radius: 14px;
            background: linear-gradient(90deg, #ff4f87, #7a4dff);
            color: white;
            font-weight: 800;
        }

        .product-card {
            display: flex;
            flex-direction: column;
        }

        .product-card p {
            min-height: 100px;
        }

        .product-card ul {
            flex: 1;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 50px rgba(31, 22, 53, 0.12);
        }

        .product-icon {
            width: 56px;
            height: 56px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, #ff4f87, #7a4dff);
            color: white;
            font-size: 26px;
            margin-bottom: 18px;
        }

        .product-card h3 {
            font-size: 21px;
            margin-bottom: 12px;
        }

        .product-card p {
            color: #6d617c;
        }

        .about-box {
            background: white;
            padding: 42px;
            border-radius: 32px;
            box-shadow: 0 14px 40px rgba(31, 22, 53, 0.08);
            border: 1px solid #f0d9ea;
            max-width: 980px;
            margin: 0 auto;
        }

        .about-box p {
            color: #5c516d;
            margin-bottom: 16px;
            font-size: 17px;
        }

        .cta {
            margin: 80px 8%;
            padding: 54px;
            border-radius: 36px;
            background: linear-gradient(135deg, #1f1635, #5436c9);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 38px;
            margin-bottom: 14px;
        }

        .cta p {
            color: #efe8ff;
            margin-bottom: 30px;
        }

        .footer {
            padding: 32px 8%;
            text-align: center;
            color: #6d617c;
        }

        @media (max-width: 1100px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 900px) {
            .brand-logo {
                width: 34px;
                height: 34px;
            }

            .logo {
                font-size: 24px;
            }

            .hero {
                grid-template-columns: 1fr;
                padding-top: 50px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .nav-menu {
                display: none;
            }

            .product-grid {
                grid-template-columns: 1fr;
            }

            .cta {
                padding: 36px 24px;
            }
        }
    </style>
</head>

<body>

    <x-navbar />

    <section class="hero">
        <div>
            <div class="badge">Produk Digital Buatan Kita 🚀</div>

            <h1>Rangkai kebutuhan digitalmu dalam <span>satu tempat.</span></h1>

            <p>
                Rangkita hadir sebagai platform digital lokal yang merangkai kebutuhan pengguna:
                mulai dari undangan nikahan online, soal CPNS dan latihan ujian, produk digital siap pakai,
                sampai artikel informatif yang mudah ditemukan lewat Google.
            </p>

            <div class="button-group">
                <a href="/produk" class="btn-primary">Mulai Jelajah</a>
                <a href="#tentang" class="btn-secondary">Kenalan Dulu</a>
            </div>
        </div>

        <div class="hero-card">
            <h3>Ekosistem Rangkita</h3>

            <div class="mini-card">
                <strong>💌 Undangan Nikahan Online</strong>
                <p>Undangan digital yang cantik, praktis, dan gampang dibagikan lewat link.</p>
            </div>

            <div class="mini-card">
                <strong>📘 Soal CPNS & Latihan Ujian</strong>
                <p>Paket soal, pembahasan, dan latihan untuk bantu persiapan seleksi.</p>
            </div>

            <div class="mini-card">
                <strong>⚡ Produk Digital</strong>
                <p>Template, ebook, worksheet, checklist, desain, dan file siap pakai.</p>
            </div>

            <div class="mini-card">
                <strong>📝 Artikel & SEO Blog</strong>
                <p>Konten artikel untuk bantu pengguna menemukan solusi lewat Google.</p>
            </div>
        </div>
    </section>

    <section class="section" id="produk">
        <div class="section-title">
            <h2>Produk & Ekosistem Rangkita</h2>
            <p>Satu brand, banyak kebutuhan digital yang tetap saling nyambung.</p>
        </div>

        <div class="product-grid">
            <div class="product-card">
                <div class="product-icon">💌</div>
                <span class="product-tag">Produk Utama</span>

                <h3>Undangan Nikahan Online</h3>

                <p>
                    Undangan digital cantik dan praktis untuk pasangan yang ingin membagikan
                    undangan lewat link tanpa ribet cetak.
                </p>

                <ul>
                    <li>Desain modern dan responsif</li>
                    <li>Bisa dibagikan lewat WhatsApp</li>
                    <li>Cocok untuk acara nikahan</li>
                </ul>

                <div class="product-price">
                    Mulai Rp49.000 <span>/ undangan</span>
                </div>

                <a href="/undangan" class="product-action">Lihat Detail</a>
            </div>

            <div class="product-card">
                <div class="product-icon">📘</div>
                <span class="product-tag">Edukasi</span>

                <h3>Soal CPNS & Latihan Ujian</h3>

                <p>
                    Paket latihan soal digital untuk bantu pengguna belajar lebih terarah
                    sebelum menghadapi ujian atau seleksi.
                </p>

                <ul>
                    <li>Paket soal siap latihan</li>
                    <li>Cocok untuk belajar mandiri</li>
                    <li>Format digital mudah diakses</li>
                </ul>

                <div class="product-price">
                    Segera Hadir
                </div>

                <a href="/cpns" class="product-action">Ikuti Update</a>
            </div>

            <div class="product-card">
                <div class="product-icon">⚡</div>
                <span class="product-tag">File Digital</span>

                <h3>Produk Digital</h3>

                <p>
                    Kumpulan file siap pakai seperti template, ebook, checklist, worksheet,
                    desain, dan aset digital lain.
                </p>

                <ul>
                    <li>File langsung pakai</li>
                    <li>Cocok untuk kebutuhan harian</li>
                    <li>Praktis dan mudah diunduh</li>
                </ul>

                <div class="product-price">
                    Mulai Rp15.000 <span>/ produk</span>
                </div>

                <a href="/kontak" class="product-action">Jelajahi Produk</a>
            </div>

            <div class="product-card" id="artikel">
                <div class="product-icon">📝</div>
                <span class="product-tag">Konten</span>

                <h3>Artikel & SEO Blog</h3>

                <p>
                    Artikel informatif untuk menjawab kebutuhan pengguna sekaligus membantu
                    produk Rangkita ditemukan lewat Google.
                </p>

                <ul>
                    <li>Konten informatif dan ringan</li>
                    <li>Mendukung pencarian Google</li>
                    <li>Mengarahkan ke produk relevan</li>
                </ul>

                <div class="product-price">
                    Gratis Dibaca
                </div>

                <a href="/artikel" class="product-action">Baca Artikel</a>
            </div>
        </div>
    </section>

    <section class="section" id="tentang">
        <div class="section-title">
            <h2>Filosofi Rangkita</h2>
            <p>Dari rangkai dan kita, dibuat untuk kebutuhan digital masyarakat Indonesia.</p>
        </div>

        <div class="about-box">
            <p>
                Rangkita berasal dari kata “rangkai” dan “kita”. “Rangkai” menggambarkan proses
                menyusun berbagai kebutuhan digital agar menjadi sesuatu yang siap digunakan,
                bermanfaat, dan bernilai.
            </p>

            <p>
                Sedangkan “kita” mencerminkan kedekatan, kebersamaan, dan semangat untuk tumbuh
                bersama pengguna. Rangkita ingin menjadi partner digital yang mudah dipahami,
                dekat, dan relevan untuk masyarakat Indonesia.
            </p>

            <p>
                Rangkita dibangun untuk membantu orang menemukan solusi digital yang praktis,
                ringan, dan mudah digunakan.
            </p>
        </div>
    </section>

    <section class="cta" id="kontak">
        <h2>Siap mulai bareng Rangkita?</h2>
        <p>
            Semua kebutuhan digitalmu, dari undangan online sampai produk digital,
            dirangkai jadi lebih mudah dalam satu tempat.
        </p>

        <a href="/produk" class="btn-primary">Jelajahi Produk</a>
    </section>

    <footer class="footer">
        <p>© 2026 Rangkita Digital. Rangkai kebutuhan digitalmu dalam satu tempat.</p>
    </footer>

</body>

</html>
