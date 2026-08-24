<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionPackage;
use App\Models\QuizSession;
use Illuminate\Http\Request;

class CpnsController extends Controller
{
    public const CATEGORIES = [
        'twk' => 'Tes Wawasan Kebangsaan',
        'tiu' => 'Tes Intelegensia Umum',
        'tkp' => 'Tes Karakteristik Pribadi',
    ];

    private const SECONDS_PER_QUESTION = 54;

    public function index()
    {
        $packages = QuestionPackage::where('is_active', true)->get()->groupBy('category');

        return view('pages.cpns', compact('packages'));
    }

    public function category(string $category)
    {
        abort_unless(array_key_exists($category, self::CATEGORIES), 404);

        $packages = QuestionPackage::where('category', $category)
            ->where('is_active', true)
            ->get();

        $ownedIds = auth()->check()
            ? auth()->user()->userAccess()->pluck('package_id')
            : collect();

        return view('pages.cpns-category', compact('category', 'packages', 'ownedIds'));
    }

    public function quiz(Request $request, QuestionPackage $package)
    {
        $mode = $request->query('mode', 'latihan');
        abort_unless(in_array($mode, ['latihan', 'test']), 422);

        if (! $this->hasAccess($package)) {
            return redirect()->route('payment.create', $package);
        }

        $totalQuestions = $package->questions()->count();
        $timeLimit = $mode === 'test'
            ? $totalQuestions * self::SECONDS_PER_QUESTION
            : null;

        return view('pages.cpns-quiz', [
            'package' => $package,
            'mode' => $mode,
            'timeLimit' => $timeLimit,
            'questions' => $package->questions()->select([
                'id',
                'question_text',
                'option_a',
                'option_b',
                'option_c',
                'option_d',
                'option_e',
            ])->get(),
        ]);
    }

    public function submit(Request $request, QuestionPackage $package)
    {
        $data = $request->validate([
            'mode' => ['required', 'in:latihan,test'],
            'answers' => ['required', 'array'],
            'answers.*' => ['in:a,b,c,d,e'],
            'time_spent' => ['nullable', 'integer', 'min:0'],
        ]);

        $answerKey = Question::where('package_id', $package->id)
            ->pluck('correct_answer', 'id');

        $correctCount = 0;
        foreach ($data['answers'] as $questionId => $answer) {
            if (($answerKey[$questionId] ?? null) === $answer) {
                $correctCount++;
            }
        }

        $total = $answerKey->count();
        $score = $total > 0 ? (int) round($correctCount / $total * 100) : 0;

        $session = QuizSession::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'mode' => $data['mode'],
            'score' => $score,
            'answers' => $data['answers'],
            'time_spent' => $data['time_spent'] ?? null,
            'time_limit' => $data['mode'] === 'test'
                ? $total * self::SECONDS_PER_QUESTION
                : null,
        ]);

        return redirect()->route('cpns.result', $session);
    }

    public function result(QuizSession $session)
    {
        abort_unless($session->user_id === auth()->id(), 403);

        $session->load('package');
        $answers = $session->answers ?? [];

        $recap = $session->package->questions()->get()->map(function (Question $question) use ($answers) {
            $userAnswer = $answers[$question->id] ?? null;

            return [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $userAnswer !== null && $userAnswer === $question->correct_answer,
                'is_skipped' => $userAnswer === null,
            ];
        });

        return view('pages.cpns-result', [
            'session' => $session,
            'package' => $session->package,
            'recap' => $recap,
            'correctCount' => $recap->where('is_correct', true)->count(),
            'wrongCount' => $recap->where('is_correct', false)->where('is_skipped', false)->count(),
            'skippedCount' => $recap->where('is_skipped')->count(),
        ]);
    }

    private function hasAccess(QuestionPackage $package): bool
    {
        if ($package->isFree()) {
            return true;
        }

        return auth()->user()
            ->userAccess()
            ->where('package_id', $package->id)
            ->exists();
    }
}
