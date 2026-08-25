<?php

namespace App\Http\Controllers;

use App\Models\SoalCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSoalCategoryController extends Controller
{
    public function index()
    {
        $categories = SoalCategory::withCount('packages')->orderBy('sort_order')->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create', [
            'category' => new SoalCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name']);

        SoalCategory::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Kategori \"{$data['name']}\" berhasil dibuat.");
    }

    public function edit(SoalCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, SoalCategory $category)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['name'], $category->id);

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Kategori \"{$data['name']}\" berhasil diperbarui.");
    }

    public function destroy(SoalCategory $category)
    {
        if ($category->packages()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', "Kategori \"{$category->name}\" masih dipakai di paket soal. Pindahkan paketnya dulu sebelum menghapus.");
        }

        $name = $category->name;
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Kategori \"{$name}\" berhasil dihapus.");
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'icon' => ['nullable', 'string', 'max:10'],
            'description' => ['nullable', 'string', 'max:500'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    private function uniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'kategori';
        $slug = $base;
        $counter = 2;

        while (SoalCategory::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base.'-'.$counter++;
        }

        return $slug;
    }
}
