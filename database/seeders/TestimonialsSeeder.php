<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'author_name' => 'Amina Rahman',
                'author_role' => 'Programme Participant, Dhaka Division',
                'quote'       => "This program transformed our family's life. Now we grow our own vegetables and my children are healthier than ever. The training we received gave us hope and a sustainable future.",
            ],
            [
                'author_name' => 'Karim Ahmed',
                'author_role' => 'Farmer, Chittagong Division',
                'quote'       => "The agricultural training helped me improve crop yields by 60%. I can now support my family better and contribute to our community's food security. Thank you for believing in us.",
            ],
        ];

        foreach ($items as $i => $item) {
            Testimonial::updateOrCreate(
                ['author_name' => $item['author_name']],
                array_merge($item, ['sort_order' => $i + 1, 'is_published' => true])
            );
        }
    }
}
