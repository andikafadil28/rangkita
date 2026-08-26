<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionPackage;
use App\Models\QuizSession;
use App\Models\SoalCategory;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    private const SECONDS_PER_QUESTION = 54;

    public function index()
    {
        $categories = SoalCategory::withCount('packages')
            ->with(['packages' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();

        return view('pages.soal', compact('categories'));
    }

    public function category(SoalCategory $category)
    {
        $packages = $category->packages()
            ->where('is_active', true)
            ->get();

        $ownedIds = auth()->check()
            ? auth()->user()->userAccess()->pluck('package_id')
            : collect();

        return view('pages.soal-category', compact('category', 'packages', 'ownedIds'));
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
            ? ($package->time_limit ?? $totalQuestions * self::SECONDS_PER_QUESTION)
            : null;

        $usePointSystem = $package->point_correct !== null;

        $selectFields = [
            'id',
            'question_text',
            'option_a',
            'option_b',
            'option_c',
            'option_d',
            'option_e',
        ];

        if ($usePointSystem) {
            $selectFields[] = 'point_correct';
            $selectFields[] = 'point_blank';
            $selectFields[] = 'point_wrong';
        }

        return view('pages.soal-quiz', [
            'package' => $package,
            'mode' => $mode,
            'timeLimit' => $timeLimit,
            'usePointSystem' => $usePointSystem,
            'displayMode' => $package->display_mode,
            'allowBack' => $package->allow_back,
            'totalQuestions' => $totalQuestions,
            'questions' => $package->questions()->select($selectFields)->get(),
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

        $questions = $package->questions()->get();
        $answerKey = $questions->pluck('correct_answer', 'id');

        $usePointSystem = $package->point_correct !== null;

        if ($usePointSystem) {
            $totalPoints = 0;
            $maxPoints = 0;

            foreach ($questions as $question) {
                $pc = $question->point_correct ?? $package->point_correct ?? 0;
                $pb = $question->point_blank ?? $package->point_blank ?? 0;
                $pw = $question->point_wrong ?? $package->point_wrong ?? 0;

                $maxPoints += $pc;

                $userAnswer = $data['answers'][$question->id] ?? null;

                if ($userAnswer === null) {
                    $totalPoints += $pb;
                } elseif ($userAnswer === ($answerKey[$question->id] ?? null)) {
                    $totalPoints += $pc;
                } else {
                    $totalPoints += $pw;
                }
            }

            $score = $maxPoints > 0 ? max(0, (int) round($totalPoints / $maxPoints * 100)) : 0;
        } else {
            $correctCount = 0;
            foreach ($data['answers'] as $questionId => $answer) {
                if (($answerKey[$questionId] ?? null) === $answer) {
                    $correctCount++;
                }
            }

            $total = $answerKey->count();
            $score = $total > 0 ? (int) round($correctCount / $total * 100) : 0;
            $totalPoints = null;
            $maxPoints = null;
        }

        $session = QuizSession::create([
            'user_id' => auth()->id(),
            'package_id' => $package->id,
            'mode' => $data['mode'],
            'score' => $score,
            'answers' => $data['answers'],
            'time_spent' => $data['time_spent'] ?? null,
            'time_limit' => $data['mode'] === 'test'
                ? ($package->time_limit ?? $questions->count() * self::SECONDS_PER_QUESTION)
                : null,
            'total_points' => $totalPoints,
            'max_points' => $maxPoints,
        ]);

        return redirect()->route('soal.result', $session);
    }

    public function result(QuizSession $session)
    {
        abort_unless($session->user_id === auth()->id(), 403);

        $session->load('package');
        $answers = $session->answers ?? [];
        $package = $session->package;
        $usePointSystem = $package->point_correct !== null;

        $recap = $package->questions()->get()->map(function (Question $question) use ($answers, $package, $usePointSystem) {
            $userAnswer = $answers[$question->id] ?? null;
            $isCorrect = $userAnswer !== null && $userAnswer === $question->correct_answer;
            $isSkipped = $userAnswer === null;

            $earnedPoints = null;
            if ($usePointSystem) {
                $pc = $question->point_correct ?? $package->point_correct ?? 0;
                $pb = $question->point_blank ?? $package->point_blank ?? 0;
                $pw = $question->point_wrong ?? $package->point_wrong ?? 0;

                $earnedPoints = $isSkipped ? $pb : ($isCorrect ? $pc : $pw);
            }

            return [
                'question' => $question,
                'user_answer' => $userAnswer,
                'is_correct' => $isCorrect,
                'is_skipped' => $isSkipped,
                'earned_points' => $earnedPoints,
            ];
        });

        return view('pages.soal-result', [
            'session' => $session,
            'package' => $package,
            'recap' => $recap,
            'usePointSystem' => $usePointSystem,
            'correctCount' => $recap->where('is_correct', true)->count(),
            'wrongCount' => $recap->where('is_correct', false)->where('is_skipped', false)->count(),
            'skippedCount' => $recap->where('is_skipped')->count(),
        ]);
    }

    public function history()
    {
        $sessions = QuizSession::with('package.soalCategory')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pages.soal-history', compact('sessions'));
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
