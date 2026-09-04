<?php

namespace App\Http\Requests\AnimalShare;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalShareRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'shares' => ['required', 'integer', 'min:1', 'max:7'],
            'notes'  => ['nullable', 'string'],
        ];
    }
}
