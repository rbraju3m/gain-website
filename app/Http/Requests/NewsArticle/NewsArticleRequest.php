<?php

namespace App\Http\Requests\NewsArticle;

use Illuminate\Foundation\Http\FormRequest;

class NewsArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:200'],
            'category'     => ['nullable', 'string', 'max:60'],
            'excerpt'      => ['nullable', 'string', 'max:500'],
            'body'         => ['nullable', 'string', 'max:20000'],
            'published_at' => ['nullable', 'date'],
            'image'        => ['nullable', 'image', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'remove_image' => $this->boolean('remove_image'),
        ]);
    }
}
