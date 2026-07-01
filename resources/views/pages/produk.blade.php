@extends('layouts.app')

@section('title', 'Produk - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Produk Rangkita</h1>

        <p class="page-desc">
            Rangkita menyediakan berbagai produk digital yang dirancang untuk membantu
            kebutuhan harian, acara, belajar, dan konten digital dalam satu ekosistem.
        </p>

        <div class="grid">
            <div class="card">
                <div class="card-icon">💌</div>
                <h3>Undangan Online</h3>
                <p>Undangan digital modern yang mudah dibagikan lewat link.</p>
            </div>

            <div class="card">
                <div class="card-icon">📘</div>
                <h3>Soal CPNS</h3>
                <p>Paket latihan soal dan materi untuk persiapan ujian.</p>
            </div>

            <div class="card">
                <div class="card-icon">⚡</div>
                <h3>Produk Digital</h3>
                <p>Template, ebook, checklist, dan file siap pakai.</p>
            </div>

            <div class="card">
                <div class="card-icon">📝</div>
                <h3>Artikel SEO</h3>
                <p>Konten informatif untuk bantu pengguna menemukan solusi.</p>
            </div>
        </div>
    </section>
@endsection
