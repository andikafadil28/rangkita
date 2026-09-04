<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Wedding;
use App\Models\WeddingGallery;
use App\Models\WeddingWish;
use Illuminate\Contracts\View\View;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use RuntimeException;
use Throwable;

class AdminWeddingController extends Controller
{
    public function index(): View
    {
        $weddings = Wedding::query()
            ->with('template')
            ->withCount(['gallery', 'wishes'])
            ->latest()
            ->paginate(15);

        return view('admin.weddings.index', compact('weddings'));
    }

    public function create(): View
    {
        return view('admin.weddings.create', [
            'wedding' => new Wedding,
            'templates' => Template::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $newPaths = [];

        try {
            $wedding = DB::transaction(function () use ($request, $validated, &$newPaths) {
                $wedding = $this->createWedding($this->weddingData($validated));

                $newPaths = $this->storeGallery(
                    $wedding,
                    $request->file('gallery', []),
                    $validated['gallery_captions'] ?? []
                );

                return $wedding;
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($newPaths);

            throw $exception;
        }

        return redirect()
            ->route('admin.weddings.edit', $wedding)
            ->with('success', 'Undangan berhasil dibuat.');
    }

    public function edit(Wedding $wedding): View
    {
        $wedding->load(['gallery', 'wishes' => fn ($query) => $query->latest()]);

        return view('admin.weddings.edit', [
            'wedding' => $wedding,
            'templates' => Template::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Wedding $wedding): RedirectResponse
    {
        $validated = $this->validated($request);
        $newPaths = [];

        try {
            DB::transaction(function () use ($request, $validated, $wedding, &$newPaths) {
                $wedding->update($this->weddingData($validated));
                $this->updateGalleryMetadata($wedding, $validated['existing_gallery'] ?? []);

                $newPaths = $this->storeGallery(
                    $wedding,
                    $request->file('gallery', []),
                    $validated['gallery_captions'] ?? []
                );
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($newPaths);

            throw $exception;
        }

        return redirect()
            ->route('admin.weddings.edit', $wedding)
            ->with('success', 'Undangan berhasil diperbarui.');
    }

    public function destroy(Wedding $wedding): RedirectResponse
    {
        $name = $wedding->groom_short_name.' & '.$wedding->bride_short_name;
        $paths = $wedding->gallery()->pluck('photo_path')->all();

        DB::transaction(fn () => $wedding->delete());

        if (! Storage::disk('public')->delete($paths)) {
            Log::warning('Sebagian file galeri wedding gagal dihapus.', [
                'wedding_id' => $wedding->id,
                'paths' => $paths,
            ]);
        }

        if (! Storage::disk('public')->deleteDirectory('weddings/'.$wedding->id)) {
            Log::warning('Folder galeri wedding gagal dihapus.', ['wedding_id' => $wedding->id]);
        }

        return redirect()
            ->route('admin.weddings.index')
            ->with('success', "Undangan {$name} berhasil dihapus.");
    }

    public function destroyGalleryPhoto(Wedding $wedding, WeddingGallery $gallery): RedirectResponse
    {
        $this->assertBelongsToWedding($wedding, $gallery->wedding_id);
        $path = $gallery->photo_path;

        DB::transaction(fn () => $gallery->delete());
        if (! Storage::disk('public')->delete($path)) {
            Log::warning('File galeri wedding gagal dihapus.', [
                'gallery_id' => $gallery->id,
                'path' => $path,
            ]);
        }

        return back()->with('success', 'Foto galeri berhasil dihapus.');
    }

    public function toggleWish(Wedding $wedding, WeddingWish $wish): RedirectResponse
    {
        $this->assertBelongsToWedding($wedding, $wish->wedding_id);
        $wish->update(['is_approved' => ! $wish->is_approved]);

        return back()->with('success', 'Visibilitas ucapan berhasil diperbarui.');
    }

    public function destroyWish(Wedding $wedding, WeddingWish $wish): RedirectResponse
    {
        $this->assertBelongsToWedding($wedding, $wish->wedding_id);
        $wish->delete();

        return back()->with('success', 'Ucapan berhasil dihapus.');
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $receptionStarted = collect($request->input('events.resepsi', []))
            ->contains(fn ($value) => filled($value));
        $receptionRule = Rule::requiredIf($receptionStarted);

        return $request->validate([
            'template_id' => ['required', 'integer', 'exists:templates,id'],
            'groom_short_name' => ['required', 'string', 'max:50'],
            'groom_full_name' => ['required', 'string', 'max:150'],
            'groom_parent' => ['nullable', 'string', 'max:255'],
            'bride_short_name' => ['required', 'string', 'max:50'],
            'bride_full_name' => ['required', 'string', 'max:150'],
            'bride_parent' => ['nullable', 'string', 'max:255'],
            'wedding_date' => ['required', 'date'],
            'events.akad.title' => ['required', 'string', 'max:100'],
            'events.akad.date' => ['required', 'date'],
            'events.akad.time' => ['required', 'date_format:H:i'],
            'events.akad.place' => ['required', 'string', 'max:150'],
            'events.akad.address' => ['required', 'string', 'max:500'],
            'events.resepsi.title' => [$receptionRule, 'nullable', 'string', 'max:100'],
            'events.resepsi.date' => [$receptionRule, 'nullable', 'date'],
            'events.resepsi.time' => [$receptionRule, 'nullable', 'date_format:H:i'],
            'events.resepsi.place' => [$receptionRule, 'nullable', 'string', 'max:150'],
            'events.resepsi.address' => [$receptionRule, 'nullable', 'string', 'max:500'],
            'maps_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'gallery' => ['nullable', 'array', 'max:10'],
            'gallery.*' => ['file', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'gallery_captions' => ['nullable', 'array', 'max:10'],
            'gallery_captions.*' => ['nullable', 'string', 'max:255'],
            'existing_gallery' => ['nullable', 'array'],
            'existing_gallery.*.caption' => ['nullable', 'string', 'max:255'],
            'existing_gallery.*.sort_order' => ['required', 'integer', 'min:0'],
        ]);
    }

    /** @param array<string, mixed> $validated */
    private function weddingData(array $validated): array
    {
        $data = Arr::only($validated, [
            'template_id',
            'groom_short_name',
            'groom_full_name',
            'groom_parent',
            'bride_short_name',
            'bride_full_name',
            'bride_parent',
            'wedding_date',
            'events',
            'maps_url',
            'status',
        ]);

        if (! collect($data['events']['resepsi'] ?? [])->contains(fn ($value) => filled($value))) {
            unset($data['events']['resepsi']);
        }

        return $data;
    }

    /**
     * @param  array<int, UploadedFile>  $files
     * @param  array<int, string|null>  $captions
     * @return array<int, string>
     */
    private function storeGallery(Wedding $wedding, array $files, array $captions): array
    {
        $paths = [];
        $highestSortOrder = $wedding->gallery()->max('sort_order');
        $sortOrder = $highestSortOrder === null ? 0 : ((int) $highestSortOrder) + 1;

        try {
            foreach ($files as $index => $file) {
                $path = $file->store('weddings/'.$wedding->id, 'public');

                if (! $path) {
                    throw new RuntimeException('Foto galeri gagal disimpan.');
                }

                $paths[] = $path;
                $wedding->gallery()->create([
                    'photo_path' => $path,
                    'caption' => $captions[$index] ?? null,
                    'sort_order' => $sortOrder++,
                ]);
            }
        } catch (Throwable $exception) {
            Storage::disk('public')->delete($paths);

            throw $exception;
        }

        return $paths;
    }

    /** @param array<int|string, array<string, mixed>> $items */
    private function updateGalleryMetadata(Wedding $wedding, array $items): void
    {
        foreach ($items as $galleryId => $item) {
            $gallery = WeddingGallery::query()->findOrFail($galleryId);
            $this->assertBelongsToWedding($wedding, $gallery->wedding_id);
            $gallery->update($item);
        }
    }

    /** @param array<string, mixed> $data */
    private function createWedding(array $data): Wedding
    {
        $base = Str::slug($data['groom_short_name'].'-'.$data['bride_short_name']) ?: 'undangan';
        $lastException = null;

        foreach (range(1, 100) as $attempt) {
            $slug = $attempt === 1 ? $base : $base.'-'.$attempt;

            try {
                return Wedding::create([...$data, 'slug' => $slug]);
            } catch (UniqueConstraintViolationException $exception) {
                $lastException = $exception;
            }
        }

        throw $lastException ?? new RuntimeException('Slug undangan gagal dibuat.');
    }

    private function assertBelongsToWedding(Wedding $wedding, int $weddingId): void
    {
        abort_unless($wedding->id === $weddingId, 404);
    }
}
