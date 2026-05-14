<?php

namespace App\Validators\Api\Room;

use App\Enums\RoomTypeEnum;
use App\Enums\RoomStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'floor' => ['required', 'integer', 'max:10'],
            'room_type' => ['required', Rule::in(RoomTypeEnum::getValues())],
            'room_price' => ['required', 'numeric', 'decimal:0,2', 'max:99999999.99'],
            'max_occupants' => ['required', 'integer', 'min:1', 'max:10'],
        ];
    }
}
