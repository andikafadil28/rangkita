@extends('admin.layouts.admin')

@section('title', 'Tambah Kategori Soal - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Tambah Kategori Soal</h1>

        @include('admin.categories._form')

        <a href="{{ route('admin.categories.index') }}" class="back-link">&larr; Kembali ke daftar kategori</a>
    </section>
@endsection
