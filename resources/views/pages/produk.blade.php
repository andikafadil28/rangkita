@extends('layouts.app')

@section('title', 'Produk - Rangkita')

@section('content')
    <section class="page">
        <span class="logo">
            <h1 class="">PRODUK RANG<span class="k">K</span><span class="i">I</span><span
                    class="t">T</span><span class="a">A
                    <img src="{{ asset('images/logo-rangkita.png') }}" alt="Logo Rangkita" class="brand-logo">
                </span></h1>
        </span>

        <p class="page-desc">
            Rangkita menyediakan berbagai produk digital yang dirancang untuk membantu
            kebutuhan harian, acara, belajar, dan konten digital dalam satu ekosistem.
        </p>

        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <div class="product-icon">
                        {{ $product['icon'] }}
                    </div>

                    <span class="product-tag">
                        {{ $product['tag'] }}
                    </span>

                    <h3>
                        {{ $product['title'] }}
                    </h3>

                    <p>
                        {{ $product['description'] }}
                    </p>

                    <ul>
                        @foreach ($product['features'] as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>

                    <div class="product-price">
                        {{ $product['price'] }}
                    </div>

                    <a href="{{ url('/produk/' . $product['slug']) }}" class="product-action">
                        {{ $product['button'] }}
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endsection
