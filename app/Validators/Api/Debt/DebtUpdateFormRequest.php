<?php

namespace App\Validators\Api\Debt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DebtUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => [
                'sometimes',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'tenant_id' => [
                'sometimes',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'original_amount' => ['sometimes', 'numeric'],
            'paid_amount' => ['nullable', 'numeric'],
            'remaining_amount' => ['sometimes', 'numeric'],
            'due_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
