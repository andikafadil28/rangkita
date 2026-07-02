@extends('layouts.app')

@section('title', 'Undangan Nikahan Online - Rangkita')

@section('content')

    @php
        $waNumber = '6285945155673';

        $basicMessage = 'Halo Rangkita, saya mau pesan Paket Basic Undangan Online.';
        $premiumMessage = 'Halo Rangkita, saya mau pesan Paket Premium Undangan Online.';
        $customMessage = 'Halo Rangkita, saya mau konsultasi Paket Custom Undangan Online.';
        $generalMessage = 'Halo Rangkita, saya mau tanya tentang Undangan Nikahan Online.';

    @endphp

    <section class="wedding-hero">
        <div class="wedding-hero-content">
            <span class="product-tag">💌 Produk Utama Rangkita</span>

            <h1>
                Undangan Nikahan Online yang Cantik, Praktis, dan Mudah Dibagikan.
            </h1>

            <p>
                Buat undangan digital modern untuk acara pernikahan, lamaran, akad,
                atau resepsi. Lebih hemat, lebih cepat dibagikan, dan bisa diakses
                langsung lewat link.
            </p>

            <div class="button-group">
                <a href="#template" class="btn-primary">Lihat Template</a>
                <a href="#paket" class="btn-secondary">Lihat Paket</a>
            </div>
        </div>

        <div class="wedding-preview-card">
            <div class="preview-top">
                <span>Undangan Digital</span>
                <strong>Dika & Nur</strong>
                <small>Minggu, 12 Mei 2028</small>
            </div>

            <div class="preview-info">
                <div>
                    <strong>Akad Nikah</strong>
                    <p>08.00 WIB</p>
                </div>

                <div>
                    <strong>Resepsi</strong>
                    <p>11.00 WIB</p>
                </div>

                <div>
                    <strong>Lokasi</strong>
                    <p>Yogyakarta</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-title">
            <h2>Fitur Undangan Online</h2>
            <p>Fitur yang membantu undangan kamu terlihat rapi, informatif, dan mudah dibagikan.</p>
        </div>

        <div class="grid">
            <div class="card">
                <div class="card-icon">🔗</div>
                <h3>Link Undangan</h3>
                <p>Undangan bisa dibagikan lewat WhatsApp, Instagram, atau media sosial lainnya.</p>
            </div>

            <div class="card">
                <div class="card-icon">📍</div>
                <h3>Google Maps</h3>
                <p>Tamu bisa langsung membuka lokasi acara melalui tombol maps.</p>
            </div>

            <div class="card">
                <div class="card-icon">🖼️</div>
                <h3>Galeri Foto</h3>
                <p>Tampilkan foto pasangan agar undangan terasa lebih personal dan hangat.</p>
            </div>

            <div class="card">
                <div class="card-icon">⏳</div>
                <h3>Countdown Acara</h3>
                <p>Hitung mundur menuju hari bahagia supaya undangan terasa lebih hidup.</p>
            </div>

            <div class="card">
                <div class="card-icon">✅</div>
                <h3>RSVP</h3>
                <p>Tamu bisa memberi konfirmasi kehadiran secara lebih mudah.</p>
            </div>

            <div class="card">
                <div class="card-icon">🎵</div>
                <h3>Musik Background</h3>
                <p>Tambahkan musik untuk memberi suasana romantis di halaman undangan.</p>
            </div>

            <div class="card">
                <div class="card-icon">💬</div>
                <h3>Ucapan Tamu</h3>
                <p>Tamu bisa menuliskan doa dan ucapan untuk pasangan.</p>
            </div>

            <div class="card">
                <div class="card-icon">📱</div>
                <h3>Responsive</h3>
                <p>Tampilan tetap nyaman dibuka dari HP, tablet, atau laptop.</p>
            </div>
        </div>
    </section>

    <section class="section" id="template">
        <div class="section-title">
            <h2>Pilihan Template Undangan</h2>
            <p>Pilih gaya undangan yang paling cocok dengan konsep acara kamu.</p>
        </div>

        <div class="template-grid">
            @foreach ($templates as $template)
                <div class="template-card">
                    <div class="template-preview {{ $template['theme_class'] ?? 'theme-default' }}">
                        <span>{{ $template['icon'] }}</span>
                        <h3>{{ $template['name'] }}</h3>
                        <p>{{ $template['style'] }}</p>
                    </div>

                    <div class="template-content">
                        <h3>Template {{ $template['name'] }}</h3>

                        <p>
                            {{ $template['description'] }}
                        </p>

                        <ul>
                            @foreach ($template['features'] as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>

                        <div class="template-actions">
                            <a href="{{ url('/undangan/template/' . $template['slug']) }}" class="btn-secondary">
                                Preview
                            </a>

                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($template['message']) }}"
                                class="btn-primary" target="_blank" rel="noopener noreferrer">
                                Pilih Template
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section" id="paket">
        <div class="section-title">
            <h2>Paket Undangan</h2>
            <p>Pilih paket sesuai kebutuhan acara kamu.</p>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card">
                <span class="product-tag">Basic</span>
                <h3>Paket Basic</h3>
                <div class="pricing-price">Rp49.000</div>

                <ul>
                    <li>1 halaman undangan online</li>
                    <li>Informasi acara</li>
                    <li>Google Maps</li>
                    <li>Link siap dibagikan</li>
                </ul>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($basicMessage) }}" class="product-action"
                    target="_blank" rel="noopener noreferrer">
                    Pilih Basic
                </a>
            </div>

            <div class="pricing-card featured">
                <span class="product-tag">Paling Cocok</span>
                <h3>Paket Premium</h3>
                <div class="pricing-price">Rp99.000</div>

                <ul>
                    <li>Semua fitur Basic</li>
                    <li>Galeri foto</li>
                    <li>Countdown acara</li>
                    <li>RSVP kehadiran</li>
                    <li>Ucapan tamu</li>
                </ul>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($premiumMessage) }}" class="product-action"
                    target="_blank" rel="noopener noreferrer">
                    Pilih Premium
                </a>
            </div>

            <div class="pricing-card">
                <span class="product-tag">Custom</span>
                <h3>Paket Custom</h3>
                <div class="pricing-price">Diskusi Dulu</div>

                <ul>
                    <li>Desain lebih fleksibel</li>
                    <li>Fitur sesuai kebutuhan</li>
                    <li>Cocok untuk request khusus</li>
                    <li>Konsultasi konsep undangan</li>
                </ul>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($customMessage) }}" class="product-action"
                    target="_blank" rel="noopener noreferrer">
                    Mulai Diskusi
                </a>
            </div>
        </div>
    </section>

    <section class="section" id="cara-pesan">
        <div class="section-title">
            <h2>Cara Pesan</h2>
            <p>Prosesnya simpel, tinggal siapkan data acara kamu.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <span>01</span>
                <h3>Pilih Paket</h3>
                <p>Pilih paket undangan yang paling sesuai dengan kebutuhan acara.</p>
            </div>

            <div class="step-card">
                <span>02</span>
                <h3>Kirim Data</h3>
                <p>Kirim nama pasangan, tanggal acara, lokasi, foto, dan detail acara.</p>
            </div>

            <div class="step-card">
                <span>03</span>
                <h3>Preview</h3>
                <p>Undangan dibuat lalu kamu bisa cek hasil preview terlebih dahulu.</p>
            </div>

            <div class="step-card">
                <span>04</span>
                <h3>Siap Dibagikan</h3>
                <p>Setelah final, undangan siap dibagikan lewat link ke tamu.</p>
            </div>
        </div>
    </section>

    <section class="cta">
        <h2>Siap bikin undangan online?</h2>
        <p>
            Mulai dari undangan sederhana sampai custom, Rangkita bantu rangkai
            undangan digital kamu jadi lebih praktis dan rapi.
        </p>

        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($generalMessage) }}" class="btn-primary"
            target="_blank" rel="noopener noreferrer">
            Pesan Undangan Sekarang
        </a>
    </section>
@endsection
