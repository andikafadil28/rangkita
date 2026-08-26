<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangkita - Rangkai Kebutuhan Digitalmu</title>

    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
</head>

<body>

    <x-navbar />

    <section class="hero">
        <div>
            <div class="badge">Produk Digital Buatan Kita 🚀</div>

            <h1>Rangkai kebutuhan digitalmu dalam <span>satu tempat.</span></h1>

            <p>
                Rangkita hadir sebagai platform digital lokal yang merangkai kebutuhan pengguna:
                mulai dari undangan nikahan online, soal latihan ujian, produk digital siap pakai,
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
                <strong>📘 Soal & Latihan Ujian</strong>
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

                <h3>Soal & Latihan Ujian</h3>

                <p>
                    Paket latihan soal TWK, TIU, dan TKP dengan sistem skor dinamis,
                    timer, dan pembahasan lengkap.
                </p>

                <ul>
                    <li>Soal TWK, TIU, TKP lengkap</li>
                    <li>Mode latihan & test dengan timer</li>
                    <li>Pembahasan detail setiap soal</li>
                </ul>

                <div class="product-price">
                    Mulai Gratis
                </div>

                <a href="/soal" class="product-action">Lihat Soal</a>
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
