@extends('layouts.app')

@section('title', 'Admin Dashboard - Rangkita')

@section('content')
    <section class="section">
        <div class="container">
            <h1>Admin Dashboard</h1>
            <p>Selamat datang di panel admin, {{ auth()->user()->name }}.</p>
        </div>
    </section>
@endsection