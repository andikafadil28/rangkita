@extends('layouts.app')

@section('title', $product['title'] . ' - Rangkita')

@section('content')
    <section class="page product-detail-page">
        <a href="/produk" class="back-link">← Kembali ke Produk</a>

        <div class="product-detail">
            <div class="product-detail-icon">
                {{ $product['icon'] }}
            </div>

            <span class="product-tag">
                {{ $product['tag'] }}
            </span>

            <h1 class="page-title">
                {{ $product['title'] }}
            </h1>

            <p class="page-desc">
                {{ $product['description'] }}
            </p>

            <div class="product-detail-price">
                {{ $product['price'] }}
            </div>

            <div class="product-detail-section">
                <h3>Fitur Utama</h3>

                <ul>
                    @foreach ($product['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>

            <div class="product-detail-section">
                <h3>Detail Produk</h3>

                @foreach ($product['detail'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            <a href="{{ $product['contact_url'] }}" class="btn-primary" @if (str_starts_with($product['contact_url'], 'http')) target="_blank" rel="noopener noreferrer" @endif>
                {{ $product['button_detail'] }}
            </a>
        </div>
    </section>
@endsection
