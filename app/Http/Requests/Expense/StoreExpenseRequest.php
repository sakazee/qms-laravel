<?php

namespace App\Http\Requests\Expense;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
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
