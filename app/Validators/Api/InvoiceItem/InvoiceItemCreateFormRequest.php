<?php

namespace App\Validators\Api\InvoiceItem;

use App\Enums\ItemTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceItemCreateFormRequest extends FormRequest
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
            'item_type' => ['required', 'integer', Rule::in(ItemTypeEnum::getValues())],
            'item_name' => ['required', 'string', 'max:255'],
            'amount' => ['required', 'numeric'],
            'note' => ['nullable', 'string'],
            'debt_id' => [
                'nullable',
                'integer',
                'required_if:item_type,' . ItemTypeEnum::DEBT,
                Rule::exists('debts', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'renovation_id' => [
                'nullable',
                'integer',
                'required_if:item_type,' . ItemTypeEnum::RENOVATION,
                Rule::exists('renovations', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
        ];
    }
}
