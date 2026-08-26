<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\QuestionPackage;
use Illuminate\Http\Request;

class AdminQuestionController extends Controller
{
    public function index(QuestionPackage $package)
    {
        $questions = $package->questions()->paginate(20);

        return view('admin.questions.index', [
            'package' => $package,
            'questions' => $questions,
        ]);
    }

    public function create(QuestionPackage $package)
    {
        return view('admin.questions.create', [
            'package' => $package,
            'question' => new Question(),
        ]);
    }

    public function store(Request $request, QuestionPackage $package)
    {
        $package->questions()->create($this->validated($request));
        $this->syncTotalQuestions($package);

        return redirect()
            ->route('admin.questions.index', $package)
            ->with('success', 'Soal berhasil ditambahkan.');
    }

    public function edit(QuestionPackage $package, Question $question)
    {
        $this->assertBelongsTo($package, $question);

        return view('admin.questions.edit', [
            'package' => $package,
            'question' => $question,
        ]);
    }

    public function update(Request $request, QuestionPackage $package, Question $question)
    {
        $this->assertBelongsTo($package, $question);

        $question->update($this->validated($request));
        $this->syncTotalQuestions($package);

        return redirect()
            ->route('admin.questions.index', $package)
            ->with('success', 'Soal berhasil diperbarui.');
    }

    public function destroy(QuestionPackage $package, Question $question)
    {
        $this->assertBelongsTo($package, $question);

        $question->delete();
        $this->syncTotalQuestions($package);

        return redirect()
            ->route('admin.questions.index', $package)
            ->with('success', 'Soal berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'question_text' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'option_e' => ['nullable', 'string', 'max:255'],
            'correct_answer' => [
                'required',
                'in:a,b,c,d,e',
                function (string $attribute, mixed $value, \Closure $fail) use ($request) {
                    if ($value === 'e' && trim((string) $request->input('option_e')) === '') {
                        $fail('Opsi E masih kosong, gak bisa dijadiin kunci jawaban.');
                    }
                },
            ],
            'explanation' => ['nullable', 'string'],
            'difficulty' => ['required', 'in:mudah,sedang,sulit'],
            'point_correct' => ['nullable', 'integer', 'min:0'],
            'point_blank' => ['nullable', 'integer'],
            'point_wrong' => ['nullable', 'integer'],
        ]);

        $data['point_correct'] = $request->filled('point_correct') ? (int) $request->input('point_correct') : null;
        $data['point_blank'] = $request->filled('point_blank') ? (int) $request->input('point_blank') : null;
        $data['point_wrong'] = $request->filled('point_wrong') ? (int) $request->input('point_wrong') : null;

        return $data;
    }

    private function syncTotalQuestions(QuestionPackage $package): void
    {
        $package->update([
            'total_questions' => $package->questions()->count(),
        ]);
    }

    private function assertBelongsTo(QuestionPackage $package, Question $question): void
    {
        abort_unless($question->package_id === $package->id, 404);
    }
}
