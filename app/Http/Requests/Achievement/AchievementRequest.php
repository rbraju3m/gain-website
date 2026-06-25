<?php

namespace App\Http\Requests\Achievement;

use App\Models\Achievement;
use App\Support\Icons;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:120'],
            'icon_key'      => ['nullable', Rule::in(Icons::keys())],
            'rows'          => ['nullable', 'array', 'max:'.Achievement::MAX_ROWS],
            'rows.*.label'  => ['nullable', 'string', 'max:80'],
            'rows.*.value'  => ['nullable', 'string', 'max:30'],
            'rows.*.tone'   => ['nullable', Rule::in(Achievement::ROW_TONES)],
            'sort_order'    => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_published'  => ['sometimes', 'boolean'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['is_published' => $this->boolean('is_published')]);
    }
}
