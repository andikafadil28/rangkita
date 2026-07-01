@extends('layouts.app')

@section('title', 'Artikel - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Artikel Rangkita</h1>

        <p class="page-desc">
            Halaman ini nanti akan dipakai untuk artikel SEO, tips undangan online,
            tips belajar CPNS, rekomendasi produk digital, dan konten informatif lainnya.
        </p>

        <div class="grid">
            <div class="card">
                <div class="card-icon">📝</div>
                <h3>Cara Memilih Undangan Online</h3>
                <p>Tips awal memilih undangan digital yang cocok untuk acara nikahan.</p>
            </div>

            <div class="card">
                <div class="card-icon">📘</div>
                <h3>Tips Belajar CPNS</h3>
                <p>Strategi belajar yang lebih rapi supaya persiapan ujian gak asal jalan.</p>
            </div>

            <div class="card">
                <div class="card-icon">⚡</div>
                <h3>Manfaat Produk Digital</h3>
                <p>Kenapa file digital bisa bantu kerjaan harian jadi lebih cepat.</p>
            </div>

            <div class="card">
                <div class="card-icon">🚀</div>
                <h3>Rangkita Digital</h3>
                <p>Cerita tentang ekosistem Rangkita dan rencana pengembangannya.</p>
            </div>
        </div>
    </section>
@endsection
