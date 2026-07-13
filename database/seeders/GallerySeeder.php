<?php

namespace Database\Seeders;

use App\Models\GalleryImage;
use App\Models\GalleryYear;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'year'        => 2024,
                'title'       => 'Community Kitchens Launch',
                'description' => 'A year focused on kitchen infrastructure and nutrition training in rural households.',
                'images'      => [
                    ['title' => 'Village kitchen workshop',    'description' => 'Hands-on cooking training in a rural community centre.',                'url' => 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?w=1200&q=80'],
                    ['title' => 'Fresh harvest, shared meal', 'description' => 'Families share the first meal from their new nutrition garden.',      'url' => 'https://images.unsplash.com/photo-1543353071-10c8ba85a904?w=1200&q=80'],
                    ['title' => 'Learning through cooking',   'description' => 'Children participate in age-appropriate nutrition activities.',       'url' => 'https://images.unsplash.com/photo-1466637574441-749b8f19452f?w=1200&q=80'],
                    ['title' => 'The kitchen team',           'description' => 'Community volunteers who run the daily kitchen operations.',          'url' => 'https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=1200&q=80'],
                ],
            ],
            [
                'year'        => 2025,
                'title'       => 'Farmer Field Days',
                'description' => 'Expanding livelihood support with training, seeds and market access across new districts.',
                'images'      => [
                    ['title' => 'Field-day demonstration',    'description' => 'Smallholder farmers learning climate-smart techniques.',              'url' => 'https://images.unsplash.com/photo-1500076656116-558758c991c1?w=1200&q=80'],
                    ['title' => 'A better harvest',           'description' => 'Improved seed varieties translated to record yields.',                'url' => 'https://images.unsplash.com/photo-1523348837708-15d4a09cfac2?w=1200&q=80'],
                    ['title' => 'Marketplace day',            'description' => 'Farmers bring produce to the local weekly market.',                   'url' => 'https://images.unsplash.com/photo-1488459716781-31db52582fe9?w=1200&q=80'],
                    ['title' => 'Training the trainers',      'description' => 'Local extension officers gathered for the annual refresher.',        'url' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=1200&q=80'],
                    ['title' => 'Water-wise irrigation',      'description' => 'New drip-line systems reduced water use by nearly half.',            'url' => 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=1200&q=80'],
                ],
            ],
            [
                'year'        => 2026,
                'title'       => 'Maternal & Child Outreach',
                'description' => 'This year opened community-based nutrition clinics in every division we work in.',
                'images'      => [
                    ['title' => 'Clinic day, Dhaka division', 'description' => 'A young mother and her child at the monthly nutrition check-up.',   'url' => 'https://images.unsplash.com/photo-1519638399535-1b036603ac77?w=1200&q=80'],
                    ['title' => 'School nutrition class',     'description' => 'Students learn about balanced plates and healthy eating.',          'url' => 'https://images.unsplash.com/photo-1497486751825-1233686d5d80?w=1200&q=80'],
                    ['title' => 'Home visit, Sylhet',         'description' => 'Follow-up visit with a family after our clinic outreach.',         'url' => 'https://images.unsplash.com/photo-1509099836639-18ba1795216d?w=1200&q=80'],
                    ['title' => 'Local staff huddle',         'description' => 'The regional field team plans the next month of visits.',          'url' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200&q=80'],
                ],
            ],
        ];

        foreach ($data as $yi => $group) {
            $year = GalleryYear::updateOrCreate(
                ['year' => $group['year']],
                [
                    'title'        => $group['title'],
                    'description'  => $group['description'],
                    'sort_order'   => $yi + 1,
                    'is_published' => true,
                ],
            );

            foreach ($group['images'] as $ii => $img) {
                $existing = $year->images()->where('title', $img['title'])->first();
                if ($existing) {
                    $existing->update([
                        'description'  => $img['description'],
                        'sort_order'   => $ii + 1,
                        'is_published' => true,
                    ]);
                    if ($existing->getFirstMedia('image')) {
                        continue; // media already attached — skip re-download
                    }
                    $image = $existing;
                } else {
                    $image = $year->images()->create([
                        'title'        => $img['title'],
                        'description'  => $img['description'],
                        'sort_order'   => $ii + 1,
                        'is_published' => true,
                    ]);
                }

                try {
                    $image->addMediaFromUrl($img['url'])->toMediaCollection('image');
                } catch (\Throwable $e) {
                    $this->command?->warn("Skipped image “{$img['title']}”: {$e->getMessage()}");
                }
            }
        }
    }
}
