@extends('layouts.app')

@section('title', 'Login - Rangkita')

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h2>Masuk ke Akunmu</h2>
                <p>Login buat akses dashboard dan fitur Rangkita.</p>
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

                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn-primary" style="width: 100%; border: none; cursor: pointer;">Masuk</button>
                </form>

                <div style="margin-top: 20px; text-align: center;">
                    <a href="{{ route('google.redirect') }}" class="btn-secondary" style="text-decoration: none;">Lanjut dengan Google</a>
                </div>

                <p style="text-align: center; margin-top: 20px; color: #6d617c;">
                    Belum punya akun?
                    <a href="{{ route('register') }}" style="color: #ff4f87; font-weight: 800;">Daftar di sini</a>
                </p>
            </div>
        </div>
    </section>
@endsection