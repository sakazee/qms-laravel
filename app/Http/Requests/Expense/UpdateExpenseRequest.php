<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'expense_head_id'   => ['required', 'nullable', Rule::exists('expense_heads', 'id')->where('user_id', auth()->id())],
            'title'             => ['required', 'string', 'max:255'],
            'amount'            => ['required', 'numeric', 'min:0.01'],
            'distribution_type' => ['required', 'in:flat,custom_percent,purchase_percent'],
            'description'       => ['nullable', 'string'],
            'expense_date'      => ['required', 'date'],
            'distributions'     => ['nullable', 'array'],
            'distributions.*'   => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }
}
