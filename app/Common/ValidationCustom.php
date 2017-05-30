<?php namespace App\Common;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Lang;


class ValidationCustom
{

    public static function getErrors($validator)
    {
        $errorCode = Lang::get('apiErrorCode');
        $errorList = array();
        foreach ($validator->errors()->all() as $error) {
            $message = $errorCode[$errorCode['ApiErrorCodesFlip'][$error]];
            $errorList[] = array($message, $error);
        }
        return $errorList;
    }


    /**
     * @desc get rule
     *
     * @param array $rules
     * @param string $action
     * @param array $merge
     * @param array $params
     *
     * @return array
     * */
    public static function getRules($rules, $action, $merge = [], $params = [])
    {
        $rules = $rules[$action];
        if (!empty($params)) {
            foreach ($rules as $key => $rule) {
                foreach ($params as $keyParam => $valueParam) {
                    $rules[$key] = str_replace($keyParam, $valueParam, $rules[$key]);
                }
            }
        }

        return array_merge($rules, $merge);
    }
}