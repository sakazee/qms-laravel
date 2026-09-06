<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'expense_head_id'            => ['required', 'nullable', Rule::exists('expense_heads', 'id')->where('user_id', auth()->id())],
            'title'                      => ['required', 'string', 'max:255'],
            'amount'                     => ['required', 'numeric', 'min:0.01'],
            'split_type'                 => ['nullable', Rule::in(['equal', 'purchase', 'manual'])],
            'description'                => ['nullable', 'string'],
            'expense_date'               => ['required', 'date'],
            'animal_ids'                 => ['nullable', 'array'],
            'animal_ids.*'               => ['integer'],
            'distributions'              => ['nullable', 'array'],
            'distributions.*.percent'    => ['nullable', 'numeric', 'min:0'],
            'distributions.*.amount'     => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
