@extends('admin.layouts.admin')

@section('title', 'Edit Paket Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Edit Paket: {{ $package->name }}</h1>

        <p class="page-desc">
            Jumlah soal tersinkron otomatis tiap ada perubahan di halaman kelola soal.
        </p>

        @include('admin.packages._form', ['categories' => $categories])

        <a href="{{ route('admin.questions.index', $package) }}" class="back-link">Kelola soal paket ini &rarr;</a>
        <a href="{{ route('admin.packages.index') }}" class="back-link">&larr; Kembali ke daftar paket</a>
    </section>
@endsection
