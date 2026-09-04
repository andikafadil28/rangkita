<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Models\Wedding;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class WeddingController extends Controller
{
    public function index(): View
    {
        $templates = Template::query()->orderBy('id')->get();
        $waNumber = config('services.whatsapp.number');

        return view('pages.undangan', compact('templates', 'waNumber'));
    }

    public function templateDetail(Template $template): View
    {
        $wedding = $this->demoWedding();
        $waNumber = config('services.whatsapp.number');

        return view('pages.template-detail', [
            'template' => $template,
            'wedding' => $wedding,
            'waNumber' => $waNumber,
        ]);
    }

    public function templatePreview(Template $template): View
    {
        return view('pages.template-preview', [
            'template' => $template,
            'wedding' => $this->demoWedding(),
        ]);
    }

    public function show(Request $request, Wedding $wedding): View
    {
        $isAdmin = $request->user()?->role === 'admin';

        abort_if($wedding->status !== 'published' && ! $isAdmin, 404);

        $wedding->load([
            'template',
            'gallery',
            'approvedWishes' => fn ($query) => $query->limit(50),
        ]);

        return view('pages.undangan-public', [
            'template' => $wedding->template,
            'wedding' => $wedding,
        ]);
    }

    public function addWish(Request $request, Wedding $wedding): JsonResponse|RedirectResponse
    {
        abort_unless($wedding->status === 'published', 404);

        $validated = $request->validate([
            'guest_name' => ['required', 'string', 'min:2', 'max:50'],
            'message' => ['required', 'string', 'min:10', 'max:300'],
        ]);

        $wish = $wedding->wishes()->create([
            ...$validated,
            'is_approved' => true,
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Ucapan berhasil dikirim.',
                'wish' => [
                    'id' => $wish->id,
                    'guest_name' => $wish->guest_name,
                    'message' => $wish->message,
                    'created_at' => $wish->created_at,
                ],
            ], 201);
        }

        return back()->with('success', 'Ucapan berhasil dikirim.');
    }

    private function demoWedding(): Wedding
    {
        return Wedding::query()
            ->where('slug', 'dika-nur')
            ->with([
                'gallery',
                'approvedWishes' => fn ($query) => $query->limit(50),
            ])
            ->firstOrFail();
    }
}
