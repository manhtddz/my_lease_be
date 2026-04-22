<?php

namespace App\Validators\Api\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => [
                'sometimes',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'room_consumption_id' => [
                'sometimes',
                'integer',
                Rule::exists('room_consumptions', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'representative_tenant_id' => [
                'sometimes',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'electricity_amount' => ['sometimes', 'numeric'],
            'water_amount' => ['sometimes', 'numeric'],
            'room_amount' => ['sometimes', 'numeric'],
            'extra_amount' => ['nullable', 'numeric'],
            'total_amount' => ['sometimes', 'numeric'],
            'payment_status' => ['sometimes', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
