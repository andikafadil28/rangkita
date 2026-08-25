@extends('admin.layouts.admin')

@section('title', 'Edit Soal - ' . $package->name . ' - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Edit Soal #{{ $question->id }}</h1>

        <p class="page-desc">Paket: {{ $package->name }}</p>

        @include('admin.questions._form', ['package' => $package, 'question' => $question])

        <a href="{{ route('admin.questions.index', $package) }}" class="back-link">&larr; Kembali ke daftar soal</a>
    </section>
@endsection
