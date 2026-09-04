@php
    $akad = data_get($wedding->events, 'akad');
    $resepsi = data_get($wedding->events, 'resepsi');
    $formatEventDate = static fn (?string $date) => $date
        ? \Illuminate\Support\Carbon::parse($date)->locale('id')->translatedFormat('l, j F Y')
        : '';
@endphp

@if ($backUrl)
    <a href="{{ $backUrl }}" class="preview-back-button">&larr; Kembali</a>
@endif

<section class="invitation-cover" id="invitationCover">
    <div class="invitation-cover-inner">
        <span class="preview-label">The Wedding Of</span>
        <div class="preview-icon">{{ $template->icon }}</div>
        <h1>{{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}</h1>
        <p>{{ $wedding->wedding_date->locale('id')->translatedFormat('l, j F Y') }}</p>
        <button type="button" id="openInvitationButton" class="open-invitation-button" aria-controls="invitationContent" aria-expanded="false">
            Buka Undangan
        </button>
    </div>
</section>

<main id="invitationContent" class="invitation-content" aria-hidden="false">
    <section class="invitation-section invitation-opening" id="opening" data-reveal>
        <span class="section-small-title">Assalamu'alaikum Warahmatullahi Wabarakatuh</span>
        <h2>Dengan penuh rasa syukur</h2>
        <p>Tanpa mengurangi rasa hormat, kami mengundang Bapak/Ibu/Saudara/i untuk hadir dan memberikan doa restu pada acara pernikahan kami.</p>
    </section>

    <section class="invitation-section couple-preview-section" data-reveal data-stagger>
        <div class="couple-preview-card">
            <div class="couple-avatar">{{ mb_substr($wedding->groom_short_name, 0, 1) }}</div>
            <h3>{{ $wedding->groom_full_name }}</h3>
            @if ($wedding->groom_parent)<p>{{ $wedding->groom_parent }}</p>@endif
        </div>
        <div class="couple-divider">&amp;</div>
        <div class="couple-preview-card">
            <div class="couple-avatar">{{ mb_substr($wedding->bride_short_name, 0, 1) }}</div>
            <h3>{{ $wedding->bride_full_name }}</h3>
            @if ($wedding->bride_parent)<p>{{ $wedding->bride_parent }}</p>@endif
        </div>
    </section>

    <section class="invitation-section event-preview-section" data-reveal>
        <span class="section-small-title">Save The Date</span>
        <h2>Detail Acara</h2>
        <div class="event-preview-grid {{ $resepsi ? '' : 'is-single' }}" data-stagger>
            <div class="event-preview-card">
                <h3>{{ data_get($akad, 'title') }}</h3>
                <strong>{{ str_replace(':', '.', data_get($akad, 'time')) }} WIB</strong>
                <p>{{ $formatEventDate(data_get($akad, 'date')) }}</p>
                <small>{{ data_get($akad, 'place') }}</small>
                <p>{{ data_get($akad, 'address') }}</p>
            </div>
            @if ($resepsi)
                <div class="event-preview-card">
                    <h3>{{ data_get($resepsi, 'title') }}</h3>
                    <strong>{{ str_replace(':', '.', data_get($resepsi, 'time')) }} WIB</strong>
                    <p>{{ $formatEventDate(data_get($resepsi, 'date')) }}</p>
                    <small>{{ data_get($resepsi, 'place') }}</small>
                    <p>{{ data_get($resepsi, 'address') }}</p>
                </div>
            @endif
        </div>
    </section>

    <section class="invitation-section countdown-preview-section" data-reveal>
        <span class="section-small-title">Menuju Hari Bahagia</span>
        <h2>Countdown Acara</h2>
        <div class="countdown-grid" data-target-date="{{ $wedding->wedding_date->toIso8601String() }}" data-stagger>
            <div><strong data-countdown="days">0</strong><span>Hari</span></div>
            <div><strong data-countdown="hours">0</strong><span>Jam</span></div>
            <div><strong data-countdown="minutes">0</strong><span>Menit</span></div>
            <div><strong data-countdown="seconds">0</strong><span>Detik</span></div>
        </div>
    </section>

    <section class="invitation-section gallery-preview-section" data-reveal>
        <span class="section-small-title">Our Moments</span>
        <h2>Galeri Foto</h2>
        @if ($wedding->gallery->isEmpty())
            <p>Galeri foto segera hadir.</p>
        @else
            <div class="preview-gallery-grid" data-stagger>
                @foreach ($wedding->gallery as $photo)
                    <figure>
                        <img src="{{ Storage::disk('public')->url($photo->photo_path) }}" alt="{{ $photo->caption ?: 'Foto '.$wedding->groom_short_name.' dan '.$wedding->bride_short_name }}" loading="lazy">
                        @if ($photo->caption)<figcaption>{{ $photo->caption }}</figcaption>@endif
                    </figure>
                @endforeach
            </div>
        @endif
    </section>

    <section class="invitation-section location-preview-section" data-reveal>
        <span class="section-small-title">Lokasi Acara</span>
        <h2>{{ data_get($akad, 'place') }}</h2>
        <p>{{ data_get($akad, 'address') }}</p>
        @if ($wedding->maps_url)
            <a href="{{ $wedding->maps_url }}" target="_blank" rel="noopener noreferrer" class="open-invitation-button">Buka Google Maps</a>
        @endif
    </section>

    <section class="invitation-section wishes-preview-section" data-reveal>
        <span class="section-small-title">Ucapan &amp; Doa</span>
        <h2>Doa dari Tamu</h2>
        <p>Tinggalkan ucapan dan doa terbaik untuk {{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}.</p>

        <div id="wishesList" class="wishes-list" data-stagger>
            @forelse ($wedding->approvedWishes as $wish)
                <article class="wish-preview-card">
                    <strong>{{ $wish->guest_name }}</strong>
                    <p>{{ $wish->message }}</p>
                </article>
            @empty
                <p class="wishes-empty">Belum ada ucapan. Jadilah yang pertama.</p>
            @endforelse
        </div>

        @if ($wishEnabled)
            <form id="wishForm" class="wish-preview-form" action="{{ route('weddings.wishes.store', $wedding) }}" method="POST" data-wish-form>
                @csrf
                <div class="wish-form-group">
                    <label for="guestName">Nama</label>
                    <input type="text" name="guest_name" id="guestName" value="{{ old('guest_name') }}" minlength="2" maxlength="50" autocomplete="name" required>
                    @error('guest_name')<span class="wish-field-error">{{ $message }}</span>@enderror
                </div>
                <div class="wish-form-group">
                    <label for="guestMessage">Ucapan</label>
                    <textarea name="message" id="guestMessage" rows="4" minlength="10" maxlength="300" required>{{ old('message') }}</textarea>
                    <small id="messageCounter" class="message-counter">{{ mb_strlen(old('message', '')) }} / 300 karakter</small>
                    @error('message')<span class="wish-field-error">{{ $message }}</span>@enderror
                </div>
                <p id="wishFeedback" class="wish-feedback" role="status">{{ session('success') }}</p>
                <button type="submit">Kirim Ucapan</button>
            </form>
        @else
            <p class="preview-only-note">Form ucapan aktif pada undangan pelanggan.</p>
        @endif
    </section>

    <section class="invitation-section closing-preview-section" data-reveal>
        <h2>Terima Kasih</h2>
        <p>Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu.</p>
        <h3>{{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}</h3>
    </section>
</main>
