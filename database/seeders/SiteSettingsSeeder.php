<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        Setting::setMany([
            // Hero
            'hero.badge'         => 'Transforming Lives Through Nutrition',
            'hero.line1'         => 'Nourishing',
            'hero.line2_prefix'  => '',
            'hero.line2_accent'  => 'Communities',
            'hero.line2_suffix'  => ',',
            'hero.line3_prefix'  => 'Building',
            'hero.line3_accent'  => 'Futures',
            'hero.subhead'       => 'Empowering communities across Bangladesh with sustainable nutrition programs, agricultural training, and community-driven solutions for lasting food security.',
            'hero.cta_primary_label' => 'Join Our Mission',
            'hero.cta_primary_url'   => '#mission',
            'hero.cta_secondary_label' => 'Learn More',
            'hero.cta_secondary_url'   => '#learn-more',
            'hero.image_path'    => null, // uploaded path, null = use fallback
            'hero.success_label' => 'Program Success Rate',
            'hero.success_value' => '98%',

            // About
            'about.tagline'  => 'About Our Organization',
            'about.line1'    => 'Building a',
            'about.line1_accent' => 'Healthier',
            'about.line2_accent' => 'Bangladesh',
            'about.line2_suffix' => 'Together',
            'about.paragraph_1' => 'Founded in 2014, we are a leading non-profit organization dedicated to transforming nutrition and food security across Bangladesh. Through innovative programmes, community partnerships, and evidence-based interventions, we empower families to achieve sustainable food security.',
            'about.paragraph_2' => 'Our holistic approach combines agricultural training, nutrition education, maternal and child health support, and policy advocacy to create lasting change at every level of society.',
            'about.image_path'  => null,
            'about.years_badge_value' => '10+',
            'about.years_badge_label' => 'Years of Impact',

            // CTA section
            'cta.heading_line1' => 'Join Us in Creating Lasting',
            'cta.heading_line2' => 'Change',
            'cta.subhead'       => 'Every contribution helps us reach more families, train more farmers, and build stronger, healthier communities across Bangladesh.',
            'cta.button_label'  => 'Become a Partner',
            'cta.button_url'    => '#partner',
            'cta.tiers'         => [
                ['amount' => '$50',  'desc' => 'Feeds a family for a month',     'tone' => 'red'],
                ['amount' => '$200', 'desc' => 'Trains a farmer',                'tone' => 'green'],
                ['amount' => '$500', 'desc' => 'Establishes a community garden', 'tone' => 'orange'],
            ],

            // Footer
            'footer.tagline' => 'Dedicated to improving nutrition and food security for families across Bangladesh through sustainable programmes and community empowerment.',
            'footer.address' => "House 12, Road 7,\nDhanmondi, Dhaka–1205, Bangladesh",
            'footer.phone'   => '+880 1 712 345 678',
            'footer.email'   => 'info@gainfoundation.org',
            'footer.social.facebook' => '#',
            'footer.social.twitter'  => '#',
            'footer.social.linkedin' => '#',
            'footer.copyright' => 'Gain Foundation Bangladesh. All rights reserved.',
        ]);
    }
}
