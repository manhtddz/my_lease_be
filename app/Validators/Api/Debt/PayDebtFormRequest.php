<?php

namespace App\Validators\Api\Debt;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
use App\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayDebtFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'payment_amount' => ['required', 'numeric'],
            'payment_method' => ['required', Rule::in(PaymentMethodEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
