@extends('layouts.app')

@section('meta_robots', 'noindex, nofollow')

@section('content')
    <div class="admin-wrap">
        <div class="admin-bar">
            <span class="admin-bar-title">Panel Admin</span>
            <nav class="admin-bar-nav">
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">Dashboard</a>
                <a href="{{ route('admin.packages.index') }}" class="{{ request()->routeIs('admin.packages.*') ? 'is-active' : '' }}">Kelola Paket</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'is-active' : '' }}">Kategori</a>
                <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">Users</a>
                <a href="{{ url('/') }}">Lihat Situs</a>
            </nav>
        </div>

        @if (session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif

        @yield('admin-content')
    </div>
@endsection
