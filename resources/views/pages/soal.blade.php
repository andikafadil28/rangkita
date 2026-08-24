@extends('layouts.app')

@section('title', 'Soal & Latihan Ujian - Rangkita')

@php
    $categories = \App\Http\Controllers\SoalController::CATEGORIES;

    $categoryMeta = [
        'twk' => [
            'icon' => '🇮🇩',
            'desc' => 'Nasionalisme, integritas, bela negara, pilar negara, dan bahasa Indonesia.',
        ],
        'tiu' => [
            'icon' => '🧠',
            'desc' => 'Kemampuan verbal, numerik, penalaran logis, dan analitis.',
        ],
        'tkp' => [
            'icon' => '🎯',
            'desc' => 'Pelayanan publik, kejujuran, komitmen, disiplin, dan kerja sama.',
        ],
    ];
@endphp

@section('content')
    <section class="page">
        <h1 class="page-title">Soal & Latihan Ujian</h1>

        <p class="page-desc">
            Paket soal latihan dengan pembahasan lengkap. Pilih kategori,
            kerjakan mode latihan santai atau mode test dengan timer resmi.
        </p>

        <div class="grid soal-category-grid">
            @foreach ($categories as $key => $label)
                @php
                    $meta = $categoryMeta[$key];
                    $count = $packages->get($key, collect())->count();
                @endphp

                <div class="card soal-card">
                    <div class="card-icon">{{ $meta['icon'] }}</div>

                    <h3>{{ $label }}</h3>

                    <p>{{ $meta['desc'] }}</p>

                    <div class="soal-card-footer">
                        <span class="badge">{{ $count }} paket</span>
                        <a href="{{ route('soal.category', $key) }}">Lihat Paket →</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection
