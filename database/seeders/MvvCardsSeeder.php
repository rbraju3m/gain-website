<?php

namespace Database\Seeders;

use App\Models\MvvCard;
use Illuminate\Database\Seeder;

class MvvCardsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'title'    => 'Our Mission',
                'tone'     => 'red',
                'icon_key' => 'target',
                'body'     => 'To eliminate malnutrition and ensure food security for all Bangladeshi families through sustainable, community-driven solutions.',
            ],
            [
                'title'    => 'Our Vision',
                'tone'     => 'green',
                'icon_key' => 'eye',
                'body'     => 'A Bangladesh where every family has access to nutritious food and the knowledge to maintain a healthy, sustainable lifestyle.',
            ],
            [
                'title'    => 'Our Values',
                'tone'     => 'orange',
                'icon_key' => 'star',
                'body'     => 'Integrity, compassion, sustainability, innovation, and community empowerment guide everything we do.',
            ],
        ];

        foreach ($rows as $i => $row) {
            MvvCard::updateOrCreate(
                ['title' => $row['title']],
                array_merge($row, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }
}
