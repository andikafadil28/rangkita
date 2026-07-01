@extends('layouts.app')

@section('title', 'Artikel - Rangkita')

@section('content')
    <section class="page">
        <span class="logo">
            <h1 class="">ARTIKEL RANG<span class="k">K</span><span class="i">I</span><span
                    class="t">T</span><span class="a">A
                    <img src="{{ asset('images/logo-rangkita.png') }}" alt="Logo Rangkita" class="brand-logo">
                </span></h1>
        </span>

        <p class="page-desc">
            Kumpulan artikel informatif seputar undangan online, belajar CPNS,
            produk digital, dan pengembangan ekosistem Rangkita.
        </p>

        <div class="grid">
            @foreach ($articles as $article)
                <div class="card article-card">
                    <div class="card-icon">
                        {{ $article['icon'] }}
                    </div>

                    <span class="article-category">
                        {{ $article['category'] }}
                    </span>

                    <h3>
                        {{ $article['title'] }}
                    </h3>

                    <p>
                        {{ $article['description'] }}
                    </p>

                    <div class="article-footer">
                        <span>{{ $article['read_time'] }}</span>
                        <a href="{{ url('/artikel/' . $article['slug']) }}">Baca Artikel →</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
