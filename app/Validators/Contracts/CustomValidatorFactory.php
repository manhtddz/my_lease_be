<?php

namespace App\Validators\Contracts;


use Illuminate\Validation\Factory;

class CustomValidatorFactory extends Factory
{
    protected function resolve(
        array $data,
        array $rules,
        array $messages,
        array $customAttributes
    ) {
        return new CustomValidatorContract(
            $this->translator,
            $data,
            $rules,
            $messages,
            $customAttributes
        );
    }
}
