<?php
namespace App\Validators\Api\User;

use App\Enums\UserRoleEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserCreateFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')
                    ->where(fn ($q) => $q->where('del_flag', getConfig('deleted_flag.off')))
            ],
            'password' => ['required', 'string'],
            'manager_id' => ['nullable'],
            'department_id' => ['nullable'],
            'role' => ['required', Rule::in(UserRoleEnum::getValues())],
        ];
    }

    public function attributes(): array
    {
        return __('models.users.attributes');
    }
}
