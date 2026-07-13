<?php

namespace App\Http\Requests\GalleryImage;

use Illuminate\Foundation\Http\FormRequest;

class GalleryImageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'gallery_year_id' => ['required', 'integer', 'exists:gallery_years,id'],
            'title'           => ['required', 'string', 'max:200'],
            'description'     => ['nullable', 'string', 'max:2000'],
            'sort_order'      => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published'    => ['sometimes', 'boolean'],
            'image'           => [$this->route('gallery_image') ? 'nullable' : 'required', 'image', 'max:5120'],
            'remove_image'    => ['nullable', 'boolean'],
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
