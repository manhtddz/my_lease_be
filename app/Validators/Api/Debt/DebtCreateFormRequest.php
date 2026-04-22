<?php

namespace App\Validators\Api\Debt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DebtCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_id' => [
                'required',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'original_amount' => ['required', 'numeric'],
            'paid_amount' => ['nullable', 'numeric'],
            'remaining_amount' => ['required', 'numeric'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ];
    }
}
