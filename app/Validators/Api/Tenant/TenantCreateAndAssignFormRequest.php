<?php

namespace App\Validators\Api\Tenant;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantCreateAndAssignFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30', Rule::unique(Tenant::getTableName(), 'phone_number')
                ->where('del_flag', getConfig('deleted_flag.off'))],
            'id_card_number' => ['required', 'string', 'max:30', Rule::unique(Tenant::getTableName(), 'id_card_number')
                ->where('del_flag', getConfig('deleted_flag.off'))],
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'note' => ['required', 'string', 'max:512'],
        ];
    }
}
