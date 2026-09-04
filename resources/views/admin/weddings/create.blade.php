@extends('admin.layouts.admin')

@section('title', 'Tambah Undangan - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Tambah Undangan</h1>
        <p class="page-desc">Slug dibuat otomatis dari nama pendek pasangan dan tidak berubah setelah tersimpan.</p>

        @include('admin.weddings._form')

        <a href="{{ route('admin.weddings.index') }}" class="back-link">&larr; Kembali ke daftar undangan</a>
    </section>
@endsection
