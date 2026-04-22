<?php

namespace App\Validators\Api\Invoice;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'room_consumption_id' => [
                'required',
                'integer',
                Rule::exists('room_consumptions', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'representative_tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'electricity_amount' => ['required', 'numeric'],
            'water_amount' => ['required', 'numeric'],
            'room_amount' => ['required', 'numeric'],
            'extra_amount' => ['nullable', 'numeric'],
            'total_amount' => ['required', 'numeric'],
            'payment_status' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
