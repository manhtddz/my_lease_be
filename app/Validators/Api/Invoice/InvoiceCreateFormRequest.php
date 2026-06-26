<?php

namespace App\Validators\Api\Invoice;

use App\Enums\PaymentStatusEnum;
use App\Models\InvoiceItem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_consumption_ids' => ['required', 'array', 'min:1'],
            'room_consumption_ids.*' => [
                'required',
                'integer',
                Rule::exists('room_consumptions', 'id')->where('del_flag', getConfig('deleted_flag.off')),
                function ($attribute, $value, $fail) {
                    $alreadyInvoiced = InvoiceItem::where('room_consumption_id', $value)
                        ->where('del_flag', getConfig('deleted_flag.off'))
                        ->exists();

                    if ($alreadyInvoiced) {
                        $fail(__('messages.consumption_already_invoiced'));
                    }
                },
            ],
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'representative_tenant_id' => [
                'required',
                'integer',
                Rule::exists('tenants', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'payment_status' => ['required', Rule::in(PaymentStatusEnum::getValues())],
            'note' => ['nullable', 'string'],
        ];
    }
}
