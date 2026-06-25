<?php

namespace App\Http\Requests\Division;

use Illuminate\Foundation\Http\FormRequest;

class DivisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'families'     => ['nullable', 'string', 'max:30'],
            'programmes'   => ['nullable', 'integer', 'min:0', 'max:9999'],
            'success_rate' => ['nullable', 'string', 'max:10'],
            'sort_order'   => ['nullable', 'integer', 'min:0', 'max:99'],
        ];
    }
}
