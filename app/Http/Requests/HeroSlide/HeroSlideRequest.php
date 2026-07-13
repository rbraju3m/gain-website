<?php

namespace App\Http\Requests\HeroSlide;

use Illuminate\Foundation\Http\FormRequest;

class HeroSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image_alt'           => ['nullable', 'string', 'max:200'],
            'badge'               => ['nullable', 'string', 'max:200'],
            'line1'               => ['nullable', 'string', 'max:200'],
            'line2_prefix'        => ['nullable', 'string', 'max:200'],
            'line2_accent'        => ['nullable', 'string', 'max:200'],
            'line2_suffix'        => ['nullable', 'string', 'max:200'],
            'line3_prefix'        => ['nullable', 'string', 'max:200'],
            'line3_accent'        => ['nullable', 'string', 'max:200'],
            'subhead'             => ['nullable', 'string', 'max:1000'],
            'cta_primary_label'   => ['nullable', 'string', 'max:120'],
            'cta_primary_url'     => ['nullable', 'string', 'max:500'],
            'cta_secondary_label' => ['nullable', 'string', 'max:120'],
            'cta_secondary_url'   => ['nullable', 'string', 'max:500'],
            'sort_order'          => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published'        => ['sometimes', 'boolean'],
            'image'               => ['nullable', 'image', 'max:5120'],
            'remove_image'        => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }
}
