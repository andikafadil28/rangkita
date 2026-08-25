@extends('layouts.app')

@section('title', 'Dashboard - Rangkita')

@section('content')
    <section class="page">
        <div class="dashboard-header">
            <div>
                <h1 class="page-title">Halo, {{ $user->name }}!</h1>
                <p class="page-desc" style="margin-bottom: 0;">
                    Ringkasan aktivitas quiz kamu.
                </p>
            </div>
            <a href="{{ route('soal.index') }}" class="btn-primary">Kerjakan Soal</a>
        </div>

        <div class="dashboard-stats">
            <div class="card stat-box stat-correct">
                <strong>{{ $stats['total'] }}</strong>
                <span>Total Quiz</span>
            </div>
            <div class="card stat-box" style="background: #efe9ff; color: #7138f6;">
                <strong>{{ $stats['avgScore'] }}</strong>
                <span>Rata-rata Skor</span>
            </div>
            <div class="card stat-box" style="background: #fff0dc; color: #c46a00;">
                <strong>{{ $stats['bestScore'] }}</strong>
                <span>Skor Tertinggi</span>
            </div>
        </div>

        @if ($recentSessions->isEmpty())
            <div class="history-empty card">
                <p>Belum ada riwayat quiz.</p>
            </div>
        @else
            <div class="dashboard-section">
                <div class="dashboard-section-head">
                    <h2>Riwayat Terbaru</h2>
                    <a href="{{ route('soal.history') }}" class="btn-link">Lihat Semua &rarr;</a>
                </div>

                <div class="history-list">
                    @foreach ($recentSessions as $session)
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
            </div>
        @endif

        <div class="dashboard-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-secondary" style="border: none; cursor: pointer;">Keluar</button>
            </form>
        </div>
    </section>
@endsection
