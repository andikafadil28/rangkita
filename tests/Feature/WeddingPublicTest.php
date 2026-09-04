<?php

use App\Models\Template;
use App\Models\User;
use App\Models\Wedding;
use Database\Seeders\TemplateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->template = Template::create([
        'slug' => 'elegant',
        'name' => 'Elegant',
        'style' => 'Mewah & Romantis',
        'theme_class' => 'theme-elegant',
        'description' => 'Template elegan untuk pengujian.',
        'features' => ['Layout clean'],
        'icon' => 'E',
        'message' => 'Saya tertarik dengan template Elegant.',
    ]);

    $this->wedding = Wedding::create([
        'template_id' => $this->template->id,
        'slug' => 'dika-nur',
        'groom_short_name' => 'Dika',
        'groom_full_name' => 'Dika Putra',
        'bride_short_name' => 'Nur',
        'bride_full_name' => 'Siti Nur',
        'wedding_date' => '2028-05-12 08:00:00',
        'events' => [
            'akad' => [
                'title' => 'Akad Nikah',
                'date' => '2028-05-12',
                'time' => '08:00',
                'place' => 'Gedung Serbaguna',
                'address' => 'Jalan Contoh',
            ],
            'resepsi' => [
                'title' => 'Resepsi',
                'date' => '2028-05-12',
                'time' => '11:00',
                'place' => 'Gedung Serbaguna',
                'address' => 'Jalan Contoh',
            ],
        ],
        'status' => 'published',
    ]);
});

it('serves database-backed wedding marketing pages', function () {
    $this->get(route('weddings.index'))
        ->assertOk()
        ->assertSee('Elegant');

    $this->get(route('weddings.template', $this->template))->assertOk();
    $this->get(route('weddings.preview', $this->template))->assertOk();
});

it('renders all six template motion profiles through one shared engine', function () {
    (new TemplateSeeder)->run();

    $templates = Template::query()->orderBy('id')->get();

    expect($templates)->toHaveCount(6);

    foreach ($templates as $template) {
        $this->get(route('weddings.preview', $template))
            ->assertOk()
            ->assertSee('class="wedding-preview-body '.$template->theme_class.'"', false)
            ->assertSee('data-reveal', false)
            ->assertSee('data-stagger', false)
            ->assertSee('js/wedding-invitation.js', false);
    }
});

it('allows guests to view published weddings', function () {
    $this->get(route('weddings.show', $this->wedding))
        ->assertOk()
        ->assertSee('Dika');
});

it('renders shared database content with optional reception and escaped wishes', function () {
    $events = $this->wedding->events;
    unset($events['resepsi']);
    $this->wedding->update(['events' => $events]);
    $this->wedding->gallery()->create([
        'photo_path' => 'weddings/'.$this->wedding->id.'/couple.webp',
        'caption' => 'Foto akad',
        'sort_order' => 0,
    ]);
    $this->wedding->wishes()->create([
        'guest_name' => '<script>alert(1)</script>',
        'message' => 'Semoga selalu bahagia bersama.',
        'is_approved' => true,
    ]);
    $this->wedding->wishes()->create([
        'guest_name' => 'Disembunyikan',
        'message' => 'Ucapan ini tidak boleh terlihat publik.',
        'is_approved' => false,
    ]);

    $this->get(route('weddings.show', $this->wedding))
        ->assertOk()
        ->assertSee('src="'.url('/storage/weddings/'.$this->wedding->id.'/couple.webp').'"', false)
        ->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)
        ->assertDontSee('<script>alert(1)</script>', false)
        ->assertDontSee('Disembunyikan')
        ->assertDontSee('Resepsi')
        ->assertSee('name="guest_name"', false)
        ->assertSee('aria-hidden="false"', false)
        ->assertDontSee('class="wedding-preview-body theme-elegant invitation-locked"', false);

    $this->get(route('weddings.preview', $this->template))
        ->assertOk()
        ->assertSee('Form ucapan aktif pada undangan pelanggan.')
        ->assertDontSee('name="guest_name"', false);
});

it('supports wish submission without javascript', function () {
    $this->from(route('weddings.show', $this->wedding))
        ->post(route('weddings.wishes.store', $this->wedding), [
            'guest_name' => 'Budi',
            'message' => 'Semoga selalu bahagia bersama.',
        ])
        ->assertRedirect(route('weddings.show', $this->wedding));

    $this->get(route('weddings.show', $this->wedding))
        ->assertOk()
        ->assertSee('Budi')
        ->assertSee('Semoga selalu bahagia bersama.');
});

it('only loads the latest fifty approved wishes', function () {
    $now = now();
    $rows = [];

    foreach (range(1, 55) as $number) {
        $rows[] = [
            'wedding_id' => $this->wedding->id,
            'guest_name' => 'Tamu '.$number,
            'message' => 'Semoga selalu bahagia untuk kedua mempelai.',
            'is_approved' => true,
            'created_at' => $now->copy()->subMinutes(55 - $number),
            'updated_at' => $now,
        ];
    }

    $rows[] = [
        'wedding_id' => $this->wedding->id,
        'guest_name' => 'Wish tersembunyi terbaru',
        'message' => 'Ucapan ini tidak boleh ikut dimuat.',
        'is_approved' => false,
        'created_at' => $now->copy()->addMinute(),
        'updated_at' => $now,
    ];

    DB::table('wedding_wishes')->insert($rows);

    $this->get(route('weddings.show', $this->wedding))
        ->assertOk()
        ->assertViewHas('wedding', function (Wedding $wedding) {
            return $wedding->approvedWishes->count() === 50
                && $wedding->approvedWishes->first()->guest_name === 'Tamu 55'
                && ! $wedding->approvedWishes->contains('guest_name', 'Tamu 1')
                && ! $wedding->approvedWishes->contains('guest_name', 'Wish tersembunyi terbaru');
        });
});

it('renders a csrf token in the public wish form', function () {
    $this->get(route('weddings.show', $this->wedding))
        ->assertOk()
        ->assertSee('name="_token"', false);
});

it('hides draft weddings from guests but allows admins to preview them', function () {
    $this->wedding->update(['status' => 'draft']);

    $this->get(route('weddings.show', $this->wedding))->assertNotFound();

    $user = User::factory()->create(['role' => 'user']);

    $this->actingAs($user)
        ->get(route('weddings.show', $this->wedding))
        ->assertNotFound();

    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get(route('weddings.show', $this->wedding))
        ->assertOk();
});

it('stores approved wishes for published weddings', function () {
    $response = $this->postJson(route('weddings.wishes.store', $this->wedding), [
        'guest_name' => 'Budi',
        'message' => 'Semoga selalu bahagia bersama.',
    ]);

    $response
        ->assertCreated()
        ->assertJsonPath('wish.guest_name', 'Budi');

    $this->assertDatabaseHas('wedding_wishes', [
        'wedding_id' => $this->wedding->id,
        'guest_name' => 'Budi',
        'is_approved' => true,
    ]);
});

it('rejects invalid wishes', function () {
    $this->postJson(route('weddings.wishes.store', $this->wedding), [
        'guest_name' => 'B',
        'message' => 'Pendek',
    ])->assertUnprocessable();
});

it('rejects wishes for draft weddings', function () {
    $this->wedding->update(['status' => 'draft']);

    $this->postJson(route('weddings.wishes.store', $this->wedding), [
        'guest_name' => 'Budi',
        'message' => 'Semoga selalu bahagia bersama.',
    ])->assertNotFound();
});

it('rate limits repeated wish submissions', function () {
    foreach (range(1, 5) as $attempt) {
        $this->postJson(route('weddings.wishes.store', $this->wedding), [
            'guest_name' => 'Tamu '.$attempt,
            'message' => 'Semoga selalu bahagia bersama.',
        ])->assertCreated();
    }

    $this->postJson(route('weddings.wishes.store', $this->wedding), [
        'guest_name' => 'Tamu terakhir',
        'message' => 'Semoga selalu bahagia bersama.',
    ])->assertTooManyRequests();
});
