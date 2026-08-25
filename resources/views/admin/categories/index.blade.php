@extends('admin.layouts.admin')

@section('title', 'Kelola Kategori Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <h1 class="page-title">Kategori Soal</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ Tambah Kategori</a>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Nama</th>
                        <th>Slug</th>
                        <th>Urutan</th>
                        <th>Paket</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $cat)
                        <tr>
                            <td>{{ $cat->icon }}</td>
                            <td><strong>{{ $cat->name }}</strong></td>
                            <td><span class="badge badge-soft">{{ $cat->slug }}</span></td>
                            <td>{{ $cat->sort_order }}</td>
                            <td>{{ $cat->packages_count }} paket</td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.categories.edit', $cat) }}" class="btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" onsubmit="return confirm(@js('Hapus kategori "'.$cat->name.'"'))">
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
                                <p>Belum ada kategori.</p>
                                <a href="{{ route('admin.categories.create') }}" class="btn-primary btn-sm">+ Tambah Kategori Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
