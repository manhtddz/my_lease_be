<?php

namespace App\Validators;

use Core\Validators\BaseValidator;

class CustomValidator extends BaseValidator
{
    /**
     * Validate data for action store
     *
     * @param $params
     * @return bool
     */
    public function validateCreate($params)
    {
        return $this->_addRulesMessages()->with($params)->passes();
    }

    /**
     * Validate data for action update
     *
     * @param $params
     * @return bool
     */
    public function validateUpdate($params)
    {
        return $this->_addRulesMessages()->with($params)->passes();
    }

    /**
     * Validate detail
     *
     * @param $id
     * @return bool
     */
    public function validateShow($id)
    {
        $modelName = app($this->_model)->getModel()->getTable();
        $data = ['id' => $id];
        $rules = ['id' => 'required|integer|custom_exists:' . $modelName . ',id'];

        return $this->_addRulesMessages($rules, [], false)->with($data)->passes();
    }
}
