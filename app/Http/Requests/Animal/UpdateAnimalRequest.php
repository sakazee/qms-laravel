<?php

namespace App\Http\Requests\Animal;

use App\Models\Animal;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'type'           => ['required', 'in:cow,buffalo,camel,goat,sheep,other'],
            'name'           => ['nullable', 'string', 'max:255'],
            'total_shares'   => ['required', 'integer', 'min:1', 'max:7'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'status'         => ['required', 'in:pending,purchased,slaughtered'],
            'notes'          => ['nullable', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $type   = $this->input('type');
            $shares = $this->input('total_shares');

            if ($type && $shares) {
                $isSmall = in_array($type, Animal::SMALL_ANIMALS);
                if ($isSmall && $shares > Animal::MAX_SHARES_SMALL) {
                    $validator->errors()->add('total_shares', __('animals.small_animal_max_one_share'));
                }
            }
        });
    }
}
