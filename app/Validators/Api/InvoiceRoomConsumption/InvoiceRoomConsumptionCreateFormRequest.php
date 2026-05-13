<?php

namespace App\Validators\Api\InvoiceRoomConsumption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRoomConsumptionCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $delOff = getConfig('deleted_flag.off');

        return [
            'invoice_id' => [
                'required',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', $delOff),
            ],
            'room_consumption_id' => [
                'required',
                'integer',
                Rule::exists('room_consumptions', 'id')->where('del_flag', $delOff),
                Rule::unique('invoice_room_consumptions', 'room_consumption_id')->where(
                    fn ($q) => $q->where('invoice_id', (int) $this->input('invoice_id'))->where('del_flag', $delOff)
                ),
            ],
            'allocated_amount' => ['required', 'numeric', 'min:0'],
        ];
    }
}
