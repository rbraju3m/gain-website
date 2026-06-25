<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route is already protected by auth + role:admin middleware.
        return true;
    }

    public function rules(): array
    {
        return [
            // Hero
            'hero.badge'              => ['nullable', 'string', 'max:120'],
            'hero.line1'              => ['nullable', 'string', 'max:80'],
            'hero.line2_prefix'       => ['nullable', 'string', 'max:80'],
            'hero.line2_accent'       => ['nullable', 'string', 'max:80'],
            'hero.line2_suffix'       => ['nullable', 'string', 'max:80'],
            'hero.line3_prefix'       => ['nullable', 'string', 'max:80'],
            'hero.line3_accent'       => ['nullable', 'string', 'max:80'],
            'hero.subhead'            => ['nullable', 'string', 'max:1000'],
            'hero.cta_primary_label'  => ['nullable', 'string', 'max:50'],
            'hero.cta_primary_url'    => ['nullable', 'string', 'max:500'],
            'hero.cta_secondary_label'=> ['nullable', 'string', 'max:50'],
            'hero.cta_secondary_url'  => ['nullable', 'string', 'max:500'],
            'hero.success_label'      => ['nullable', 'string', 'max:80'],
            'hero.success_value'      => ['nullable', 'string', 'max:20'],
            'hero_image'              => ['nullable', 'image', 'max:5120'],

            // About
            'about.tagline'           => ['nullable', 'string', 'max:120'],
            'about.line1'             => ['nullable', 'string', 'max:80'],
            'about.line1_accent'      => ['nullable', 'string', 'max:80'],
            'about.line2_accent'      => ['nullable', 'string', 'max:80'],
            'about.line2_suffix'      => ['nullable', 'string', 'max:80'],
            'about.paragraph_1'       => ['nullable', 'string', 'max:2000'],
            'about.paragraph_2'       => ['nullable', 'string', 'max:2000'],
            'about.years_badge_value' => ['nullable', 'string', 'max:20'],
            'about.years_badge_label' => ['nullable', 'string', 'max:80'],
            'about_image'             => ['nullable', 'image', 'max:5120'],

            // CTA
            'cta.heading_line1'  => ['nullable', 'string', 'max:120'],
            'cta.heading_line2'  => ['nullable', 'string', 'max:120'],
            'cta.subhead'        => ['nullable', 'string', 'max:1000'],
            'cta.button_label'   => ['nullable', 'string', 'max:50'],
            'cta.button_url'     => ['nullable', 'string', 'max:500'],
            'cta.tiers'          => ['nullable', 'array', 'size:3'],
            'cta.tiers.*.amount' => ['nullable', 'string', 'max:20'],
            'cta.tiers.*.desc'   => ['nullable', 'string', 'max:200'],
            'cta.tiers.*.tone'   => ['nullable', 'in:red,green,orange'],

            // Footer
            'footer.tagline'         => ['nullable', 'string', 'max:500'],
            'footer.address'         => ['nullable', 'string', 'max:300'],
            'footer.phone'           => ['nullable', 'string', 'max:60'],
            'footer.email'           => ['nullable', 'email', 'max:120'],
            'footer.social.facebook' => ['nullable', 'string', 'max:500'],
            'footer.social.twitter'  => ['nullable', 'string', 'max:500'],
            'footer.social.linkedin' => ['nullable', 'string', 'max:500'],
            'footer.copyright'       => ['nullable', 'string', 'max:200'],
        ];
    }
}
