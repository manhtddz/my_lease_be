<?php

namespace App\Validators\Api\RoomConsumption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomConsumptionCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => [
                'required',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'billing_year' => ['required', 'integer'],
            'billing_month' => ['required', 'integer', 'between:1,12'],
            'electricity_old' => ['required', 'numeric'],
            'electricity_new' => ['required', 'numeric'],
            'electricity_unit_price' => ['required', 'numeric'],
            'water_old' => ['required', 'numeric'],
            'water_new' => ['required', 'numeric'],
            'water_unit_price' => ['required', 'numeric'],
            'start_occupied_date' => ['nullable', 'date'],
            'stop_occupied_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
        ];
    }
}
