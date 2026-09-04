<?php

namespace Database\Seeders;

use App\Models\Template;
use App\Models\Wedding;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use RuntimeException;

class WeddingSeeder extends Seeder
{
    public function run(): void
    {
        $template = Template::query()->where('slug', 'elegant')->first();

        if (! $template) {
            throw new RuntimeException('Jalankan TemplateSeeder sebelum WeddingSeeder.');
        }

        $wedding = Wedding::updateOrCreate(
            ['slug' => 'dika-nur'],
            [
                'template_id' => $template->id,
                'groom_short_name' => 'Dika',
                'groom_full_name' => 'Dika Putra',
                'groom_parent' => 'Putra dari Bapak Ahmad & Ibu Siti',
                'bride_short_name' => 'Nur',
                'bride_full_name' => 'Siti Nur',
                'bride_parent' => 'Putri dari Bapak Hadi & Ibu Aminah',
                'wedding_date' => '2028-05-12 08:00:00',
                'events' => [
                    'akad' => [
                        'title' => 'Akad Nikah',
                        'date' => '2028-05-12',
                        'time' => '08:00',
                        'place' => 'Gedung Serbaguna Yogyakarta',
                        'address' => 'Jl. Contoh Alamat No. 123, Yogyakarta',
                    ],
                    'resepsi' => [
                        'title' => 'Resepsi',
                        'date' => '2028-05-12',
                        'time' => '11:00',
                        'place' => 'Gedung Serbaguna Yogyakarta',
                        'address' => 'Jl. Contoh Alamat No. 123, Yogyakarta',
                    ],
                ],
                'maps_url' => 'https://www.google.com/maps/search/?api=1&query=Gedung%20Serbaguna%20Yogyakarta%2C%20Jl.%20Contoh%20Alamat%20No.%20123%2C%20Yogyakarta',
                'status' => 'published',
            ]
        );

        $wishes = [
            'Andi' => 'Semoga menjadi keluarga yang sakinah, mawaddah, warahmah.',
            'Siti' => 'Selamat menempuh hidup baru, semoga bahagia selalu.',
        ];

        foreach ($wishes as $guestName => $message) {
            $wedding->wishes()->updateOrCreate(
                ['guest_name' => $guestName, 'message' => $message],
                ['is_approved' => true]
            );
        }

        $sourceDirectory = public_path('images/wedding/demo-gallery');

        if (! is_dir($sourceDirectory)) {
            return;
        }

        foreach (glob($sourceDirectory.'/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [] as $index => $sourcePath) {
            $destination = 'weddings/demo/'.basename($sourcePath);

            if (! Storage::disk('public')->exists($destination)) {
                $contents = file_get_contents($sourcePath);

                if ($contents === false || ! Storage::disk('public')->put($destination, $contents)) {
                    throw new RuntimeException('Galeri demo gagal disalin ke disk public.');
                }
            }

            $wedding->gallery()->updateOrCreate(
                ['photo_path' => $destination],
                [
                    'caption' => 'Galeri pernikahan Dika dan Nur',
                    'sort_order' => $index,
                ]
            );
        }
    }
}
