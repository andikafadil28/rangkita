@extends('layouts.app')

@section('title', 'Riwayat Quiz - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">Riwayat Quiz</h1>

        <p class="page-desc">
            Semua quiz yang pernah kamu kerjakan. Klik "Lihat Hasil" buat lihat breakdown jawaban dan pembahasan.
        </p>

        @if ($sessions->isEmpty())
            <div class="history-empty card">
                <p>Belum ada riwayat quiz.</p>
                <a href="{{ route('soal.index') }}" class="btn-primary">Mulai Kerjakan Soal</a>
            </div>
        @else
            <div class="history-list">
                @foreach ($sessions as $session)
                    @php
                        $cat = $session->package->soalCategory;
                        $score = $session->score;
                        $scoreClass = $score >= 70 ? 'score-good' : ($score >= 50 ? 'score-mid' : 'score-low');
                    @endphp

                    <div class="card history-item">
                        <div class="history-item-left">
                            <span class="history-category badge badge-soft">{{ $cat->name }}</span>
                            <h3 class="history-package-name">{{ $session->package->name }}</h3>
                            <div class="history-meta">
                                <span class="badge {{ $session->mode === 'test' ? '' : 'badge-soft' }}">
                                    {{ $session->mode === 'test' ? 'Test' : 'Latihan' }}
                                </span>
                                <span class="history-date">{{ $session->created_at->format('d M Y, H:i') }}</span>
                                @if ($session->time_spent)
                                    <span class="history-time">{{ intdiv($session->time_spent, 60) }}m {{ $session->time_spent % 60 }}d</span>
                                @endif
                            </div>
                        </div>

                        <div class="history-item-right">
                            <div class="history-score {{ $scoreClass }}">{{ $score }}</div>
                            <span class="history-score-label">/ 100</span>
                            <a href="{{ route('soal.result', $session) }}" class="btn-secondary btn-sm">Lihat Hasil &rarr;</a>
                        </div>
                    </div>
                @endforeach
            </div>

            @include('admin.partials.pagination', ['paginator' => $sessions])
        @endif
    </section>
@endsection
