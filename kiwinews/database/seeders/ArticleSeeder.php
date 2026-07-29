<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use Carbon\Carbon;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        // Breaking News Ticker Items
        Article::create([
            'title' => 'Senate court cuts short De Lima\'s opening remarks on alleged confi fund misuse',
            'slug' => 'senate-court-cuts-short-de-lima-remarks',
            'excerpt' => 'The Senate impeachment court intervened during the opening statements.',
            'body' => 'Full details of the Senate trial proceedings...',
            'category' => 'Nation',
            'image_url' => 'https://via.placeholder.com/800x450',
            'is_breaking' => true,
            'published_at' => Carbon::now()->subMinutes(10),
        ]);

        Article::create([
            'title' => 'Ex-LandBank manager: OVP confidential fund checks already shredded',
            'slug' => 'ex-landbank-manager-ovp-checks-shredded',
            'excerpt' => 'Testimony reveals details regarding checks issued.',
            'body' => 'Full details of the LandBank testimony...',
            'category' => 'Nation',
            'image_url' => 'https://via.placeholder.com/800x450',
            'is_breaking' => true,
            'published_at' => Carbon::now()->subMinutes(25),
        ]);

        // Main Featured Hero Story
        Article::create([
            'title' => 'LIVE UPDATES: Sara Duterte Impeachment Trial (Day 10)',
            'slug' => 'live-updates-sara-duterte-impeachment-trial',
            'excerpt' => 'Follow the latest updates, testimonies, and arguments presented at the Senate impeachment trial.',
            'body' => 'Comprehensive coverage of the trial...',
            'category' => 'Nation',
            'image_url' => 'https://via.placeholder.com/800x450',
            'is_featured' => true,
            'published_at' => Carbon::now()->subHour(),
        ]);

        // Top Stories / Sidebar Items
        $topTitles = [
            'PNP: Investigators have leads in IED cases during SONA',
            'Teodoro warns of growing foreign malign influence in PH',
            'Robin Padilla, Raffy Tulfo top voting preference for senatorial polls',
            'US intercepts Iranian ballistic missiles launched toward US forces',
            'SB19\'s Pablo offers 5 versions of \'Usad\' in EP',
            'NBA: Draymond Green agrees to $27.7-M deal with Warriors'
        ];

        foreach ($topTitles as $index => $title) {
            Article::create([
                'title' => $title,
                'slug' => \Illuminate\Support\Str::slug($title),
                'excerpt' => 'Short summary for ' . $title,
                'body' => 'Full content for ' . $title,
                'category' => $index % 2 == 0 ? 'Nation' : 'Entertainment',
                'image_url' => 'https://via.placeholder.com/400x250',
                'is_featured' => false,
                'published_at' => Carbon::now()->subHours($index + 1),
            ]);
        }

        // Nation Category Items
        for ($i = 1; $i <= 4; $i++) {
            Article::create([
                'title' => 'Nation News Update # ' . $i . ' regarding local developments and updates',
                'slug' => 'nation-news-update-' . $i,
                'excerpt' => 'Excerpt for nation news ' . $i,
                'body' => 'Body text...',
                'category' => 'Nation',
                'image_url' => 'https://via.placeholder.com/400x250',
                'published_at' => Carbon::now()->subHours($i),
            ]);
        }

        // Entertainment Category Items
        for ($i = 1; $i <= 4; $i++) {
            Article::create([
                'title' => 'Showbiz and Entertainment Buzz # ' . $i . ' latest celebrity scoop',
                'slug' => 'entertainment-buzz-' . $i,
                'excerpt' => 'Excerpt for entertainment ' . $i,
                'body' => 'Body text...',
                'category' => 'Entertainment',
                'image_url' => 'https://via.placeholder.com/400x250',
                'published_at' => Carbon::now()->subHours($i),
            ]);
        }
    }
}
