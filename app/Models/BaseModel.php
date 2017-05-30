<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class BaseModel extends Model
{
    /**
     * fn validate params
     */
    public static function validate($data = array(), $action = '', $messages = array(), $merge = array(), $params = array())
    {

        $rules = self::getRules(static::$rules[$action], $merge, $params);
        $validator = Validator::make($data, $rules, $messages);
        return self::getErrors($validator);
    }

    /**
     * fn get rules
     * @param $rules
     * @param array $merge
     * @param array $params
     * @return mixed
     */
    private static function getRules($rules, $merge = array(), $params = array())
    {
        if (!empty($params)) {
            foreach ($rules as $key => $rule) {
                foreach ($params as $keyParam => $param) {
                    $rules[$key] = str_replace($keyParam, $param, $rule);
                }
            }
        }

        return array_merge($rules, $merge);
    }

    /**
     * fn get Error
     * @param $validator
     * @return array
     */
    private static function getErrors($validator)
    {
        $errors = Lang::get('errorCodes');

        $errorList = array();
        foreach ($validator->errors()->all() as $error) {
            $message = $errors[$errors['ApiErrorCodesFlip'][$error]];
            $errorList[] = array($message, $error);
        }

        return $errorList;
    }

    /**
     * fn check landscape | portrait of image
     * @param $file
     * @return bool|string
     */
    protected function checkSizeImage($file)
    {
        if (File::exists(base_path($file))) {
            $width = getimagesize(base_path($file))[0];
            $height = getimagesize(base_path($file))[1];

            if ($width > $height) {
                return 'landscape';
            }

            return 'portrait';
        }

        return null;
    }
}