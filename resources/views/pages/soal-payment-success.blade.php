@extends('layouts.app')

@section('title', 'Status Pembayaran - Rangkita')

@section('content')
    <section class="page payment-page">
        <div class="card payment-card payment-success-card">
            @if ($status === 'paid')
                <div class="success-icon">✅</div>

                <h1 class="payment-title">Pembayaran Berhasil!</h1>

                @if ($package)
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
                    <p class="page-desc">Pembayaranmu udah kami terima.</p>
                @endif
            @elseif ($status === 'pending')
                <div class="success-icon">⏳</div>

                <h1 class="payment-title">Pembayaran Belum Selesai</h1>

                <p class="page-desc">
                    Kamu keluar sebelum menyelesaikan pembayaran
                    @if ($package)
                        untuk paket <strong>{{ $package->name }}</strong>.
                    @endif

                    Kalau kamu sudah bayar, akses aktif otomatis dalam beberapa menit
                    setelah pembayaran terkonfirmasi.
                </p>

                @if ($package)
                    <div class="quiz-submit-row">
                        <a href="{{ route('payment.create', $package) }}" class="btn-primary">
                            Lanjut Bayar
                        </a>
                        <a href="{{ route('soal.category', $package->soalCategory) }}" class="btn-secondary">
                            Nanti Saja
                        </a>
                    </div>
                @else
                    <div class="quiz-submit-row">
                        <a href="{{ route('soal.index') }}" class="btn-primary">
                            Kembali ke Halaman Soal
                        </a>
                    </div>
                @endif
            @else
                <div class="success-icon">❌</div>

                <h1 class="payment-title">{{ $status === 'expired' ? 'Transaksi Kedaluwarsa' : ($status ? 'Transaksi Gagal' : 'Belum Ada Transaksi') }}</h1>

                <p class="page-desc">
                    @if ($status === 'expired')
                        Waktu pembayaran habis. Tenang, kamu bisa mulai transaksi baru kapan saja.
                    @elseif ($status)
                        Transaksi tidak bisa diproses. Silakan coba lagi.
                    @else
                        Kamu belum punya transaksi pembayaran yang sedang berjalan.
                    @endif
                </p>

                <div class="quiz-submit-row">
                    <a href="{{ route('soal.index') }}" class="btn-primary">
                        Lihat Paket Soal
                    </a>
                </div>
            @endif

            <p class="payment-note">
              Punya kendala pembayaran? Hubungi kami lewat halaman <a href="/kontak">Kontak</a>.
            </p>
        </div>
    </section>
@endsection
