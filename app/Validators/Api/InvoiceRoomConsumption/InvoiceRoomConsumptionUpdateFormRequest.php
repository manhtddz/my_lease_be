<?php

namespace App\Validators\Api\InvoiceRoomConsumption;

use App\Models\InvoiceRoomConsumption;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRoomConsumptionUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $id = $this->route('id');
        if ($id && ! $this->filled('invoice_id')) {
            $row = InvoiceRoomConsumption::query()->find($id);
            if ($row) {
                $this->merge(['invoice_id' => $row->invoice_id]);
            }
        }
    }

    public function rules(): array
    {
        $delOff = getConfig('deleted_flag.off');
        $id = $this->route('id');

        return [
            'invoice_id' => [
                'sometimes',
                'integer',
                Rule::exists('invoices', 'id')->where('del_flag', $delOff),
            ],
            'room_consumption_id' => [
                'sometimes',
                'integer',
                Rule::exists('room_consumptions', 'id')->where('del_flag', $delOff),
                Rule::unique('invoice_room_consumptions', 'room_consumption_id')
                    ->where('invoice_id', (int) $this->input('invoice_id'))
                    ->where('del_flag', $delOff)
                    ->ignore($id),
            ],
            'allocated_amount' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
