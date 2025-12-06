<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class BrandingSeeder extends Seeder
{
    public function run(): void
    {
        // Social Media Links (4 examples)
        $socials = [
            [
                'name' => 'Twitter',
                'url' => 'https://twitter.com/teknorota',
                'icon' => 'fa-brands fa-x-twitter',
                'color' => '#000000',
                'order' => 1
            ],
            [
                'name' => 'Instagram',
                'url' => 'https://instagram.com/teknorota',
                'icon' => 'fa-brands fa-instagram',
                'color' => '#E1306C',
                'order' => 2
            ],
            [
                'name' => 'YouTube',
                'url' => 'https://youtube.com/teknorota',
                'icon' => 'fa-brands fa-youtube',
                'color' => '#FF0000',
                'order' => 3
            ],
            [
                'name' => 'LinkedIn',
                'url' => 'https://linkedin.com/in/alifiratozer',
                'icon' => 'fa-brands fa-linkedin',
                'color' => '#0077B5',
                'order' => 4
            ],
        ];

        foreach ($socials as $s) {
            SocialMedia::firstOrCreate(['name' => $s['name']], $s);
        }

        // Site Settings (About Page)
        $aboutContent = "
            <p>Merhaba, ben <strong>Ali Fırat Özer</strong>.</p>
            <p>Üniversite öğrencisiyim ve teknolojiye, bilime, yazılıma büyük bir tutkum var. <strong>TeknoRota</strong> projesini, bu tutkumu paylaşmak ve Türkiye'deki teknoloji okuryazarlığına katkıda bulunmak amacıyla geliştirdim.</p>
            <p>Bu platformda en güncel mobil cihaz incelemelerini, yapay zeka alanındaki son gelişmeleri ve yazılım dünyasından haberleri bulabilirsiniz. Amacım, karmaşık teknolojik terimleri herkesin anlayabileceği sade bir dille aktarmak.</p>
            <p>Takipte kalın!</p>
        ";

        SiteSetting::updateOrCreate(['key' => 'about.title'], ['value' => 'Hakkımda']);
        SiteSetting::updateOrCreate(['key' => 'about.content'], ['value' => $aboutContent]);
        
        // Branding Defaults
        SiteSetting::updateOrCreate(['key' => 'site.title'], ['value' => 'TeknoRota']);
        // Logo/Favicon left null for user upload
    }
}
