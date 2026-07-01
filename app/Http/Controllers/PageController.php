<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('landing');
    }

    public function produk()
    {
        $products = [
            [
                'icon' => '💌',
                'tag' => 'Produk Utama',
                'title' => 'Undangan Nikahan Online',
                'description' => 'Undangan digital cantik dan praktis untuk pasangan yang ingin membagikan undangan lewat link tanpa ribet cetak.',
                'features' => [
                    'Desain modern dan responsif',
                    'Bisa dibagikan lewat WhatsApp',
                    'Cocok untuk acara nikahan',
                ],
                'price' => 'Mulai Rp49.000',
                'button' => 'Lihat Detail',
                'url' => '/undangan',
            ],
            [
                'icon' => '📘',
                'tag' => 'Edukasi',
                'title' => 'Soal CPNS & Latihan Ujian',
                'description' => 'Paket latihan soal digital untuk bantu pengguna belajar lebih terarah sebelum menghadapi ujian atau seleksi.',
                'features' => [
                    'Paket soal siap latihan',
                    'Cocok untuk belajar mandiri',
                    'Format digital mudah diakses',
                ],
                'price' => 'Segera Hadir',
                'button' => 'Ikuti Update',
                'url' => '/cpns',
            ],
            [
                'icon' => '⚡',
                'tag' => 'File Digital',
                'title' => 'Produk Digital',
                'description' => 'Kumpulan file siap pakai seperti template, ebook, checklist, worksheet, desain, dan aset digital lain.',
                'features' => [
                    'File langsung pakai',
                    'Cocok untuk kebutuhan harian',
                    'Praktis dan mudah diunduh',
                ],
                'price' => 'Mulai Rp15.000',
                'button' => 'Jelajahi Produk',
                'url' => '/produk',
            ],
            [
                'icon' => '📝',
                'tag' => 'Konten',
                'title' => 'Artikel & SEO Blog',
                'description' => 'Artikel informatif untuk menjawab kebutuhan pengguna sekaligus membantu produk Rangkita ditemukan lewat Google.',
                'features' => [
                    'Konten informatif dan ringan',
                    'Mendukung pencarian Google',
                    'Mengarahkan ke produk relevan',
                ],
                'price' => 'Gratis Dibaca',
                'button' => 'Baca Artikel',
                'url' => '/artikel',
            ],
        ];

        return view('pages.produk', compact('products'));
    }

    public function undangan()
    {
        return view('pages.undangan');
    }

    public function cpns()
    {
        return view('pages.cpns');
    }

    public function artikel()
    {
        $articles = $this->getArticles();

        return view('pages.artikel', compact('articles'));
    }

    private function getArticles()
    {
        return [
            [
                'icon' => '💌',
                'category' => 'Undangan Online',
                'slug' => 'cara-memilih-undangan-online',
                'title' => 'Cara Memilih Undangan Online yang Cocok untuk Acara Nikahan',
                'description' => 'Tips awal memilih undangan digital yang rapi, mudah dibagikan, dan tetap terlihat elegan untuk acara pernikahan.',
                'read_time' => '4 menit baca',
                'content' => [
                    'Undangan online sekarang jadi pilihan banyak pasangan karena lebih praktis, hemat, dan mudah dibagikan lewat WhatsApp atau media sosial.',
                    'Saat memilih undangan online, pastikan desainnya sesuai dengan tema acara. Jangan cuma pilih yang ramai, tapi pilih yang nyaman dilihat dan informasinya mudah dibaca.',
                    'Hal penting lain adalah fitur. Undangan online yang bagus biasanya punya informasi acara, galeri foto, lokasi Google Maps, RSVP, dan tombol bagikan.',
                    'Dengan undangan online yang tepat, tamu bisa menerima informasi acara dengan lebih cepat dan pasangan juga bisa menghemat biaya cetak.'
                ],
            ],
            [
                'icon' => '📘',
                'category' => 'CPNS',
                'slug' => 'tips-belajar-cpns',
                'title' => 'Tips Belajar CPNS Biar Persiapan Lebih Terarah',
                'description' => 'Belajar CPNS jangan asal banyak soal. Yang penting adalah ngerti pola, evaluasi kesalahan, dan konsisten latihan.',
                'read_time' => '5 menit baca',
                'content' => [
                    'Belajar CPNS butuh strategi yang rapi. Banyak orang terlalu fokus mengerjakan banyak soal, tapi lupa mengevaluasi bagian mana yang masih lemah.',
                    'Mulailah dari memahami jenis tes seperti TWK, TIU, dan TKP. Setelah itu, buat jadwal latihan yang realistis agar belajar tidak terasa berat.',
                    'Setiap selesai latihan, catat soal yang salah. Dari situ kamu bisa tahu pola kesalahan dan materi mana yang perlu diulang.',
                    'Kunci belajar CPNS bukan cuma rajin, tapi konsisten dan tahu prioritas materi yang harus dikuasai.'
                ],
            ],
            [
                'icon' => '⚡',
                'category' => 'Produk Digital',
                'slug' => 'produk-digital-penghasilan-tambahan',
                'title' => 'Kenapa Produk Digital Cocok Buat Penghasilan Tambahan',
                'description' => 'Produk digital bisa dijual berkali-kali tanpa stok fisik, cocok buat mulai bisnis kecil dari skill yang sudah dimiliki.',
                'read_time' => '3 menit baca',
                'content' => [
                    'Produk digital adalah file atau aset yang bisa dijual secara online, seperti template, ebook, worksheet, checklist, desain, atau dokumen siap pakai.',
                    'Keunggulan produk digital adalah tidak perlu stok fisik. Setelah produk selesai dibuat, produk bisa dijual berkali-kali tanpa harus produksi ulang dari nol.',
                    'Produk digital juga cocok untuk pemula karena bisa dimulai dari skill sederhana. Misalnya membuat template undangan, template laporan, desain poster, atau file latihan.',
                    'Kalau dikemas dengan baik, produk digital bisa jadi sumber penghasilan tambahan yang fleksibel.'
                ],
            ],
            [
                'icon' => '🚀',
                'category' => 'Rangkita',
                'slug' => 'rangkita-ekosistem-digital',
                'title' => 'Rangkita: Merangkai Banyak Kebutuhan Digital dalam Satu Tempat',
                'description' => 'Rangkita dibangun sebagai ekosistem digital sederhana yang menghubungkan undangan, edukasi, produk digital, dan artikel.',
                'read_time' => '4 menit baca',
                'content' => [
                    'Rangkita hadir dengan konsep merangkai berbagai kebutuhan digital dalam satu tempat yang mudah dipahami.',
                    'Di dalam Rangkita, pengguna bisa menemukan undangan online, produk digital, latihan soal, dan artikel informatif.',
                    'Konsep ini dibuat supaya Rangkita tidak hanya menjadi tempat jualan produk, tapi juga menjadi ekosistem yang membantu pengguna menemukan solusi.',
                    'Dengan arah yang jelas, Rangkita bisa berkembang pelan-pelan menjadi brand digital yang punya banyak cabang produk.'
                ],
            ],
        ];
    }

    public function artikelDetail($slug)
    {
        $articles = $this->getArticles();

        $article = collect($articles)->firstWhere('slug', $slug);

        if (!$article) {
            abort(404);
        }

        return view('pages.artikel-detail', compact('article'));
    }

    public function kontak()
    {
        return view('pages.kontak');
    }
}
