@extends('layouts.app')

@section('title', 'Template ' . $template['name'] . ' - Rangkita')

@section('content')
    <section class="page template-detail-page">
        <a href="/undangan#template" class="back-link">← Kembali ke Template</a>

        <div class="template-detail-layout">
            <div class="template-phone-preview">
                <div class="phone-screen">
                    <div class="phone-template-hero {{ $template['theme_class'] ?? 'theme-default' }}">
                        <span>{{ $template['icon'] }}</span>
                        <p>The Wedding Of</p>
                        <h2>{{ $wedding['groom']['short_name'] }} & {{ $wedding['bride']['short_name'] }}</h2>
                        <small>{{ $wedding['date'] }}</small>
                    </div>

                    <div class="phone-section intro-section">
                        <p>
                            Dengan penuh rasa syukur, kami mengundang Bapak/Ibu/Saudara/i
                            untuk hadir dalam hari bahagia kami.
                        </p>
                    </div>

                    <div class="phone-section couple-section">
                        <div class="couple-photo">{{ $wedding['groom']['initial'] }}</div>

                        <h3>{{ $wedding['groom']['full_name'] }}</h3>
                        <p>{{ $wedding['groom']['parent'] }}</p>

                        <span>&</span>

                        <div class="couple-photo">{{ $wedding['bride']['initial'] }}</div>

                        <h3>{{ $wedding['bride']['full_name'] }}</h3>
                        <p>{{ $wedding['bride']['parent'] }}</p>
                    </div>

                    <div class="phone-section event-section">
                        <h3>Detail Acara</h3>

                        <div class="event-mini-card">
                            <strong>{{ $wedding['akad']['title'] }}</strong>
                            <p>{{ $wedding['akad']['time'] }}</p>
                            <small>{{ $wedding['akad']['place'] }}</small>
                        </div>

                        <div class="event-mini-card">
                            <strong>{{ $wedding['resepsi']['title'] }}</strong>
                            <p>{{ $wedding['resepsi']['time'] }}</p>
                            <small>{{ $wedding['resepsi']['place'] }}</small>
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
                        <p>{{ $wedding['akad']['place'] }}, {{ $wedding['akad']['address'] }}</p>

                        <a href="{{ $wedding['maps_url'] }}" target="_blank" rel="noopener noreferrer">Buka Google Maps</a>
                    </div>

                    <div class="phone-section wishes-section">
                        <h3>Ucapan Tamu</h3>

                        @foreach ($wedding['wishes'] as $wish)
                            <div class="wish-card">
                                <strong>{{ $wish['name'] }}</strong>
                                <p>{{ $wish['message'] }}</p>
                            </div>
                        @endforeach
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
