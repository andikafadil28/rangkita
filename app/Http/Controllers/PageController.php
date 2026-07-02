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
        $products = $this->getProducts();

        return view('pages.produk', compact('products'));
    }
    private function getProducts()
    {
        return [
            [
                'icon' => '💌',
                'tag' => 'Produk Utama',
                'slug' => 'undangan-nikahan-online',
                'title' => 'Undangan Nikahan Online',
                'description' => 'Undangan digital cantik dan praktis untuk pasangan yang ingin membagikan undangan lewat link tanpa ribet cetak.',
                'features' => [
                    'Desain modern dan responsif',
                    'Bisa dibagikan lewat WhatsApp',
                    'Cocok untuk acara nikahan',
                ],
                'price' => 'Mulai Rp49.000',
                'button' => 'Lihat Detail',
                'button_detail' => 'Kontak WA',
                'contact_url' => 'https://wa.me/6285945155673?text=Halo%20Rangkita,%20saya%20mau%20tanya%20produk%20Undangan%20Nikahan',
                'detail' => [
                    'Undangan nikahan online dari Rangkita dibuat untuk pasangan yang ingin undangan praktis, modern, dan mudah dibagikan.',
                    'Produk ini cocok untuk acara pernikahan, lamaran, akad, resepsi, atau acara keluarga yang ingin punya undangan digital tanpa harus mencetak banyak kertas.',
                    'Nantinya halaman ini bisa dikembangkan lagi dengan fitur galeri foto, lokasi Google Maps, countdown acara, RSVP, dan tombol bagikan ke WhatsApp.',
                ],
            ],
            [
                'icon' => '📘',
                'tag' => 'Edukasi',
                'slug' => 'soal-cpns-latihan-ujian',
                'title' => 'Soal CPNS & Latihan Ujian',
                'description' => 'Paket latihan soal digital untuk bantu pengguna belajar lebih terarah sebelum menghadapi ujian atau seleksi.',
                'features' => [
                    'Paket soal siap latihan',
                    'Cocok untuk belajar mandiri',
                    'Format digital mudah diakses',
                ],
                'price' => 'Segera Hadir',
                'button' => 'Ikuti Update',
                'button_detail' => 'Ikuti Update',
                'contact_url' => '/kontak',
                'detail' => [
                    'Produk soal CPNS dan latihan ujian dibuat untuk membantu pengguna belajar dengan lebih terarah.',
                    'Materi nantinya bisa dibagi menjadi beberapa kategori seperti TWK, TIU, TKP, latihan pembahasan, dan simulasi soal.',
                    'Untuk tahap awal, halaman ini masih berupa konsep produk. Nanti bisa dikembangkan menjadi katalog paket soal atau sistem latihan berbasis web.',
                ],
            ],
            [
                'icon' => '⚡',
                'tag' => 'File Digital',
                'slug' => 'produk-digital',
                'title' => 'Produk Digital',
                'description' => 'Kumpulan file siap pakai seperti template, ebook, checklist, worksheet, desain, dan aset digital lain.',
                'features' => [
                    'File langsung pakai',
                    'Cocok untuk kebutuhan harian',
                    'Praktis dan mudah diunduh',
                ],
                'price' => 'Mulai Rp15.000',
                'button' => 'Jelajahi Produk',
                'button_detail' => 'Kontak WA',
                'contact_url' => 'https://wa.me/6285945155673?text=Halo%20Rangkita,%20saya%20mau%20tanya%20produk',
                'detail' => [
                    'Produk digital Rangkita berisi file siap pakai yang bisa membantu kebutuhan harian pengguna.',
                    'Contohnya bisa berupa template undangan, checklist acara, worksheet, dokumen, ebook, desain, atau file digital lainnya.',
                    'Ke depannya produk digital ini bisa dijual lewat website sendiri, marketplace, atau link pembayaran sederhana.',
                ],
            ],
            [
                'icon' => '📝',
                'tag' => 'Konten',
                'slug' => 'artikel-seo-blog',
                'title' => 'Artikel & SEO Blog',
                'description' => 'Artikel informatif untuk menjawab kebutuhan pengguna sekaligus membantu produk Rangkita ditemukan lewat Google.',
                'features' => [
                    'Konten informatif dan ringan',
                    'Mendukung pencarian Google',
                    'Mengarahkan ke produk relevan',
                ],
                'price' => 'Gratis Dibaca',
                'button' => 'Baca Artikel',
                'button_detail' => 'Lihat Artikel',
                'contact_url' => '/artikel',
                'detail' => [
                    'Artikel dan SEO Blog adalah bagian penting dari Rangkita supaya website bisa ditemukan lewat Google.',
                    'Kontennya bisa membahas tips undangan online, belajar CPNS, produk digital, template, dan solusi kebutuhan digital lainnya.',
                    'Dari artikel, pengguna bisa diarahkan ke produk yang relevan. Jadi artikel bukan cuma bacaan, tapi juga pintu masuk ke ekosistem Rangkita.',
                ],
            ],
        ];
    }
    public function produkDetail($slug)
    {
        $products = $this->getProducts();

        $product = collect($products)->firstWhere('slug', $slug);

        if (!$product) {
            abort(404);
        }

        return view('pages.produk-detail', compact('product'));
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

    public function undangan()
    {
        $templates = $this->getWeddingTemplates();

        return view('pages.undangan', compact('templates'));
    }

    public function templateDetail($slug)
    {
        $templates = $this->getWeddingTemplates();

        $template = collect($templates)->firstWhere('slug', $slug);

        if (!$template) {
            abort(404);
        }

        return view('pages.template-detail', compact('template'));
    }

    private function getWeddingTemplates()
    {
        return [
            [
                'icon' => '✨',
                'slug' => 'elegant',
                'name' => 'Elegant',
                'style' => 'Mewah & Romantis',
                'theme_class' => 'theme-elegant',
                'description' => 'Template dengan nuansa elegan, cocok untuk acara pernikahan formal dan berkesan mewah.',
                'features' => ['Warna lembut', 'Layout clean', 'Cocok untuk resepsi'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Elegant untuk undangan online.',
            ],
            [
                'icon' => '🌿',
                'slug' => 'minimalis',
                'name' => 'Minimalis',
                'style' => 'Simple & Bersih',
                'theme_class' => 'theme-minimalis',
                'description' => 'Template sederhana dengan tampilan rapi, ringan, dan nyaman dibuka dari HP.',
                'features' => ['Tampilan simpel', 'Cepat dibuka', 'Informasi mudah dibaca'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Minimalis untuk undangan online.',
            ],
            [
                'icon' => '🌸',
                'slug' => 'floral',
                'name' => 'Floral',
                'style' => 'Manis & Hangat',
                'theme_class' => 'theme-floral',
                'description' => 'Template bernuansa bunga yang cocok untuk pasangan yang ingin tampilan lembut dan romantis.',
                'features' => ['Nuansa bunga', 'Warna soft', 'Kesan romantis'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Floral untuk undangan online.',
            ],
            [
                'icon' => '🚀',
                'slug' => 'modern',
                'name' => 'Modern',
                'style' => 'Fresh & Kekinian',
                'theme_class' => 'theme-modern',
                'description' => 'Template modern dengan tampilan lebih berani, cocok untuk konsep acara yang lebih santai.',
                'features' => ['Desain kekinian', 'Visual menarik', 'Cocok untuk anak muda'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Modern untuk undangan online.',
            ],
            [
                'icon' => '🪶',
                'slug' => 'classic',
                'name' => 'Classic',
                'style' => 'Elegan & Timeless',
                'theme_class' => 'theme-classic',
                'description' => 'Template undangan dengan nuansa klasik yang elegan, rapi, dan berkesan formal. Cocok untuk acara yang ingin terlihat anggun dan berkelas.',
                'features' => ['Desain elegan', 'Nuansa Klasik', 'Tampilan rapi dan formal'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Classic untuk undangan online.',
            ],
            [
                'icon' => '👑',
                'slug' => 'royal',
                'name' => 'Royal',
                'style' => 'Mewah & Berkelas',
                'theme_class' => 'theme-royal',
                'description' => 'Template undangan dengan nuansa royal yang elegan, mewah, dan berkesan premium. Cocok untuk acara pernikahan yang ingin tampil anggun, formal, dan berkelas.',
                'features' => [
                    'Desain mewah',
                    'Nuansa elegan dan premium',
                    'Cocok untuk konsep pernikahan berkelas'
                ],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Royal untuk undangan online.',
            ],
        ];
    }

    public function templatePreview($slug)
    {
        $templates = $this->getWeddingTemplates();

        $template = collect($templates)->firstWhere('slug', $slug);

        if (!$template) {
            abort(404);
        }

        return view('pages.template-preview', compact('template'));
    }
}
