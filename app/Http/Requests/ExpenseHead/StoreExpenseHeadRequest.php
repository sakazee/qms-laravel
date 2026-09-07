<?php

namespace App\Http\Requests\ExpenseHead;

use App\Models\ExpenseHead;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseHeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100', Rule::unique('expense_heads', 'name')->where(fn ($q) => $q->where('user_id', effective_user_id()))],
            'description' => ['nullable', 'string'],
            'color' => ['required', Rule::in(ExpenseHead::COLORS)],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('expense_heads.name')]),
            'name.unique' => __('expense_heads.name_taken'),
            'color.required' => __('validation.required', ['attribute' => __('expense_heads.color')]),
            'color.in' => __('expense_heads.color_invalid'),
        ];
    }
}
