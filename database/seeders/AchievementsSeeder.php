<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title'    => 'Workers Empowered',
                'icon_key' => 'people',
                'rows'     => [
                    ['label' => 'Total Reached',          'value' => '71,000+', 'tone' => 'red'],
                    ['label' => 'Actively Participating', 'value' => '45,000+', 'tone' => 'green'],
                ],
            ],
            [
                'title'    => 'Programme Components',
                'icon_key' => 'book',
                'rows'     => [
                    ['label' => 'TVET Education',  'value' => '400', 'tone' => 'red'],
                    ['label' => 'IEC Courses',     'value' => '10',  'tone' => 'green'],
                    ['label' => 'Fair Price Shops','value' => '12',  'tone' => 'orange'],
                ],
            ],
            [
                'title'    => 'Factory Partnerships',
                'icon_key' => 'factory',
                'rows'     => [
                    ['label' => 'On-Boarded',  'value' => '5',  'tone' => 'red'],
                    ['label' => 'Surveyed',    'value' => '0',  'tone' => 'green'],
                    ['label' => 'Target 2025', 'value' => '13', 'tone' => 'orange'],
                ],
            ],
            [
                'title'    => 'Impact Metrics',
                'icon_key' => 'trending',
                'rows'     => [
                    ['label' => 'Productivity Increased', 'value' => '15%', 'tone' => 'red'],
                    ['label' => 'Health Improvement',     'value' => '—',   'tone' => 'green'],
                    ['label' => 'Income Increase',        'value' => '—',   'tone' => 'orange'],
                ],
            ],
        ];

        foreach ($rows as $i => $row) {
            Achievement::updateOrCreate(
                ['title' => $row['title']],
                array_merge($row, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }
}
