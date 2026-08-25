@extends('admin.layouts.admin')

@section('title', 'Tambah Paket Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Tambah Paket Soal</h1>

        <p class="page-desc">
            Paket baru dibuat tanpa soal. Setelah tersimpan, kamu langsung diarahkan
            ke halaman input soal.
        </p>

        @include('admin.packages._form', ['categories' => $categories])

        <a href="{{ route('admin.packages.index') }}" class="back-link">&larr; Kembali ke daftar paket</a>
    </section>
@endsection
