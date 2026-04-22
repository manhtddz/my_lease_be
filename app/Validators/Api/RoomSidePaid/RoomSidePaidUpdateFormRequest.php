<?php

namespace App\Validators\Api\RoomSidePaid;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomSidePaidUpdateFormRequest extends FormRequest
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
            'tenant_id' => [
                'sometimes',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'name' => ['sometimes', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric'],
            'issue_date' => ['sometimes', 'date'],
            'paid_by' => ['sometimes', 'string', 'max:100'],
            'status' => ['sometimes', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
