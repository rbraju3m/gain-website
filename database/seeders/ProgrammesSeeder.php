<?php

namespace Database\Seeders;

use App\Models\Programme;
use Illuminate\Database\Seeder;

class ProgrammesSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title'    => 'Community Nutrition Gardens',
                'category' => 'Agriculture',
                'body'     => 'Empowering families to grow their own fresh, nutritious vegetables through sustainable agriculture training.',
                'url'      => '#',
            ],
            [
                'title'    => 'Maternal & Child Nutrition',
                'category' => 'Healthcare',
                'body'     => 'Supporting mothers and children with essential nutrition education, supplements, and healthcare services.',
                'url'      => '#',
            ],
            [
                'title'    => 'Farmer Training & Livelihood',
                'category' => 'Education',
                'body'     => 'Hands-on training in modern, climate-smart farming techniques to boost yield, income, and food security.',
                'url'      => '#',
            ],
            [
                'title'    => 'Nutrition Education & Awareness',
                'category' => 'Outreach',
                'body'     => 'Community workshops on balanced diets, hygiene, and child nutrition reaching tens of thousands of households.',
                'url'      => '#',
            ],
        ];

        foreach ($items as $i => $item) {
            Programme::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }
}
