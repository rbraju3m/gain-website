<?php

namespace App\Http\Requests\Partner;

use App\Models\Partner;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'         => ['required', 'string', 'max:160'],
            'group'        => ['required', Rule::in(array_keys(Partner::GROUPS))],
            'url'          => ['nullable', 'string', 'max:500'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['sometimes', 'boolean'],
            // Allow SVG via the generic 'file' rule + mimes check, since SVG isn't an "image" by Intervention/PHP's getimagesize.
            'logo'         => ['nullable', 'file', 'max:2048', 'mimes:svg,png,jpg,jpeg,webp'],
            'remove_logo'  => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
            'remove_logo'  => $this->boolean('remove_logo'),
        ]);
    }
}
