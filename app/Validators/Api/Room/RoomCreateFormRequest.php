<?php

namespace App\Validators\Api\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number' => ['required', 'string', 'max:50'],
            'floor' => ['nullable', 'string', 'max:50'],
            'room_type' => ['nullable', 'string', 'max:50'],
            'room_price' => ['required', 'numeric'],
            'max_occupants' => ['nullable', 'integer', 'min:1'],
            'status' => ['required', 'string', 'max:50'],
        ];
    }
}
