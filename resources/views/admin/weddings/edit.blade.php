@extends('admin.layouts.admin')

@section('title', 'Edit Undangan - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <div>
                <h1 class="page-title">Edit: {{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}</h1>
                <p class="page-desc">URL tetap: <strong>/undangan/{{ $wedding->slug }}</strong></p>
            </div>
            <a href="{{ route('weddings.show', $wedding) }}" class="btn-secondary" target="_blank" rel="noopener noreferrer">Preview Undangan</a>
        </div>

        @include('admin.weddings._form')

        @foreach ($wedding->gallery as $photo)
            <form id="delete-gallery-{{ $photo->id }}" action="{{ route('admin.weddings.gallery.destroy', [$wedding, $photo]) }}" method="POST" onsubmit="return confirm('Hapus foto ini dari galeri?')">
                @csrf
                @method('DELETE')
            </form>
        @endforeach

        <section class="admin-subsection">
            <div class="dashboard-section-head">
                <h2>Ucapan Tamu</h2>
                <span class="badge badge-soft">{{ $wedding->wishes->count() }} ucapan</span>
            </div>

            @if ($wedding->wishes->isEmpty())
                <div class="card admin-empty">Belum ada ucapan masuk.</div>
            @else
                <div class="admin-wish-list">
                    @foreach ($wedding->wishes as $wish)
                        <article class="card admin-wish-card {{ $wish->is_approved ? '' : 'is-hidden' }}">
                            <div>
                                <div class="admin-wish-meta">
                                    <strong>{{ $wish->guest_name }}</strong>
                                    <span class="badge {{ $wish->is_approved ? 'badge-success' : 'badge-soft' }}">
                                        {{ $wish->is_approved ? 'Tampil' : 'Disembunyikan' }}
                                    </span>
                                    <span>{{ $wish->created_at->format('d M Y, H:i') }}</span>
                                </div>
                                <p>{{ $wish->message }}</p>
                            </div>

                            <div class="admin-actions">
                                <form action="{{ route('admin.weddings.wishes.toggle', [$wedding, $wish]) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-secondary btn-sm">{{ $wish->is_approved ? 'Sembunyikan' : 'Tampilkan' }}</button>
                                </form>
                                <form action="{{ route('admin.weddings.wishes.destroy', [$wedding, $wish]) }}" method="POST" onsubmit="return confirm(@js('Hapus ucapan dari '.$wish->guest_name.'?'))">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-danger btn-sm">Hapus</button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

        <a href="{{ route('admin.weddings.index') }}" class="back-link">&larr; Kembali ke daftar undangan</a>
    </section>
@endsection
