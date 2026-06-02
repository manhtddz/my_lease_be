<?php

namespace App\Validators\Api\TenantRoomHistory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TransferToRoomFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenantIds' => ['required', 'array', 'min:1'],
            'tenantIds.*' => [
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'electricityUnitPrice' => ['nullable', 'numeric', 'min:0'],
            'waterUnitPrice' => ['nullable', 'numeric', 'min:0'],
            'occupiedUnitPrice' => ['nullable', 'numeric', 'min:0'],
            'note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
