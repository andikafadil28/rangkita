<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::withCount(['quizSessions', 'transactions', 'userAccess'])
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa mengubah role sendiri.']);
        }

        $adminCount = User::where('role', 'admin')->count();

        if ($user->role === 'admin' && $adminCount <= 1) {
            return back()->withErrors(['error' => 'Tidak bisa mencabut admin terakhir.']);
        }

        $user->update([
            'role' => $user->role === 'admin' ? 'user' : 'admin',
        ]);

        $action = $user->role === 'admin' ? 'dijadikan admin' : 'dicabut admin-nya';

        return back()->with('success', "{$user->name} berhasil {$action}.");
    }
}
