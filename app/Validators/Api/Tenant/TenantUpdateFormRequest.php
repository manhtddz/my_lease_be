<?php

namespace App\Validators\Api\Tenant;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TenantUpdateFormRequest extends FormRequest
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
                ->where('del_flag', getConfig('deleted_flag.off'))
                ->ignore($this->route('id'), 'id'),],
            'id_card_number' => ['required', 'string', 'max:30', Rule::unique(Tenant::getTableName(), 'id_card_number')
                ->where('del_flag', getConfig('deleted_flag.off'))
                ->ignore($this->route('id'), 'id'),],
        ];
    }
}
