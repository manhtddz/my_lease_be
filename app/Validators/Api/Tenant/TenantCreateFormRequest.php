<?php

namespace App\Validators\Api\Tenant;

use Illuminate\Foundation\Http\FormRequest;

class TenantCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:30'],
            'id_card_number' => ['required', 'string', 'max:30'],
        ];
    }
}
