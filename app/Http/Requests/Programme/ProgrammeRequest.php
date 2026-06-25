<?php

namespace App\Http\Requests\Programme;

use Illuminate\Foundation\Http\FormRequest;

class ProgrammeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:160'],
            'category'     => ['nullable', 'string', 'max:60'],
            'body'         => ['nullable', 'string', 'max:2000'],
            'url'          => ['nullable', 'string', 'max:500'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['sometimes', 'boolean'],
            'image'        => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
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
