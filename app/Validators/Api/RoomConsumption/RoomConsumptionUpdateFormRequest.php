<?php

namespace App\Validators\Api\RoomConsumption;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomConsumptionUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => [
                'sometimes',
                'integer',
                Rule::exists('rooms', 'id')->where('del_flag', getConfig('deleted_flag.off')),
            ],
            'billing_year' => ['sometimes', 'integer'],
            'billing_month' => ['sometimes', 'integer', 'between:1,12'],
            'electricity_old' => ['sometimes', 'numeric'],
            'electricity_new' => ['sometimes', 'numeric'],
            'electricity_unit_price' => ['sometimes', 'numeric'],
            'water_old' => ['sometimes', 'numeric'],
            'water_new' => ['sometimes', 'numeric'],
            'water_unit_price' => ['sometimes', 'numeric'],
            'start_occupied_date' => ['nullable', 'date'],
            'stop_occupied_date' => ['nullable', 'date'],
            'note' => ['nullable', 'string'],
        ];
    }
}
