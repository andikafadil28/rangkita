<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview Template {{ $template['name'] }} - Rangkita</title>

    <link rel="stylesheet" href="{{ asset('css/rangkita.css') }}">
</head>

<body class="wedding-preview-body {{ $template['theme_class'] ?? 'theme-default' }} invitation-locked">

    <a href="/undangan#template" class="preview-back-button">
        ← Kembali
    </a>

    <section class="invitation-cover" id="invitationCover">
        <div class="invitation-cover-inner">
            <span class="preview-label">The Wedding Of</span>

            <div class="preview-icon">
                {{ $template['icon'] }}
            </div>

            <h1>{{ $wedding['groom']['short_name'] }} & {{ $wedding['bride']['short_name'] }}</h1>

            <p>{{ $wedding['date'] }}</p>

            <button type="button" id="openInvitationButton" class="open-invitation-button"
                aria-controls="invitationContent" aria-expanded="false">
                Buka Undangan
            </button>
        </div>
    </section>

    <main id="invitationContent" class="invitation-content" aria-hidden="true">

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

            <div class="countdown-grid" data-target-date="{{ $wedding['countdown_target'] }}">
                <div>
                    <strong id="countdown-days">0</strong>
                    <span>Hari</span>
                </div>

                <div>
                    <strong id="countdown-hours">0</strong>
                    <span>Jam</span>
                </div>

                <div>
                    <strong id="countdown-minutes">0</strong>
                    <span>Menit</span>
                </div>

                <div>
                    <strong id="countdown-seconds">0</strong>
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

            <a href="{{ $wedding['maps_url'] }}" target="_blank" rel="noopener noreferrer" class="open-invitation-button">
                Buka Google Maps
            </a>
        </section>

        <section class="invitation-section wishes-preview-section">
            <span class="section-small-title">Ucapan & Doa</span>

            <h2>Doa dari Tamu</h2>

            <p>
                Tinggalkan ucapan dan doa terbaik untuk
                {{ $wedding['groom']['short_name'] }} &
                {{ $wedding['bride']['short_name'] }}.
            </p>

            <div id="wishesList" class="wishes-list">
                @foreach ($wedding['wishes'] as $wish)
                    <div class="wish-preview-card">
                        <strong>{{ $wish['name'] }}</strong>
                        <p>{{ $wish['message'] }}</p>
                    </div>
                @endforeach
            </div>

            <form id="wishForm" class="wish-preview-form">
                <div class="wish-form-group">
                    <label for="guestName">Nama</label>

                    <input type="text" id="guestName" placeholder="Masukkan nama kamu" maxlength="50"
                        autocomplete="name" required>
                </div>

                <div class="wish-form-group">
                    <label for="guestMessage">Ucapan</label>

                    <textarea id="guestMessage" rows="4" placeholder="Tulis ucapan dan doa terbaik" maxlength="300" required></textarea>
                    <small id="messageCounter" class="message-counter">
                        0 / 300 karakter
                    </small>
                </div>

                <p id="wishFeedback" class="wish-feedback"></p>

                <button type="submit">
                    Kirim Ucapan
                </button>
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
    </main>

</body>

<script>
    const countdownGrid = document.querySelector('.countdown-grid');

    if (countdownGrid) {
        const targetDate = new Date(countdownGrid.dataset.targetDate).getTime();

        const daysElement = document.getElementById('countdown-days');
        const hoursElement = document.getElementById('countdown-hours');
        const minutesElement = document.getElementById('countdown-minutes');
        const secondsElement = document.getElementById('countdown-seconds');

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;

            if (distance <= 0) {
                daysElement.textContent = '0';
                hoursElement.textContent = '0';
                minutesElement.textContent = '0';
                secondsElement.textContent = '0';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance / (1000 * 60 * 60)) % 24);
            const minutes = Math.floor((distance / (1000 * 60)) % 60);
            const seconds = Math.floor((distance / 1000) % 60);

            daysElement.textContent = days;
            hoursElement.textContent = hours;
            minutesElement.textContent = minutes;
            secondsElement.textContent = seconds;
        }

        updateCountdown();

        setInterval(updateCountdown, 1000);
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const body = document.body;
        const invitationCover = document.getElementById('invitationCover');
        const invitationContent = document.getElementById('invitationContent');
        const openInvitationButton =
            document.getElementById('openInvitationButton');
        const openingSection = document.getElementById('opening');

        if (
            !invitationCover ||
            !invitationContent ||
            !openInvitationButton
        ) {
            return;
        }

        openInvitationButton.addEventListener('click', function() {
            openInvitationButton.disabled = true;
            openInvitationButton.textContent = 'Membuka Undangan...';

            invitationCover.classList.add('is-opened');
            invitationContent.classList.add('is-visible');

            invitationContent.setAttribute('aria-hidden', 'false');
            openInvitationButton.setAttribute('aria-expanded', 'true');

            body.classList.remove('invitation-locked');

            window.setTimeout(function() {
                invitationCover.hidden = true;

                if (openingSection) {
                    openingSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 700);
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wishForm = document.getElementById('wishForm');
        const wishesList = document.getElementById('wishesList');
        const guestNameInput = document.getElementById('guestName');
        const guestMessageInput = document.getElementById('guestMessage');
        const wishFeedback = document.getElementById('wishFeedback');
        const messageCounter = document.getElementById('messageCounter');

        if (!wishForm) {
            return;
        }

        guestMessageInput.addEventListener('input', function() {
            const characterCount = guestMessageInput.value.length;

            messageCounter.textContent =
                `${characterCount} / 300 karakter`;
        });

        wishForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const guestName = guestNameInput.value.trim();
            const guestMessage = guestMessageInput.value.trim();

            wishFeedback.className = 'wish-feedback';
            wishFeedback.textContent = '';

            if (guestName.length < 2) {
                showFeedback('Nama minimal 2 karakter ya bro.', 'error');
                guestNameInput.focus();
                return;
            }

            if (guestMessage.length < 10) {
                showFeedback(
                    'Ucapannya minimal 10 karakter biar lebih bermakna.',
                    'error'
                );

                guestMessageInput.focus();
                return;
            }

            const wishCard = document.createElement('div');
            const wishName = document.createElement('strong');
            const wishMessage = document.createElement('p');

            wishCard.classList.add('wish-preview-card', 'new-wish');

            wishName.textContent = guestName;
            wishMessage.textContent = guestMessage;

            wishCard.appendChild(wishName);
            wishCard.appendChild(wishMessage);

            wishesList.prepend(wishCard);

            wishForm.reset();
            messageCounter.textContent = '0 / 300 karakter';

            showFeedback('Ucapan berhasil ditambahkan ✨', 'success');

            guestNameInput.focus();
        });

        function showFeedback(message, type) {
            wishFeedback.textContent = message;
            wishFeedback.classList.add(type);
        }
    });
</script>

</html>
