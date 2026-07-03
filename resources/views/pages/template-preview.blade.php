<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Template {{ $template['name'] }} - Rangkita</title>

    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
</head>

<body class="wedding-preview-body {{ $template['theme_class'] ?? 'theme-default' }}">

    <a href="/undangan#template" class="preview-back-button">
        ← Kembali
    </a>

    <section class="invitation-cover">
        <div class="invitation-cover-inner">
            <span class="preview-label">The Wedding Of</span>

            <div class="preview-icon">
                {{ $template['icon'] }}
            </div>

            <h1>{{ $wedding['groom']['short_name'] }} & {{ $wedding['bride']['short_name'] }}</h1>

            <p>{{ $wedding['date'] }}</p>

            <a href="#opening" class="open-invitation-button">
                Buka Undangan
            </a>
        </div>
    </section>

    <section class="invitation-section invitation-opening" id="opening">
        <span class="section-small-title">Assalamu’alaikum Warahmatullahi Wabarakatuh</span>

        <h2>Dengan penuh rasa syukur</h2>

        <p>
            Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i
            untuk hadir dan memberikan doa restu pada acara pernikahan kami.
        </p>
    </section>

    <section class="invitation-section couple-preview-section">
        <div class="couple-preview-card">
            <div class="couple-avatar">{{ $wedding['groom']['initial'] }}</div>
            <h3>{{ $wedding['groom']['full_name'] }}</h3>
            <p>{{ $wedding['groom']['parent'] }}</p>
        </div>

        <div class="couple-divider">&</div>

        <div class="couple-preview-card">
            <div class="couple-avatar">{{ $wedding['bride']['initial'] }}</div>
            <h3>{{ $wedding['bride']['full_name'] }}</h3>
            <p>{{ $wedding['bride']['parent'] }}</p>
        </div>
    </section>

    <section class="invitation-section event-preview-section">
        <span class="section-small-title">Save The Date</span>

        <h2>Detail Acara</h2>

        <div class="event-preview-grid">
            <div class="event-preview-card">
                <h3>{{ $wedding['akad']['title'] }}</h3>
                <strong>{{ $wedding['akad']['time'] }}</strong>
                <p>{{ $wedding['akad']['date'] }}</p>
                <small>{{ $wedding['akad']['place'] }}</small>
            </div>

            <div class="event-preview-card">
                <h3>{{ $wedding['resepsi']['title'] }}</h3>
                <strong>{{ $wedding['resepsi']['time'] }}</strong>
                <p>{{ $wedding['resepsi']['date'] }}</p>
                <small>{{ $wedding['resepsi']['place'] }}</small>
            </div>
        </div>
    </section>

    <section class="invitation-section countdown-preview-section">
        <span class="section-small-title">Menuju Hari Bahagia</span>

        <h2>Countdown Acara</h2>

        <div class="countdown-grid">
            <div>
                <strong>120</strong>
                <span>Hari</span>
            </div>

            <div>
                <strong>12</strong>
                <span>Jam</span>
            </div>

            <div>
                <strong>45</strong>
                <span>Menit</span>
            </div>

            <div>
                <strong>30</strong>
                <span>Detik</span>
            </div>
        </div>
    </section>

    <section class="invitation-section gallery-preview-section">
        <span class="section-small-title">Our Moments</span>

        <h2>Galeri Foto</h2>

        <div class="preview-gallery-grid">
            @foreach ($wedding['gallery'] as $photo)
                <div>
                    <span>{{ $photo }}</span>
                </div>
            @endforeach
        </div>
    </section>

    <section class="invitation-section location-preview-section">
        <span class="section-small-title">Lokasi Acara</span>

        <h2>{{ $wedding['akad']['place'] }}</h2>

        <p>
            {{ $wedding['akad']['address'] }}
        </p>

        <a href="#" class="open-invitation-button">
            Buka Google Maps
        </a>
    </section>

    <section class="invitation-section wishes-preview-section">
        <span class="section-small-title">Ucapan & Doa</span>

        <h2>Doa dari Tamu</h2>

        @foreach ($wedding['wishes'] as $wish)
            <div class="wish-preview-card">
                <strong>{{ $wish['name'] }}</strong>
                <p>{{ $wish['message'] }}</p>
            </div>
        @endforeach

        <form class="wish-preview-form">
            <input type="text" placeholder="Nama kamu">
            <textarea rows="4" placeholder="Tulis ucapan kamu"></textarea>
            <button type="button">Kirim Ucapan</button>
        </form>
    </section>

    <section class="invitation-section closing-preview-section">
        <h2>Terima Kasih</h2>

        <p>
            Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila
            Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.
        </p>

        <h3>{{ $wedding['groom']['short_name'] }} & {{ $wedding['bride']['short_name'] }}</h3>
    </section>

</body>

</html>
