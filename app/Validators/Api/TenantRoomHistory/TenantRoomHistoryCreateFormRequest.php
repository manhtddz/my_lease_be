<?php

namespace App\Validators\Api\TenantRoomHistory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantRoomHistoryCreateFormRequest extends FormRequest
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
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'move_in_date' => ['required', 'date'],
            'move_out_date' => ['nullable', 'date'],
            'is_representative' => ['required', 'boolean'],
            'room_price_snapshot' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }
}
