@extends('layouts.app')

@section('title', $article['title'] . ' - Rangkita')

@section('content')

    <section class="page article-detail-page">
        <a href="/artikel" class="back-link">← Kembali ke Artikel</a>

        <div class="article-detail">
            <div class="article-detail-icon">
                {{ $article['icon'] }}
            </div>

            <span class="article-category">
                {{ $article['category'] }}
            </span>

            <h1 class="page-title">
                {{ $article['title'] }}
            </h1>

            <div class="article-meta">
                <span>{{ $article['read_time'] }}</span>
                <span>•</span>
                <span>Rangkita Digital</span>
            </div>

            <p class="page-desc">
                {{ $article['description'] }}
            </p>

            <div class="article-content">
                @foreach ($article['content'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>
        </div>
    </section>
@endsection
