<?php

namespace App\Validators\Api\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => [
                'required',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'payment_amount' => ['required', 'numeric'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', 'string', 'max:50'],
            'payment_status' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
