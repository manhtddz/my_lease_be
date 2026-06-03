<?php

namespace App\Validators\Api\Tenant;

use App\Models\Tenant;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\IsPresentativeEnum;

class AssignTenantToRoomFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'is_representative' => ['required', Rule::in(IsPresentativeEnum::getValues())],
            'note' => ['nullable', 'string', 'max:512'],
            'electricityUnitPrice' => ['nullable', 'numeric', 'min:0'],
            'waterUnitPrice' => ['nullable', 'numeric', 'min:0'],
            'occupiedUnitPrice' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
