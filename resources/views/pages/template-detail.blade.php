@extends('layouts.app')

@section('title', 'Template ' . $template['name'] . ' - Rangkita')

@section('content')
    @php
        $waNumber = '6285945155673';
    @endphp

    <section class="page template-detail-page">
        <a href="/undangan#template" class="back-link">← Kembali ke Template</a>

        <div class="template-detail-layout">
            <div class="template-phone-preview">
                <div class="phone-screen">
                    <div class="phone-template-hero {{ $template['theme_class'] ?? 'theme-default' }}">
                        <span>{{ $template['icon'] }}</span>
                        <p>The Wedding Of</p>
                        <h2>Dika & Nur</h2>
                        <small>Minggu, 12 Mei 2028</small>
                    </div>

                    <div class="phone-section intro-section">
                        <p>
                            Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i
                            untuk hadir dalam hari bahagia kami.
                        </p>
                    </div>

                    <div class="phone-section couple-section">
                        <div class="couple-photo">D</div>

                        <h3>Dika Putra</h3>
                        <p>Putra dari Bapak & Ibu</p>

                        <span>&</span>

                        <div class="couple-photo">N</div>

                        <h3>Nur Aini</h3>
                        <p>Putri dari Bapak & Ibu</p>
                    </div>

                    <div class="phone-section event-section">
                        <h3>Detail Acara</h3>

                        <div class="event-mini-card">
                            <strong>Akad Nikah</strong>
                            <p>08.00 WIB</p>
                            <small>Yogyakarta</small>
                        </div>

                        <div class="event-mini-card">
                            <strong>Resepsi</strong>
                            <p>11.00 WIB</p>
                            <small>Yogyakarta</small>
                        </div>
                    </div>

                    <div class="phone-section gallery-section">
                        <h3>Galeri</h3>

                        <div class="gallery-grid">
                            <div></div>
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                    </div>

                    <div class="phone-section location-section">
                        <h3>Lokasi Acara</h3>
                        <p>Gedung Serbaguna, Yogyakarta</p>

                        <button type="button">Buka Google Maps</button>
                    </div>

                    <div class="phone-section wishes-section">
                        <h3>Ucapan Tamu</h3>

                        <div class="wish-card">
                            <strong>Andi</strong>
                            <p>Semoga menjadi keluarga yang bahagia selalu.</p>
                        </div>

                        <div class="wish-card">
                            <strong>Siti</strong>
                            <p>Selamat menempuh hidup baru ya!</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="template-detail-content">
                <span class="product-tag">Template {{ $template['name'] }}</span>

                <h1 class="page-title">
                    {{ $template['name'] }}
                </h1>

                <p class="page-desc">
                    {{ $template['description'] }}
                </p>

                <div class="product-detail-section">
                    <h3>Gaya Template</h3>
                    <p>{{ $template['style'] }}</p>
                </div>

                <div class="product-detail-section">
                    <h3>Fitur Template</h3>

                    <ul>
                        @foreach ($template['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="product-detail-section">
                    <h3>Cocok Untuk</h3>

                    <p>
                        Template ini cocok untuk pasangan yang ingin undangan online
                        dengan tampilan {{ strtolower($template['style']) }} dan tetap nyaman
                        dibuka dari HP.
                    </p>
                </div>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($template['message']) }}" class="btn-primary"
                    target="_blank" rel="noopener noreferrer">
                    Pilih Template Ini
                </a>
            </div>
        </div>
    </section>
@endsection
