<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Wedding;
use App\Models\WeddingGallery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;

uses(RefreshDatabase::class);

beforeEach(function () {
    Storage::fake('public');

    $this->admin = User::factory()->create(['role' => 'admin']);
    $this->template = Template::create([
        'slug' => 'elegant',
        'name' => 'Elegant',
        'style' => 'Mewah & Romantis',
        'theme_class' => 'theme-elegant',
        'description' => 'Template elegan untuk pengujian.',
        'features' => ['Layout clean'],
    ]);
    $this->validData = [
        'template_id' => $this->template->id,
        'groom_short_name' => 'Dika',
        'groom_full_name' => 'Dika Putra',
        'groom_parent' => 'Putra dari Bapak dan Ibu Dika',
        'bride_short_name' => 'Nur',
        'bride_full_name' => 'Siti Nur',
        'bride_parent' => 'Putri dari Bapak dan Ibu Nur',
        'wedding_date' => '2028-05-12 08:00:00',
        'events' => [
            'akad' => [
                'title' => 'Akad Nikah',
                'date' => '2028-05-12',
                'time' => '08:00',
                'place' => 'Gedung Serbaguna',
                'address' => 'Jalan Contoh No. 123',
            ],
            'resepsi' => [
                'title' => 'Resepsi',
                'date' => '2028-05-12',
                'time' => '11:00',
                'place' => 'Gedung Serbaguna',
                'address' => 'Jalan Contoh No. 123',
            ],
        ],
        'maps_url' => 'https://maps.google.com/?q=gedung',
        'status' => 'draft',
    ];
});

it('protects wedding administration routes', function () {
    $this->get(route('admin.weddings.index'))->assertRedirect(route('login'));

    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->get(route('admin.weddings.index'))
        ->assertForbidden();
});

it('renders wedding index create edit and navigation links', function () {
    $wedding = Wedding::create([...$this->validData, 'slug' => 'dika-nur']);
    $gallery = $wedding->gallery()->create([
        'photo_path' => 'weddings/'.$wedding->id.'/photo.jpg',
        'caption' => 'Foto pasangan',
        'sort_order' => 0,
    ]);
    $wedding->wishes()->create([
        'guest_name' => "O'Brian",
        'message' => 'Semoga selalu bahagia bersama.',
    ]);

    $this->actingAs($this->admin)
        ->get(route('admin.weddings.index'))
        ->assertOk()
        ->assertSee('Dika &amp; Nur', false)
        ->assertSee(route('admin.weddings.create'), false);

    $this->get(route('admin.weddings.create'))
        ->assertOk()
        ->assertSee('enctype="multipart/form-data"', false)
        ->assertSee('events[akad][title]', false);

    $this->get(route('admin.weddings.edit', $wedding))
        ->assertOk()
        ->assertSee('existing_gallery['.$gallery->id.'][caption]', false)
        ->assertSee("O'Brian");

    $this->get(route('admin.dashboard'))
        ->assertOk()
        ->assertSee(route('admin.weddings.index'), false);
});

it('creates a wedding with gallery uploads and collision-safe slug', function () {
    $response = $this->actingAs($this->admin)->post(route('admin.weddings.store'), [
        ...$this->validData,
        'gallery' => [UploadedFile::fake()->image('couple.jpg')],
        'gallery_captions' => ['Foto pasangan'],
    ]);

    $wedding = Wedding::query()->where('slug', 'dika-nur')->firstOrFail();
    $gallery = $wedding->gallery()->firstOrFail();

    $response->assertRedirect(route('admin.weddings.edit', $wedding));
    expect($gallery->caption)->toBe('Foto pasangan')
        ->and($gallery->sort_order)->toBe(0);
    Storage::disk('public')->assertExists($gallery->photo_path);

    $this->actingAs($this->admin)
        ->post(route('admin.weddings.store'), $this->validData)
        ->assertRedirect();

    $this->assertDatabaseHas('weddings', ['slug' => 'dika-nur-2']);
});

it('updates wedding data without changing its slug', function () {
    $wedding = Wedding::create([
        ...$this->validData,
        'slug' => 'dika-nur',
    ]);
    $updated = $this->validData;
    $updated['groom_short_name'] = 'Dikembangkan';
    $updated['status'] = 'published';

    $this->actingAs($this->admin)
        ->put(route('admin.weddings.update', $wedding), $updated)
        ->assertRedirect(route('admin.weddings.edit', $wedding));

    $wedding->refresh();

    expect($wedding->slug)->toBe('dika-nur')
        ->and($wedding->groom_short_name)->toBe('Dikembangkan')
        ->and($wedding->status)->toBe('published');
});

it('supports an optional reception but validates a partially filled one', function () {
    $withoutReception = $this->validData;
    unset($withoutReception['events']['resepsi']);

    $this->actingAs($this->admin)
        ->post(route('admin.weddings.store'), $withoutReception)
        ->assertRedirect();

    expect(Wedding::firstOrFail()->events)->not->toHaveKey('resepsi');

    $partialReception = $this->validData;
    $partialReception['groom_short_name'] = 'Bima';
    $partialReception['events']['resepsi'] = ['title' => 'Resepsi'];

    $this->actingAs($this->admin)
        ->post(route('admin.weddings.store'), $partialReception)
        ->assertSessionHasErrors([
            'events.resepsi.date',
            'events.resepsi.time',
            'events.resepsi.place',
            'events.resepsi.address',
        ]);
});

it('rejects invalid gallery uploads', function () {
    $this->actingAs($this->admin)
        ->post(route('admin.weddings.store'), [
            ...$this->validData,
            'gallery' => [UploadedFile::fake()->create('script.php', 10, 'application/x-php')],
        ])
        ->assertSessionHasErrors('gallery.0');

    expect(Wedding::count())->toBe(0);
});

it('rolls back the wedding and cleans uploaded files when gallery persistence fails', function () {
    $eventName = 'eloquent.creating: '.WeddingGallery::class;
    Event::listen($eventName, function () {
        throw new RuntimeException('Simulated gallery persistence failure.');
    });

    try {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.weddings.store'), [
                ...$this->validData,
                'gallery' => [UploadedFile::fake()->image('couple.jpg')],
            ]);
    } finally {
        Event::forget($eventName);
    }

    $response->assertServerError();
    expect(Wedding::count())->toBe(0)
        ->and(Storage::disk('public')->allFiles())->toBeEmpty();
});

it('updates and deletes owned gallery photos with storage cleanup', function () {
    $wedding = Wedding::create([...$this->validData, 'slug' => 'dika-nur']);
    Storage::disk('public')->put('weddings/'.$wedding->id.'/photo.jpg', 'photo');
    $gallery = $wedding->gallery()->create([
        'photo_path' => 'weddings/'.$wedding->id.'/photo.jpg',
        'caption' => 'Lama',
        'sort_order' => 0,
    ]);

    $this->actingAs($this->admin)
        ->put(route('admin.weddings.update', $wedding), [
            ...$this->validData,
            'existing_gallery' => [
                $gallery->id => ['caption' => 'Baru', 'sort_order' => 4],
            ],
        ])
        ->assertRedirect();

    expect($gallery->refresh()->caption)->toBe('Baru')
        ->and($gallery->sort_order)->toBe(4);

    $this->actingAs($this->admin)
        ->delete(route('admin.weddings.gallery.destroy', [$wedding, $gallery]))
        ->assertRedirect();

    $this->assertDatabaseMissing('wedding_gallery', ['id' => $gallery->id]);
    Storage::disk('public')->assertMissing($gallery->photo_path);
});

it('deletes a wedding with child records and all gallery files', function () {
    $wedding = Wedding::create([...$this->validData, 'slug' => 'dika-nur']);
    $path = 'weddings/'.$wedding->id.'/photo.jpg';
    Storage::disk('public')->put($path, 'photo');
    $wedding->gallery()->create(['photo_path' => $path, 'sort_order' => 0]);
    $wish = $wedding->wishes()->create([
        'guest_name' => 'Budi',
        'message' => 'Semoga selalu bahagia bersama.',
    ]);

    $this->actingAs($this->admin)
        ->delete(route('admin.weddings.destroy', $wedding))
        ->assertRedirect(route('admin.weddings.index'));

    $this->assertDatabaseMissing('weddings', ['id' => $wedding->id]);
    $this->assertDatabaseMissing('wedding_wishes', ['id' => $wish->id]);
    Storage::disk('public')->assertMissing($path);
});

it('manages owned wishes and blocks cross-wedding nested resources', function () {
    $first = Wedding::create([...$this->validData, 'slug' => 'dika-nur']);
    $second = Wedding::create([...$this->validData, 'slug' => 'bima-sari']);
    $wish = $second->wishes()->create([
        'guest_name' => 'Budi',
        'message' => 'Semoga selalu bahagia bersama.',
    ]);
    $gallery = $second->gallery()->create([
        'photo_path' => 'weddings/'.$second->id.'/photo.jpg',
        'sort_order' => 0,
    ]);

    $this->actingAs($this->admin)
        ->put(route('admin.weddings.update', $first), [
            ...$this->validData,
            'existing_gallery' => [
                $gallery->id => ['caption' => 'Disusupi', 'sort_order' => 99],
            ],
        ])
        ->assertNotFound();

    expect($gallery->refresh()->caption)->toBeNull()
        ->and($gallery->sort_order)->toBe(0);

    $this->actingAs($this->admin)
        ->patch(route('admin.weddings.wishes.toggle', [$first, $wish]))
        ->assertNotFound();

    $this->actingAs($this->admin)
        ->delete(route('admin.weddings.gallery.destroy', [$first, $gallery]))
        ->assertNotFound();

    expect($wish->refresh()->is_approved)->toBeTrue();

    $this->actingAs($this->admin)
        ->patch(route('admin.weddings.wishes.toggle', [$second, $wish]))
        ->assertRedirect();

    expect($wish->refresh()->is_approved)->toBeFalse();

    $this->actingAs($this->admin)
        ->delete(route('admin.weddings.wishes.destroy', [$second, $wish]))
        ->assertRedirect();

    $this->assertDatabaseMissing('wedding_wishes', ['id' => $wish->id]);
});
