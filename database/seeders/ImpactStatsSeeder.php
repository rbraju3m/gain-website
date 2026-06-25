<?php

namespace Database\Seeders;

use App\Models\ImpactStat;
use Illuminate\Database\Seeder;

class ImpactStatsSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['label' => 'Families Served',    'counter' => 15000, 'suffix' => '+', 'tone' => 'red',    'icon_key' => 'people'],
            ['label' => 'Nutrition Programs', 'counter' => 250,   'suffix' => '+', 'tone' => 'green',  'icon_key' => 'food'],
            ['label' => 'Districts Covered',  'counter' => 52,    'suffix' => '',  'tone' => 'orange', 'icon_key' => 'location'],
            ['label' => 'Success Rate',       'counter' => 98,    'suffix' => '%', 'tone' => 'red',    'icon_key' => 'success'],
        ];

        foreach ($rows as $i => $row) {
            ImpactStat::updateOrCreate(
                ['label' => $row['label']],
                array_merge($row, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }
}
