<?php

namespace App\Validators;

use App\Models\Account;

class AccountValidator extends CustomValidator
{
    protected $_model = Account::class;

    /**
     * @param $params
     * @return bool
     */
    public function validateForgotPassword($params)
    {
        $modelName = app($this->_model)->getModel()->getTable();

        $rule = [
            'email' => 'required|email|custom_exists:' . $modelName . ',email'
        ];

        return $this->_addRulesMessages($rule, [], false)->with($params)->passes();
    }

    public function validateResetPassword($params)
    {
        $rule = [
            'password' => 'required|min:8|max:128',
            'password_confirm' => 'required|min:8|max:128|same:password',
        ];

        return $this->_addRulesMessages($rule, [], false)->with($params)->passes();
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateLogin($params)
    {
        $rules = [
            'email' => 'required|check_email',
            'password' => 'required'
        ];

        $messages = [
            'email.check_email' => trans('validation.email_format'),
            'email.required' => trans('auth.email_required'),
            'password.required' => trans('auth.password_required'),
        ];

        return $this->_addRulesMessages($rules, $messages, false)->with($params)->passes();
    }

    /**
     * @param $params
     * @return bool
     */
    public function validateTwoFactor($params)
    {
        $rules = [
            'auth_code' => 'required'
        ];

        $messages = [
            'auth_code.required' => trans('auth.auth_code_required'),
        ];
        return $this->_addRulesMessages($rules, $messages, false)->with($params)->passes();
    }
}
