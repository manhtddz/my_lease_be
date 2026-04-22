<?php

namespace App\Validators\Api\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class TenantUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'phone_number' => ['sometimes', 'string', 'max:30'],
            'id_card_number' => ['sometimes', 'string', 'max:30'],
        ];
    }
}
