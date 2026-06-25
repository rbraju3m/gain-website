<?php

namespace App\Http\Requests\MvvCard;

use App\Models\MvvCard;
use App\Support\Icons;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MvvCardRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'        => ['required', 'string', 'max:80'],
            'body'         => ['nullable', 'string', 'max:1000'],
            'tone'         => ['required', Rule::in(MvvCard::TONES)],
            'icon_key'     => ['nullable', Rule::in(Icons::keys())],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published' => ['sometimes', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_published' => $this->boolean('is_published')]);
    }
}
