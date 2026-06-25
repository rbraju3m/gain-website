<?php

namespace Database\Seeders;

use App\Models\NewsArticle;
use Illuminate\Database\Seeder;

class NewsArticlesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title'    => 'New Community Garden Initiative Launches in Sylhet Division',
                'category' => 'Initiative',
                'excerpt'  => '50 families receive training and resources to establish sustainable nutrition gardens in their communities.',
                'days_ago' => 41,
            ],
            [
                'title'    => 'Annual Report 2025: Record Impact Across All Divisions',
                'category' => 'Report',
                'excerpt'  => 'Our comprehensive annual report showcases unprecedented growth and community impact achievements.',
                'days_ago' => 46,
            ],
            [
                'title'    => 'Partnership Announcement: Expanding Maternal Health Services',
                'category' => 'Partnership',
                'excerpt'  => 'Collaborating with international partners to reach 5,000 more mothers with nutrition education.',
                'days_ago' => 51,
            ],
        ];

        foreach ($items as $item) {
            NewsArticle::updateOrCreate(
                ['slug' => NewsArticle::generateSlug($item['title'])],
                [
                    'title'        => $item['title'],
                    'category'     => $item['category'],
                    'excerpt'      => $item['excerpt'],
                    'published_at' => now()->subDays($item['days_ago']),
                ]
            );
        }
    }
}
