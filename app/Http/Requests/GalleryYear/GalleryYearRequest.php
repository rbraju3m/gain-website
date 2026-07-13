<?php

namespace App\Http\Requests\GalleryYear;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryYearRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('gallery_year')?->id;

        return [
            'year'         => ['required', 'integer', 'min:1900', 'max:2100', Rule::unique('gallery_years', 'year')->ignore($id)],
            'title'        => ['nullable', 'string', 'max:200'],
            'description'  => ['nullable', 'string', 'max:2000'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_published' => $this->boolean('is_published'),
        ]);
    }
}
