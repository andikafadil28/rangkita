@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard - Rangkita')

@section('admin-content')
    <section class="page">
        <h1 class="page-title">Dashboard Admin</h1>

        <p class="page-desc">
            Halo {{ auth()->user()->name }}, kelola konten Rangkita dari sini.
        </p>

        <div class="admin-menu">
            <a href="{{ route('admin.packages.index') }}" class="card admin-menu-card">
                <h3>Kelola Soal</h3>
                <p>CRUD paket dan bank soal TWK, TIU, TKP.</p>
            </a>

            <div class="card admin-menu-card is-disabled">
                <h3>Kelola Undangan</h3>
                <p>Segera hadir.</p>
            </div>

            <div class="card admin-menu-card is-disabled">
                <h3>Kelola Artikel</h3>
                <p>Segera hadir.</p>
            </div>
        </div>
    </section>
@endsection
