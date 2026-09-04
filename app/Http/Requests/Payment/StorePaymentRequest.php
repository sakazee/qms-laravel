<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'partner_id'     => ['required', 'exists:partners,id'],
            'amount'         => ['required', 'numeric', 'min:0.01'],
            'payment_date'   => ['required', 'date'],
            'payment_method' => ['required', 'in:cash,bank,mobile_banking,other'],
            'reference'      => ['nullable', 'string', 'max:100'],
            'notes'          => ['nullable', 'string'],
        ];
    }
}
