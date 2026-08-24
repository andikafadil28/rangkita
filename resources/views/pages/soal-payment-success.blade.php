@extends('layouts.app')

@section('title', 'Pembayaran - Rangkita')

@section('content')
    <section class="page payment-page">
        <div class="card payment-card payment-success-card">
            <div class="success-icon">✅</div>

            @if ($package)
                <h1 class="payment-title">Pembayaran Berhasil!</h1>

                <p class="page-desc">
                    Selamat! Akses ke paket <strong>{{ $package->name }}</strong> udah aktif.
                    Gas kerjain soalnya sekarang!
                </p>

                <div class="quiz-submit-row">
                    <a href="{{ route('soal.quiz', [$package, 'mode' => 'latihan']) }}" class="btn-secondary">
                        Mode Latihan
                    </a>
                    <a href="{{ route('soal.quiz', [$package, 'mode' => 'test']) }}" class="btn-primary">
                        Mulai Quiz
                    </a>
                </div>
            @else
                <h1 class="payment-title">Terima Kasih!</h1>

                <p class="page-desc">
                    Transaksimu lagi diproses. Akses bakal aktif otomatis begitu pembayaran terkonfirmasi.
                    Refresh halaman ini beberapa saat lagi buat cek status.
                </p>

                <div class="quiz-submit-row">
                    <a href="{{ route('soal.index') }}" class="btn-primary">
                        Kembali ke Halaman Soal
                    </a>
                </div>
            @endif

            <p class="payment-note">
              Punya kendala pembayaran? Hubungi kami lewat halaman <a href="/kontak">Kontak</a>.
            </p>
        </div>
    </section>
@endsection
