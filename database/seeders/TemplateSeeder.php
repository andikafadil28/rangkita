<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'icon' => '✨',
                'slug' => 'elegant',
                'name' => 'Elegant',
                'style' => 'Mewah & Romantis',
                'theme_class' => 'theme-elegant',
                'description' => 'Template dengan nuansa elegan, cocok untuk acara pernikahan formal dan berkesan mewah.',
                'features' => ['Warna lembut', 'Layout clean', 'Cocok untuk resepsi'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Elegant untuk undangan online.',
            ],
            [
                'icon' => '🌿',
                'slug' => 'minimalis',
                'name' => 'Minimalis',
                'style' => 'Simple & Bersih',
                'theme_class' => 'theme-minimalis',
                'description' => 'Template sederhana dengan tampilan rapi, ringan, dan nyaman dibuka dari HP.',
                'features' => ['Tampilan simpel', 'Cepat dibuka', 'Informasi mudah dibaca'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Minimalis untuk undangan online.',
            ],
            [
                'icon' => '🌸',
                'slug' => 'floral',
                'name' => 'Floral',
                'style' => 'Manis & Hangat',
                'theme_class' => 'theme-floral',
                'description' => 'Template bernuansa bunga yang cocok untuk pasangan yang ingin tampilan lembut dan romantis.',
                'features' => ['Nuansa bunga', 'Warna soft', 'Kesan romantis'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Floral untuk undangan online.',
            ],
            [
                'icon' => '🚀',
                'slug' => 'modern',
                'name' => 'Modern',
                'style' => 'Fresh & Kekinian',
                'theme_class' => 'theme-modern',
                'description' => 'Template modern dengan tampilan lebih berani, cocok untuk konsep acara yang lebih santai.',
                'features' => ['Desain kekinian', 'Visual menarik', 'Cocok untuk anak muda'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Modern untuk undangan online.',
            ],
            [
                'icon' => '🪶',
                'slug' => 'classic',
                'name' => 'Classic',
                'style' => 'Elegan & Timeless',
                'theme_class' => 'theme-classic',
                'description' => 'Template undangan dengan nuansa klasik yang elegan, rapi, dan berkesan formal. Cocok untuk acara yang ingin terlihat anggun dan berkelas.',
                'features' => ['Desain elegan', 'Nuansa Klasik', 'Tampilan rapi dan formal'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Classic untuk undangan online.',
            ],
            [
                'icon' => '👑',
                'slug' => 'royal',
                'name' => 'Royal',
                'style' => 'Mewah & Berkelas',
                'theme_class' => 'theme-royal',
                'description' => 'Template undangan dengan nuansa royal yang elegan, mewah, dan berkesan premium. Cocok untuk acara pernikahan yang ingin tampil anggun, formal, dan berkelas.',
                'features' => ['Desain mewah', 'Nuansa elegan dan premium', 'Cocok untuk konsep pernikahan berkelas'],
                'message' => 'Halo Rangkita, saya tertarik dengan Template Royal untuk undangan online.',
            ],
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}
