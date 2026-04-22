<?php

namespace App\Validators\Api\TenantRoomHistory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantRoomHistoryUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tenant_id' => [
                'sometimes',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'room_id' => [
                'sometimes',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'move_in_date' => ['sometimes', 'date'],
            'move_out_date' => ['nullable', 'date'],
            'is_representative' => ['sometimes', 'boolean'],
            'room_price_snapshot' => ['nullable', 'numeric'],
            'note' => ['nullable', 'string'],
        ];
    }
}
