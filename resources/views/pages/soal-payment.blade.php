@extends('layouts.app')

@section('title', 'Beli ' . $package->name . ' - Rangkita')

@section('content')
    <section class="page payment-page">
        <div class="card payment-card">
            <div class="card-icon">📘</div>

            <h1 class="payment-title">{{ $package->name }}</h1>

            <div class="soal-package-meta">
                <span class="badge">{{ $package->total_questions }} soal</span>
                <span class="badge badge-soft">Tingkat: {{ ucfirst($package->difficulty) }}</span>
            </div>

            <p class="payment-price">
                Rp{{ number_format($package->price, 0, ',', '.') }}
                <span>/ akses selamanya</span>
            </p>

            <ul class="payment-benefits">
                <li>✓ Akses penuh ke semua soal paket ini</li>
                <li>✓ Pembahasan lengkap tiap soal</li>
                <li>✓ Mode latihan & mode test dengan timer</li>
                <li>✓ Bayar sekali, akses tanpa batas waktu</li>
            </ul>

            <button type="button" class="btn-primary btn-lg" id="payButton">
                Bayar Sekarang
            </button>

            <p class="payment-note">
                Pembayaran aman via Midtrans (transfer bank, e-wallet, QRIS, atau kartu).
                Akses langsung aktif setelah pembayaran berhasil.
            </p>
        </div>
    </section>

    <script
        src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}"
        data-client-key="{{ $clientKey }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var payButton = document.getElementById('payButton');

            payButton.addEventListener('click', function () {
                payButton.disabled = true;
                payButton.textContent = 'Membuka halaman pembayaran...';

                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function (result) {
                        window.location.href =
                            '{{ route('payment.success') }}?order_id=' + encodeURIComponent(result.order_id);
                    },
                    onPending: function (result) {
                        window.location.href =
                            '{{ route('payment.success') }}?order_id=' + encodeURIComponent(result.order_id);
                    },
                    onError: function () {
                        payButton.disabled = false;
                        payButton.textContent = 'Bayar Sekarang';
                        alert('Terjadi kesalahan saat memproses pembayaran. Coba lagi ya.');
                    },
                    onClose: function () {
                        payButton.disabled = false;
                        payButton.textContent = 'Bayar Sekarang';
                    }
                });
            });
        });
    </script>
@endsection
