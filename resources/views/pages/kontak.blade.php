@extends('layouts.app')

@section('title', 'Kontak - Rangkita')

@section('content')
    @php
        $waNumber = '6285945155673';
        $waMessage = 'Halo Rangkita, saya mau tanya tentang produk digital Rangkita.';
    @endphp

    <section class="contact-hero">
        <div class="contact-hero-content">
            <span class="product-tag">📞 Kontak Rangkita</span>

            <h1>Butuh bantuan atau mau tanya produk?</h1>

            <p>
                Hubungi Rangkita untuk tanya undangan online, produk digital,
                latihan soal, kerja sama, atau kebutuhan digital lainnya.
            </p>

            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" class="btn-primary" target="_blank"
                rel="noopener noreferrer">
                Chat WhatsApp Sekarang
            </a>
        </div>

        <div class="contact-highlight-card">
            <h3>Respon Cepat</h3>
            <p>
                Untuk pemesanan undangan online atau pertanyaan produk,
                WhatsApp adalah jalur tercepat.
            </p>

            <div class="contact-mini-info">
                <strong>Jam Respon</strong>
                <span>09.00 - 21.00 WIB</span>
            </div>

            <div class="contact-mini-info">
                <strong>Lokasi</strong>
                <span>Yogyakarta, Indonesia</span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="section-title">
            <h2>Hubungi Kami</h2>
            <p>Pilih kontak yang paling nyaman buat kamu.</p>
        </div>

        <div class="contact-grid">
            <div class="contact-card">
                <div class="card-icon">📱</div>
                <h3>WhatsApp</h3>
                <p>Untuk tanya produk, pesan undangan, atau konsultasi kebutuhan digital.</p>

                <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode($waMessage) }}" target="_blank"
                    rel="noopener noreferrer">
                    Chat WhatsApp →
                </a>
            </div>

            <div class="contact-card">
                <div class="card-icon">📧</div>
                <h3>Email</h3>
                <p>Untuk kerja sama, pertanyaan resmi, atau kebutuhan yang lebih detail.</p>

                <a href="mailto:andikafadil28@gmail.com">
                    halo@rangkita.id →
                </a>
            </div>

            <div class="contact-card">
                <div class="card-icon">📸</div>
                <h3>Instagram</h3>
                <p>Lihat update produk, contoh desain, dan konten terbaru Rangkita.</p>

                <a href="https://www.instagram.com/andikafep123/" target="_blank" rel="noopener noreferrer">
                    Kunjungi Instagram →
                </a>
            </div>

            <div class="contact-card">
                <div class="card-icon">🛒</div>
                <h3>Marketplace</h3>
                <p>Nantinya produk digital Rangkita juga bisa tersedia di marketplace.</p>

                <a href="#" target="_blank" rel="noopener noreferrer">
                    Lihat Produk →
                </a>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="contact-layout">
            <div class="contact-form-box">
                <span class="product-tag">📝 Form Kontak</span>

                <h2>Kirim Pertanyaan</h2>

                <p>
                    Form ini sementara masih dummy untuk tampilan.
                    Nanti bisa kita sambungkan ke backend Laravel.
                </p>

                <form id="contactForm" onsubmit="sendToWhatsapp(event)">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" id="name" placeholder="Masukkan nama kamu" required>
                    </div>

                    <div class="form-group">
                        <label>Email / WhatsApp</label>
                        <input type="text" id="contact" placeholder="Contoh: 0812xxxx" required>
                    </div>

                    <div class="form-group">
                        <label>Topik</label>
                        <select id="topic" required>
                            <option value="Undangan Online">Undangan Online</option>
                            <option value="Produk Digital">Produk Digital</option>
                            <option value="Soal CPNS">Soal CPNS</option>
                            <option value="Artikel / Kerja Sama">Artikel / Kerja Sama</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea id="message" rows="5" placeholder="Tulis pesan kamu di sini" required></textarea>
                    </div>

                    <button type="submit" class="btn-primary">
                        Kirim Pesan
                    </button>
                </form>
            </div>

            <div class="contact-info-box">
                <h2>Info Cepat</h2>

                <div class="info-list">
                    <div>
                        <strong>Produk utama</strong>
                        <p>Undangan nikahan online.</p>
                    </div>

                    <div>
                        <strong>Produk lain</strong>
                        <p>Produk digital, artikel, dan latihan soal.</p>
                    </div>

                    <div>
                        <strong>Estimasi respon</strong>
                        <p>Biasanya dibalas secepatnya saat jam aktif.</p>
                    </div>

                    <div>
                        <strong>Catatan</strong>
                        <p>Untuk pemesanan, siapkan data acara atau kebutuhan produk.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const contactForm = document.getElementById('contactForm');

        contactForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const waNumber = '{{ $waNumber }}';

            const name = document.getElementById('name').value;
            const contact = document.getElementById('contact').value;
            const topic = document.getElementById('topic').value;
            const message = document.getElementById('message').value;

            if (message.length < 10) {
                alert('Pesan terlalu pendek bro, isi lebih detail dulu ya.');
                return;
            }

            const text =
                `Halo Rangkita, saya mau tanya.\n\n` +
                `Nama: ${name}\n` +
                `Kontak: ${contact}\n` +
                `Topik: ${topic}\n` +
                `Pesan: ${message}`;

            const whatsappUrl = `https://wa.me/${waNumber}?text=${encodeURIComponent(text)}`;

            window.open(whatsappUrl, '_blank');
        });
    </script>
@endsection
