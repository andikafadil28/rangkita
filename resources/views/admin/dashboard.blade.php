@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Dashboard Admin</h1>
        <p class="page-desc">Halo {{ auth()->user()->name }}, ini ringkasan aktivitas Rangkita.</p>

        <div class="admin-stats">
            <div class="card admin-stat-card stat-blue">
                <strong>{{ number_format($stats['users']) }}</strong>
                <span>Users</span>
            </div>
            <div class="card admin-stat-card stat-purple">
                <strong>{{ number_format($stats['packages']) }}</strong>
                <span>Paket Soal</span>
            </div>
            <div class="card admin-stat-card stat-green">
                <strong>{{ number_format($stats['questions']) }}</strong>
                <span>Total Soal</span>
            </div>
            <div class="card admin-stat-card stat-orange">
                <strong>{{ number_format($stats['categories']) }}</strong>
                <span>Kategori</span>
            </div>
        </div>

        <div class="admin-stats">
            <div class="card admin-stat-card stat-gold">
                <strong>Rp {{ number_format($stats['revenue'], 0, ',', '.') }}</strong>
                <span>Pendapatan</span>
            </div>
            <div class="card admin-stat-card stat-yellow">
                <strong>{{ number_format($stats['pending']) }}</strong>
                <span>Pending</span>
            </div>
            <div class="card admin-stat-card stat-pink">
                <strong>{{ number_format($stats['quizzes']) }}</strong>
                <span>Total Quiz</span>
            </div>
            <div class="card admin-stat-card stat-teal">
                <strong>{{ number_format($stats['access']) }}</strong>
                <span>Akses Diberikan</span>
            </div>
        </div>

        <div class="dashboard-section">
            <div class="dashboard-section-head">
                <h2>Quiz Terbaru</h2>
            </div>

            @if ($recentQuizzes->isEmpty())
                <div class="card admin-empty">Belum ada aktivitas quiz.</div>
            @else
                <div class="history-list">
                    @foreach ($recentQuizzes as $quiz)
                        @php
                            $score = $quiz->score;
                            $scoreClass = $score >= 70 ? 'score-good' : ($score >= 50 ? 'score-mid' : 'score-low');
                        @endphp
                        <div class="card history-item">
                            <div class="history-item-left">
                                <span class="badge badge-soft">{{ $quiz->package->soalCategory->name ?? '-' }}</span>
                                <h3 class="history-package-name">{{ $quiz->package->name }}</h3>
                                <div class="history-meta">
                                    <span class="badge {{ $quiz->mode === 'test' ? '' : 'badge-soft' }}">{{ $quiz->mode === 'test' ? 'Test' : 'Latihan' }}</span>
                                    <span style="color: #8a7fa0; font-size: 13px;">oleh {{ $quiz->user->name }}</span>
                                    <span class="history-date">{{ $quiz->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            <div class="history-item-right">
                                @if ($score !== null)
                                    <div class="history-score {{ $scoreClass }}">{{ $score }}</div>
                                    <span class="history-score-label">/ 100</span>
                                @else
                                    <div class="history-score score-mid">-</div>
                                    <span class="history-score-label">belum selesai</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="dashboard-section">
            <div class="dashboard-section-head">
                <h2>Transaksi Terbaru</h2>
            </div>

            @if ($recentTransactions->isEmpty())
                <div class="card admin-empty">Belum ada transaksi.</div>
            @else
                <div class="history-list">
                    @foreach ($recentTransactions as $tx)
                        @php
                            $statusClass = match($tx->status) {
                                'paid' => 'score-good',
                                'pending' => 'score-mid',
                                default => 'score-low',
                            };
                        @endphp
                        <div class="card history-item">
                            <div class="history-item-left">
                                <span class="badge badge-soft">{{ $tx->package->name }}</span>
                                <div class="history-meta">
                                    <span style="color: #8a7fa0; font-size: 13px;">oleh {{ $tx->user->name }}</span>
                                    @if ($tx->payment_type)
                                        <span class="badge badge-soft">{{ strtoupper($tx->payment_type) }}</span>
                                    @endif
                                    <span class="history-date">{{ $tx->created_at->format('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            <div class="history-item-right">
                                <strong style="color: #160b46;">Rp {{ number_format($tx->gross_amount, 0, ',', '.') }}</strong>
                                <span class="badge {{ $tx->status === 'paid' ? '' : 'badge-soft' }}" style="{{ $tx->status === 'paid' ? 'background: #e2f8e9; color: #1c9d4b;' : ($tx->status === 'pending' ? 'background: #fff0dc; color: #c46a00;' : 'background: #ffe3e3; color: #d33;') }}">{{ ucfirst($tx->status) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="dashboard-section">
            <div class="dashboard-section-head">
                <h2>Quick Links</h2>
            </div>

            <div class="admin-menu">
                <a href="{{ route('admin.packages.index') }}" class="card admin-menu-card">
                    <h3>Kelola Soal</h3>
                    <p>CRUD paket dan bank soal TWK, TIU, TKP.</p>
                </a>

                <a href="{{ route('admin.users.index') }}" class="card admin-menu-card">
                    <h3>Kelola Users</h3>
                    <p>Lihat daftar user, promote/demote admin.</p>
                </a>

                <div class="card admin-menu-card is-disabled">
                    <h3>Kelola Undangan</h3>
                    <p>Segera hadir.</p>
                </div>

                <div class="card admin-menu-card is-disabled">
                    <h3>Kelola Artikel</h3>
                    <p>Segera hadir.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
