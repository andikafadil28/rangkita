@extends('layouts.app')

@section('title', 'Kontak - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Kontak Rangkita</h1>

        <p class="page-desc">
            Punya pertanyaan, mau pesan undangan, atau tertarik dengan produk digital Rangkita?
            Kamu bisa hubungi kami lewat kontak yang tersedia.
        </p>

        <div class="grid">
            <div class="card">
                <div class="card-icon">📱</div>
                <h3>WhatsApp</h3>
                <p>Hubungi admin Rangkita untuk tanya produk atau pemesanan.</p>
            </div>

            <div class="card">
                <div class="card-icon">📧</div>
                <h3>Email</h3>
                <p>Kirim pertanyaan kerja sama, produk, atau kebutuhan digital lainnya.</p>
            </div>

            <div class="card">
                <div class="card-icon">📸</div>
                <h3>Instagram</h3>
                <p>Lihat update produk, contoh desain, dan konten terbaru Rangkita.</p>
            </div>

            <div class="card">
                <div class="card-icon">🛒</div>
                <h3>Marketplace</h3>
                <p>Nantinya produk digital Rangkita juga bisa dijual lewat marketplace.</p>
            </div>
        </div>
    </section>
@endsection
