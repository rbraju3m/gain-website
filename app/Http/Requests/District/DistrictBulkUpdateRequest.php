<?php

namespace App\Http\Requests\District;

use Illuminate\Foundation\Http\FormRequest;

class DistrictBulkUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Array of district IDs the admin wants active.
            'active'   => ['nullable', 'array'],
            'active.*' => ['integer'],
        ];
    }
}
