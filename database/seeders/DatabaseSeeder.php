<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'password' => bcrypt('password'), 'role' => 'admin']
        );

        $editor = User::firstOrCreate(
            ['email' => 'editor@example.com'],
            ['name' => 'ShiftEditor', 'password' => bcrypt('password'), 'role' => 'editor']
        );

        // Categories (ShiftDelete/Webtekno style)
        $categories = [
            'Teknoloji', 'Mobil', 'Donanım', 'Oyun', 'Otomobil', 'Sinema & TV', 'Yazılım', 'Yapay Zeka'
        ];

        foreach ($categories as $catName) {
            Category::firstOrCreate(
                ['slug' => Str::slug($catName)],
                ['name' => $catName, 'is_active' => true]
            );
        }

        // Sample Articles
        $titles = [
            'iPhone 16 Pro Max Sızıntıları: Neler Bekliyoruz?' => 'Mobil',
            'GTA 6 Çıkış Tarihi Netleşti mi? Rockstar\'dan Açıklama Var' => 'Oyun',
            'Tesla Model Y Türkiye Fiyatında Büyük İndirim' => 'Otomobil',
            'Windows 12 Özellikleri Sızdırıldı: Yapay Zeka Odaklı Olacak' => 'Yazılım',
            'NVIDIA RTX 5090 Ne Kadar Hızlı? İlk Test Sonuçları' => 'Donanım',
            'ChatGPT vs Gemini: Hangisi Daha Akıllı?' => 'Yapay Zeka',
            'Samsung Galaxy S25 Ultra Konsept Görüntüleri Büyüledi' => 'Mobil',
            'Netflix\'in Yeni Dizisi İzlenme Rekorları Kırıyor' => 'Sinema & TV',
            'Xiaomi\'nin Yeni Elektrikli Aracı Tanıtıldı' => 'Otomobil',
            'Google I/O 2025: Android 16 Geliyor' => 'Yazılım',
        ];

        foreach ($titles as $title => $catName) {
            $category = Category::where('name', $catName)->first();
            
            $content = "
                <p><strong>{$title}</strong> hakkında son gelişmeler teknoloji dünyasını heyecanlandırdı.</p>
                <p>Detaylara indiğimizde, kullanıcıların beklentilerini karşılayacak özellikler görüyoruz.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <p><img src='https://placehold.co/800x400?text=" . Str::slug($title) . "' alt='Görsel' /></p>
                <h3>Yeni Özellikler Neler?</h3>
                <ul>
                    <li>Daha hızlı işlemci performansı</li>
                    <li>Geliştirilmiş batarya ömrü</li>
                    <li>Yapay zeka entegrasyonu</li>
                </ul>
                <p>Sonuç olarak, bu gelişme sektörde büyük ses getirecek gibi duruyor.</p>
            ";

            Article::firstOrCreate(
                ['title' => $title],
                [
                    'slug' => Str::slug($title) . '-' . Str::random(5),
                    'content' => $content,
                    'image' => null,
                    'category_id' => $category->id,
                    'user_id' => $editor->id,
                    'type' => rand(0, 10) > 8 ? 'post' : 'news',
                    'published_at' => now(),
                    'is_active' => true,
                ]
            );
        }

        // Feature: Review Videos (YouTube IDs)
        $videos = [
            'iPhone 15 Pro Max İnceleme' => 'xqyUdNxWazA', // Example ID
            'PlayStation 5 Slim Kutu Açılışı' => '1I-5rD8lyyw',
            'Tesla Model 3 Performans İncelemesi' => 't705r8ICkRw',
            'Samsung Galaxy S24 Ultra Detaylı İnceleme' => '9ZfN87gSjdI',
            'MacBook Pro M3 Max - Canavar mı?' => '0p4d_RqJ9uU',
        ];

        foreach ($videos as $title => $id) {
            Video::firstOrCreate(
                ['youtube_id' => $id],
                [
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'is_active' => true,
                    'order' => 0
                ]
            );
        }

        // Proof of Concept: Question with Image
        Question::firstOrCreate(
            ['title' => 'Bu ekran kartı kasaya sığar mı? (Örnek Soru)'],
            [
                'user_id' => $admin->id,
                'is_approved' => true,
                'content' => '
                    <p>Merhaba arkadaşlar, yeni bir RTX 4090 almayı düşünüyorum ama kasama sığacağından emin değilim.</p>
                    <p>Kasamın iç görüntüsü şu şekilde:</p>
                    <p><img src="https://placehold.co/600x400?text=Kasa+İçi+Görüntüsü" alt="Kasa Resmi" style="width: 50%;"></p>
                    <p>Sizce sığar mı? Ölçüleri 35cm.</p>
                '
            ]
        );
    }
}
