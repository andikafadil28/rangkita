@extends('layouts.app')

@section('title', 'Daftar - Rangkita')

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Buat Akun Baru</h2>
                <p>Daftar gratis buat mulai pakai fitur Rangkita.</p>
            </div>

            <div class="card" style="max-width: 480px; margin: 0 auto;">
                @if ($errors->any())
                    <div style="background: #ffe4ec; color: #c2245f; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px;">
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">Daftar</button>
                </form>

                <div style="margin-top: 20px; text-align: center;">
                    <a href="{{ route('google.redirect') }}" class="btn-secondary" style="text-decoration: none;">Lanjut dengan Google</a>
                </div>

                <p style="text-align: center; margin-top: 20px; color: #6d617c;">
                    Udah punya akun?
                    <a href="{{ route('login') }}" style="color: #ff4f87; font-weight: 800;">Login di sini</a>
                </p>
            </div>
        </div>
    </section>
@endsection