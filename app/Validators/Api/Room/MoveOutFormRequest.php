<?php

namespace App\Validators\Api\Room;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MoveOutFormRequest extends FormRequest
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
        ];
    }
}
