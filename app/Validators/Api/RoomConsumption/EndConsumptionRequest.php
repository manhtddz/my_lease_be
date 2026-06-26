<?php

namespace App\Validators\Api\RoomConsumption;

use Illuminate\Foundation\Http\FormRequest;

class EndConsumptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'stop_occupied_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }
}
