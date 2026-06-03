<?php

namespace App\Validators\Api\Debt;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
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
            'penalty_amount' => ['nullable', 'numeric'],
            'debt_type' => ['sometimes', 'integer', Rule::in(DebtTypeEnum::getValues())],
            'due_date' => ['sometimes', 'date'],
            'status' => ['sometimes', Rule::in(ActiveStatusEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
