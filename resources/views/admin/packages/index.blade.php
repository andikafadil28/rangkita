@extends('admin.layouts.admin')

@section('title', 'Kelola Paket Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <h1 class="page-title">Kelola Paket Soal</h1>
            <a href="{{ route('admin.packages.create') }}" class="btn-primary">+ Tambah Paket</a>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Nama</th>
                        <th>Jumlah Soal</th>
                        <th>Tingkat</th>
                        <th>Harga</th>
                        <th>Poin</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packages as $package)
                        <tr>
                            <td><span class="badge badge-soft">{{ $package->soalCategory->name }}</span></td>
                            <td>
                                <strong>{{ $package->name }}</strong>
                                <div class="hint">{{ $package->slug }}</div>
                            </td>
                            <td>{{ $package->questions_count }} soal</td>
                            <td>{{ ucfirst($package->difficulty) }}</td>
                            <td>{{ $package->isFree() ? 'Gratis' : 'Rp' . number_format($package->price, 0, ',', '.') }}</td>
                            <td>
                                @if ($package->point_correct !== null)
                                    <span class="badge badge-soft">{{ $package->point_correct }}/{{ $package->point_blank ?? 0 }}/{{ $package->point_wrong ?? 0 }}</span>
                                @else
                                    <span style="color:#8a7fa0">%</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge {{ $package->is_active ? 'badge-success' : '' }}">
                                    {{ $package->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.questions.index', $package) }}" class="btn-secondary btn-sm">Soal</a>
                                    <a href="{{ route('admin.packages.edit', $package) }}" class="btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm(@js('Hapus paket "'.$package->name.'" beserta '.$package->questions_count.' soalnya?'))">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-empty">
                                <p>Belum ada paket.</p>
                                <a href="{{ route('admin.packages.create') }}" class="btn-primary btn-sm">+ Tambah Paket Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
