<?php

namespace App\Validators\Api\Room;

use Illuminate\Foundation\Http\FormRequest;

class RoomUpdateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_number' => ['sometimes', 'string', 'max:50'],
            'floor' => ['nullable', 'string', 'max:50'],
            'room_type' => ['nullable', 'string', 'max:50'],
            'room_price' => ['sometimes', 'numeric'],
            'max_occupants' => ['nullable', 'integer', 'min:1'],
            'status' => ['sometimes', 'string', 'max:50'],
        ];
    }
}
