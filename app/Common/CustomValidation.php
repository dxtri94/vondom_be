<?php

namespace App\Common;

use Illuminate\Validation\Validator;

class CustomValidation extends Validator
{
    public function validateMinNumber($attribute, $value, $parameters)
    {
        $value = (string)$value;
        if (strlen($value) < $parameters[0]) {
            return false;
        }

        return true;
    }

    public function validateMaxNumber($attribute, $value, $parameters)
    {
        $value = (string)$value;
        if (strlen($value) > $parameters[0]) {
            return false;
        }

        return true;
    }

    public function validateSellPrice($attribute, $value, $parameters)
    {
        $min_field = $parameters[0];
        $data = $validator->getData();
        $min_value = $data[$min_field];
        return $value > $min_value;
    }
}