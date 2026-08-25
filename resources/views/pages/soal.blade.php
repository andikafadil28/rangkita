@extends('layouts.app')

@section('title', 'Soal & Latihan Ujian - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Soal & Latihan Ujian</h1>

        <p class="page-desc">
            Paket soal latihan dengan pembahasan lengkap. Pilih kategori,
            kerjakan mode latihan santai atau mode test dengan timer resmi.
        </p>

        <div class="grid soal-category-grid">
            @forelse ($categories as $cat)
                @php
                    $count = $cat->packages->count();
                @endphp

                <div class="card soal-card">
                    <div class="card-icon">{{ $cat->icon }}</div>

                    <h3>{{ $cat->name }}</h3>

                    <p>{{ $cat->description }}</p>

                    <div class="soal-card-footer">
                        <span class="badge">{{ $count }} paket</span>
                        <a href="{{ route('soal.category', $cat) }}">Lihat Paket &rarr;</a>
                    </div>
                </div>
            @empty
                <div class="card soal-card">
                    <div class="card-icon">📚</div>
                    <h3>Belum Ada Kategori</h3>
                    <p>Kategori soal segera hadir. Pantengin terus ya!</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection
