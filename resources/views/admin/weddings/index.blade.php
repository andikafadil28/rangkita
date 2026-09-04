@extends('admin.layouts.admin')

@section('title', 'Kelola Undangan - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <div>
                <h1 class="page-title">Kelola Undangan</h1>
                <p class="page-desc">Buat, preview, dan publikasikan undangan pelanggan.</p>
            </div>
            <a href="{{ route('admin.weddings.create') }}" class="btn-primary">+ Tambah Undangan</a>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Pasangan</th>
                        <th>Template</th>
                        <th>Tanggal</th>
                        <th>Konten</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($weddings as $wedding)
                        <tr>
                            <td>
                                <strong>{{ $wedding->groom_short_name }} &amp; {{ $wedding->bride_short_name }}</strong>
                                <div class="hint">/undangan/{{ $wedding->slug }}</div>
                            </td>
                            <td>{{ $wedding->template->name }}</td>
                            <td>{{ $wedding->wedding_date->format('d M Y, H:i') }}</td>
                            <td>
                                <span class="badge badge-soft">{{ $wedding->gallery_count }} foto</span>
                                <span class="badge badge-soft">{{ $wedding->wishes_count }} ucapan</span>
                            </td>
                            <td>
                                <span class="badge {{ $wedding->status === 'published' ? 'badge-success' : 'badge-soft' }}">
                                    {{ $wedding->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('weddings.show', $wedding) }}" class="btn-secondary btn-sm" target="_blank" rel="noopener noreferrer">Preview</a>
                                    <a href="{{ route('admin.weddings.edit', $wedding) }}" class="btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.weddings.destroy', $wedding) }}" method="POST" onsubmit="return confirm(@js('Hapus undangan '.$wedding->groom_short_name.' & '.$wedding->bride_short_name.' beserta seluruh foto dan ucapannya?'))">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="admin-empty">
                                <p>Belum ada undangan pelanggan.</p>
                                <a href="{{ route('admin.weddings.create') }}" class="btn-primary btn-sm">+ Buat Undangan Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $weddings->links('admin.partials.pagination') }}
    </section>
@endsection
