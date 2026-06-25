<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnersSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            // Strategic (row 1, static grid)
            ['name' => 'World Food Programme',       'slug' => 'wfp',             'group' => Partner::GROUP_STRATEGIC],
            ['name' => 'UNICEF Bangladesh',          'slug' => 'unicef',          'group' => Partner::GROUP_STRATEGIC],
            ['name' => 'BRAC',                       'slug' => 'brac',            'group' => Partner::GROUP_STRATEGIC],
            ['name' => 'FAO Bangladesh',             'slug' => 'fao',             'group' => Partner::GROUP_STRATEGIC],

            // Implementing (row 2, marquee)
            ['name' => 'Save the Children',          'slug' => 'savethechildren', 'group' => Partner::GROUP_IMPLEMENTING],
            ['name' => 'ActionAid',                  'slug' => 'actionaid',       'group' => Partner::GROUP_IMPLEMENTING],
            ['name' => 'Ministry of Health',         'slug' => 'moh',             'group' => Partner::GROUP_IMPLEMENTING],
            ['name' => 'Local Government Division',  'slug' => 'lgd',             'group' => Partner::GROUP_IMPLEMENTING],
        ];

        foreach ($rows as $i => $row) {
            Partner::updateOrCreate(
                ['slug' => $row['slug']],
                array_merge($row, [
                    'sort_order'   => $i + 1,
                    'is_published' => true,
                ])
            );
        }
    }
}
