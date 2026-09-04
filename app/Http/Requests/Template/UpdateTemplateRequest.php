<?php

namespace App\Http\Requests\Template;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTemplateRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'year'        => ['required', 'string', 'max:10'],
            'description' => ['nullable', 'string'],
            'status'      => ['required', 'in:active,inactive'],
        ];
    }
}
