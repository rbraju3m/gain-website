<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionsSeeder extends Seeder
{
    public function run(): void
    {
        // Keys match <g id="..."> in the Bangladesh SVG.
        $rows = [
            ['key' => 'rongpur',    'name' => 'Rangpur',    'families' => '1,800+', 'programmes' => 22, 'success_rate' => '96%'],
            ['key' => 'rajshahi',   'name' => 'Rajshahi',   'families' => '2,400+', 'programmes' => 35, 'success_rate' => '97%'],
            ['key' => 'mymensingh', 'name' => 'Mymensingh', 'families' => '1,500+', 'programmes' => 18, 'success_rate' => '94%'],
            ['key' => 'sylhet',     'name' => 'Sylhet',     'families' => '1,900+', 'programmes' => 24, 'success_rate' => '95%'],
            ['key' => 'dhaka',      'name' => 'Dhaka',      'families' => '4,200+', 'programmes' => 62, 'success_rate' => '98%'],
            ['key' => 'khulna',     'name' => 'Khulna',     'families' => '2,000+', 'programmes' => 28, 'success_rate' => '96%'],
            ['key' => 'barisal',    'name' => 'Barisal',    'families' => '1,200+', 'programmes' => 19, 'success_rate' => '95%'],
            ['key' => 'chittagong', 'name' => 'Chittagong', 'families' => '3,100+', 'programmes' => 42, 'success_rate' => '97%'],
        ];

        foreach ($rows as $i => $row) {
            Division::updateOrCreate(['key' => $row['key']], array_merge($row, ['sort_order' => $i + 1]));
        }
    }
}
