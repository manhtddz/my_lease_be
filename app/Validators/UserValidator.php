<?php

namespace App\Validators;

use App\Models\User;

class UserValidator extends CustomValidator
{
    protected $_model = User::class;

    /**
     * @param $params
     * @return bool
     */
    public function validateCreate($params)
    {
        $rules = [
            'last_name' => 'required|max:255',
            'first_name' => 'required|max:255',
            'email' => 'required|email|custom_unique:users,email',
            'password' => 'required|min:8|max:128',
            'password_confirm' => 'required|min:8|max:128|same:password',
        ];

        return $this->_addRulesMessages($rules, [], false)->with($params)->passes();
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateUpdate($params)
    {
        $rules = [
            'last_name' => 'nullable|max:255',
            'first_name' => 'nullable|max:255',
            'email' => 'required|email|custom_unique:users,email,' . $params['id'],
            'password' => 'nullable|min:8|max:128',
            'password_confirm' => 'nullable|min:8|max:128|same:password',
        ];

        return $this->_addRulesMessages($rules, [], false)->with($params)->passes();
    }
}
