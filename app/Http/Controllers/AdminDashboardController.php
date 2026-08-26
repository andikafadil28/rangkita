<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionPackage;
use App\Models\QuizSession;
use App\Models\SoalCategory;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserAccess;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'packages' => QuestionPackage::count(),
            'questions' => Question::count(),
            'categories' => SoalCategory::count(),
            'revenue' => Transaction::where('status', 'paid')->sum('gross_amount'),
            'pending' => Transaction::where('status', 'pending')->count(),
            'quizzes' => QuizSession::count(),
            'access' => UserAccess::count(),
        ];

        $recentQuizzes = QuizSession::with('user', 'package.soalCategory')
            ->latest()
            ->limit(5)
            ->get();

        $recentTransactions = Transaction::with('user', 'package')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentQuizzes', 'recentTransactions'));
    }
}
