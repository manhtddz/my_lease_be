<?php

namespace App\Validators\Api\RoomConsumption;

use App\Enums\PaymentMethodEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PayRenovationFormRequest extends FormRequest
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
