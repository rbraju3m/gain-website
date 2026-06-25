<?php

namespace App\Http\Requests\ImpactStat;

use App\Models\ImpactStat;
use App\Support\Icons;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ImpactStatRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'label'        => ['required', 'string', 'max:80'],
            'counter'      => ['required', 'integer', 'min:0', 'max:9999999'],
            'suffix'       => ['nullable', 'string', 'max:10'],
            'tone'         => ['required', Rule::in(ImpactStat::TONES)],
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
