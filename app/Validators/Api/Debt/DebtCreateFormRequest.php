<?php

namespace App\Validators\Api\Debt;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
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
            'penalty_amount' => ['nullable', 'numeric'],
            'debt_type' => ['required', 'integer', Rule::in(DebtTypeEnum::getValues())],
            'due_date' => ['required', 'date'],
            'status' => ['required', Rule::in(ActiveStatusEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
