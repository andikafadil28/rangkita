@extends('admin.layouts.admin')

@section('title', 'Kelola Users - Rangkita')

@section('admin-content')
    <section class="page">
        <div class="admin-page-head">
            <h1 class="page-title">Kelola Users</h1>
            <p class="page-desc" style="margin-bottom: 0;">{{ $users->total() }} user terdaftar.</p>
        </div>

        <div class="table-scroll">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Provider</th>
                        <th>Quiz</th>
                        <th>Transaksi</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if ($user->avatar)
                                    <br><img src="{{ $user->avatar }}" alt="" style="width: 24px; height: 24px; border-radius: 50%; margin-top: 4px;">
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if ($user->role === 'admin')
                                    <span class="role-badge role-admin">Admin</span>
                                @else
                                    <span class="role-badge role-user">User</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->google_id)
                                    <span class="provider-badge provider-google">Google</span>
                                @else
                                    <span class="provider-badge provider-email">Email</span>
                                @endif
                            </td>
                            <td>{{ $user->quiz_sessions_count }}</td>
                            <td>{{ $user->transactions_count }}</td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                @if ($user->id !== auth()->id())
                                    <div class="admin-actions">
                                        <form action="{{ route('admin.users.toggle-admin', $user) }}" method="POST" onsubmit="return confirm(@js($user->role === 'admin' ? 'Cabut admin dari "'.$user->name.'"?' : 'Jadikan "'.$user->name.'" sebagai admin?'))">
                                            @csrf
                                            @if ($user->role === 'admin')
                                                <button type="submit" class="btn-danger btn-sm">Cabut Admin</button>
                                            @else
                                                <button type="submit" class="btn-primary btn-sm">Jadikan Admin</button>
                                            @endif
                                        </form>
                                    </div>
                                @else
                                    <span style="color: #8a7fa0; font-size: 13px;">Anda</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="admin-empty">
                                <p>Belum ada user terdaftar.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            @include('admin.partials.pagination', ['paginator' => $users])
        @endif
    </section>
@endsection
