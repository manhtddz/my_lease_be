<?php

namespace App\Validators\Api\Payment;

use App\Enums\ActiveStatusEnum;
use App\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => [
                'sometimes',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'tenant_id' => [
                'sometimes',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'payment_amount' => ['sometimes', 'numeric'],
            'payment_date' => ['sometimes', 'date'],
            'payment_method' => ['sometimes', Rule::in(PaymentMethodEnum::getValues())],
            'status' => ['sometimes', Rule::in(ActiveStatusEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
