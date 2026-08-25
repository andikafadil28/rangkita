@extends('layouts.app')

@section('title', $category->name . ' - Rangkita')

@section('content')
    <section class="page">
        <h1 class="page-title">{{ $category->name }}</h1>

        <p class="page-desc">
            {{ $category->description }}
            <br>
            Pilih paket soal, lalu kerjakan lewat mode latihan atau mode test.
            Mode test pakai timer sesuai durasi resmi seleksi.
        </p>

        <div class="soal-package-list">
            @forelse ($packages as $package)
                @php
                    $owned = $ownedIds->contains($package->id);
                    $canStart = $package->isFree() || $owned;
                    $price = $package->isFree()
                        ? 'Gratis'
                        : 'Rp' . number_format($package->price, 0, ',', '.');
                @endphp

                <div class="card soal-package-card">
                    <div class="soal-package-info">
                        <h3>{{ $package->name }}</h3>

                        <div class="soal-package-meta">
                            <span class="badge">{{ $package->total_questions }} soal</span>
                            <span class="badge badge-soft">Tingkat: {{ ucfirst($package->difficulty) }}</span>
                            <span class="badge {{ $package->isFree() ? 'badge-success' : 'badge-price' }}">{{ $price }}</span>
                            @if ($owned && ! $package->isFree())
                                <span class="badge badge-success">✓ Sudah dibeli</span>
                            @endif
                        </div>
                    </div>

                    <div class="soal-package-actions">
                        @if ($canStart)
                            <a href="{{ route('soal.quiz', [$package, 'mode' => 'latihan']) }}" class="btn-secondary">
                                Mode Latihan
                            </a>
                            <a href="{{ route('soal.quiz', [$package, 'mode' => 'test']) }}" class="btn-primary">
                                Mode Test
                            </a>
                        @else
                            <span class="soal-lock-note">Kunci akses lewat pembayaran sekali beli.</span>
                            <a href="{{ route('payment.create', $package) }}" class="btn-primary">
                                Beli & Mulai
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="card soal-package-card">
                    <div class="soal-package-info">
                        <h3>Belum ada paket</h3>
                        <p>Paket untuk kategori ini segera hadir. Pantengin terus ya!</p>
                    </div>
                </div>
            @endforelse
        </div>

        <a href="{{ route('soal.index') }}" class="back-link">&larr; Kembali ke semua kategori</a>
    </section>
@endsection
