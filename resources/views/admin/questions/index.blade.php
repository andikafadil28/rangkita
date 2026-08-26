@extends('admin.layouts.admin')

@section('title', $package->name . ' - Kelola Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <div>
                <h1 class="page-title">Soal: {{ $package->name }}</h1>
                <p class="page-desc">{{ $package->total_questions }} soal terdaftar &middot; {{ ucfirst($package->difficulty) }}</p>
            </div>
            <a href="{{ route('admin.questions.create', $package) }}" class="btn-primary">+ Tambah Soal</a>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Soal</th>
                        <th>Kunci</th>
                        <th>Tingkat</th>
                        @if ($package->point_correct !== null)
                            <th>Poin (B/K/S)</th>
                        @endif
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($questions as $question)
                        <tr>
                            <td>{{ ($questions->currentPage() - 1) * $questions->perPage() + $loop->iteration }}</td>
                            <td>{{ Str::limit($question->question_text, 90) }}</td>
                            <td><span class="badge badge-success">{{ strtoupper($question->correct_answer) }}</span></td>
                            <td>{{ ucfirst($question->difficulty) }}</td>
                            @if ($package->point_correct !== null)
                                <td>
                                    @php
                                        $pc = $question->point_correct;
                                        $pb = $question->point_blank;
                                        $pw = $question->point_wrong;
                                        $hasOverride = $pc !== null || $pb !== null || $pw !== null;
                                    @endphp
                                    @if ($hasOverride)
                                        <span class="badge badge-soft">
                                            {{ $pc ?? '—' }}/{{ $pb ?? '—' }}/{{ $pw ?? '—' }}
                                        </span>
                                    @else
                                        <span style="color:#8a7fa0">ikut paket</span>
                                    @endif
                                </td>
                            @endif
                            <td>
                                <div class="admin-actions">
                                    <a href="{{ route('admin.questions.edit', [$package, $question]) }}" class="btn-secondary btn-sm">Edit</a>
                                    <form action="{{ route('admin.questions.destroy', [$package, $question]) }}" method="POST" onsubmit="return confirm('Hapus soal ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $package->point_correct !== null ? 6 : 5 }}" class="admin-empty">
                                <p>Belum ada soal di paket ini.</p>
                                <a href="{{ route('admin.questions.create', $package) }}" class="btn-primary btn-sm">+ Tambah Soal Pertama</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $questions->links('admin.partials.pagination') }}

        <a href="{{ route('admin.packages.index') }}" class="back-link">&larr; Kembali ke daftar paket</a>
    </section>
@endsection
