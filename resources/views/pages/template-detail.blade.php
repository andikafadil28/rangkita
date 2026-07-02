@extends('layouts.app')

@section('title', 'Template ' . $template['name'] . ' - Rangkita')

@section('content')
    @php
        $waNumber = '6281234567890';
    @endphp

    <section class="page template-detail-page">
        <a href="/undangan#template" class="back-link">← Kembali ke Template</a>

        <div class="template-detail-layout">
            <div class="template-phone-preview">
                <div class="phone-screen">
                    <div class="phone-template-hero">
                        <span>{{ $template['icon'] }}</span>
                        <p>The Wedding Of</p>
                        <h2>Dika & Nur</h2>
                        <small>Minggu, 12 Mei 2028</small>
                    </div>

                    <div class="phone-template-info">
                        <strong>Akad Nikah</strong>
                        <p>08.00 WIB - Yogyakarta</p>

                        <strong>Resepsi</strong>
                        <p>11.00 WIB - Yogyakarta</p>
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

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($template['message']) }}" class="btn-primary"
                    target="_blank" rel="noopener noreferrer">
                    Pilih Template Ini
                </a>
            </div>
        </div>
    </section>
@endsection
