<?php

namespace App\Http\Controllers;

use App\Models\QuestionPackage;
use App\Models\SoalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminQuestionPackageController extends Controller
{
    public function index()
    {
        $packages = QuestionPackage::query()
            ->with(['soalCategory', 'questions'])
            ->withCount('questions')
            ->join('soal_categories', 'soal_categories.id', '=', 'question_packages.soal_category_id')
            ->orderBy('soal_categories.sort_order')
            ->orderBy('question_packages.name')
            ->select('question_packages.*')
            ->get();

        return view('admin.packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.packages.create', [
            'package' => new QuestionPackage(),
            'categories' => SoalCategory::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);
        $data['total_questions'] = 0;

        $package = QuestionPackage::create($data);

        return redirect()
            ->route('admin.questions.index', $package)
            ->with('success', "Paket \"{$data['name']}\" berhasil dibuat. Langsung input soal pertama!");
    }

    public function edit(QuestionPackage $package)
    {
        return view('admin.packages.edit', [
            'package' => $package,
            'categories' => SoalCategory::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, QuestionPackage $package)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $package->id);
        $data['total_questions'] = $package->questions()->count();

        $package->update($data);

        return redirect()
            ->route('admin.packages.index')
            ->with('success', "Paket \"{$data['name']}\" berhasil diperbarui.");
    }

    public function destroy(QuestionPackage $package)
    {
        if ($package->transactions()->exists() || $package->userAccess()->exists()) {
            return redirect()
                ->route('admin.packages.index')
                ->with('error', "Paket \"{$package->name}\" punya riwayat transaksi/akses pembelian, jadi gak boleh dihapus demi integritas finansial. Nonaktifkan lewat status aja.");
        }

        if ($package->quizSessions()->exists()) {
            return redirect()
                ->route('admin.packages.index')
                ->with('error', "Paket \"{$package->name}\" masih ada riwayat pengerjaan quiz. Menghapusnya bakal ikut ngehapus skor user.");
        }

        $name = $package->name;
        $package->delete();

        return redirect()
            ->route('admin.packages.index')
            ->with('success', "Paket \"{$name}\" berhasil dihapus beserta seluruh soalnya.");
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'soal_category_id' => ['required', 'exists:soal_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'difficulty' => ['required', 'in:mudah,sedang,sulit'],
            'price' => ['required', 'integer', 'min:0', 'max:4294967295'],
            'is_active' => ['nullable', 'boolean'],
            'point_correct' => ['nullable', 'integer', 'min:0'],
            'point_blank' => ['nullable', 'integer'],
            'point_wrong' => ['nullable', 'integer'],
        ]);

        $data['is_active'] = $request->boolean('is_active');

        if (! $request->filled('point_correct')) {
            $data['point_correct'] = null;
            $data['point_blank'] = null;
            $data['point_wrong'] = null;
        } else {
            $data['point_blank'] = $request->filled('point_blank') ? (int) $request->input('point_blank') : 0;
            $data['point_wrong'] = $request->filled('point_wrong') ? (int) $request->input('point_wrong') : 0;
        }

        return $data;
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'paket';
        $slug = $base;
        $counter = 2;

        while (QuestionPackage::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
