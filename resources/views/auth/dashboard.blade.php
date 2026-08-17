@extends('layouts.app')

@section('title', 'Dashboard - Rangkita')

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Selamat datang, {{ $user->name }}!</h2>
                <p>Kamu udah masuk ke dashboard Rangkita.</p>
            </div>

            <div class="card" style="max-width: 480px; margin: 0 auto; text-align: center;">
                <p style="color: #6d617c; margin-bottom: 24px;">
                    Ini halaman dashboard. Fitur lengkap bakal menyusul di modul berikutnya.
                </p>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-secondary" style="border: none; cursor: pointer;">Logout</button>
                </form>
            </div>
        </div>
    </section>
@endsection