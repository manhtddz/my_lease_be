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
            'room_side_paid_id' => [
                'nullable',
                'integer',
                'required_if:item_type,' . ItemTypeEnum::ROOM_SIDE_PAID,
                Rule::exists('room_side_paids', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
        ];
    }
}
