<?php

namespace App\Validators;

use App\Models\PasswordReset;

class PasswordResetValidator extends CustomValidator
{
    protected $_model = PasswordReset::class;

    /**
     * @param $params
     * @return bool
     */
    public function validateCreate($params)
    {
        $rules = [
            'email' => 'required',
            'token' => 'required',
            'expired_time' => 'required',
        ];

        return $this->_addRulesMessages($rules, [], false)->with($params)->passes();
    }
}
