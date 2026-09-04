<?php

namespace App\Http\Requests\AnimalShare;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalShareRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'animal_id'  => ['required', 'exists:animals,id'],
            'partner_id' => ['required', 'exists:partners,id'],
            'shares'     => ['required', 'integer', 'min:1', 'max:7'],
            'notes'      => ['nullable', 'string'],
        ];
    }
}
