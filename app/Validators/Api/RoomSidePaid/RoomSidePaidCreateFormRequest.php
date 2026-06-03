<?php

namespace App\Validators\Api\RoomSidePaid;

use App\Enums\ActiveStatusEnum;
use App\Enums\PaidByEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomSidePaidCreateFormRequest extends FormRequest
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
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'issue_date' => ['required', 'date'],
            'paid_by' => ['required', Rule::in(PaidByEnum::getValues())],
            'status' => ['required', Rule::in(ActiveStatusEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
