@extends('admin.layouts.admin')

@section('title', 'Tambah Soal - ' . $package->name . ' - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Tambah Soal: {{ $package->name }}</h1>

        @include('admin.questions._form', ['package' => $package, 'question' => $question])

        <a href="{{ route('admin.questions.index', $package) }}" class="back-link">&larr; Kembali ke daftar soal</a>
    </section>
@endsection
