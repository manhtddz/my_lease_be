<?php

namespace App\Validators\Api\InvoiceItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceItemUpdateFormRequest extends FormRequest
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
            'item_type' => ['sometimes', 'integer', Rule::in([1, 2, 3, 4, 5])],
            'item_name' => ['sometimes', 'string', 'max:255'],
            'amount' => ['sometimes', 'numeric'],
            'note' => ['nullable', 'string'],
            'debt_id' => [
                'nullable',
                'integer',
                Rule::exists('debts', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'room_side_paid_id' => [
                'nullable',
                'integer',
                Rule::exists('room_side_paids', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
        ];
    }
}
