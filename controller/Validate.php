<?php

class Validate
{
    public static function check($names, $path, $messages, $type)
    {
        self::validData($names, $path, $messages, $type);
    }

    private static function validData($names, $path, $messages, $type)
    {
        foreach ($names as $key => $name) {
            $method = 'valid'.ucfirst(strtolower($key));
            if (method_exists(__CLASS__, $method) && isset($name) && !empty($name)) {
                self::{$method}($name, $path, $messages, $type);
            }
        }
    }

    private static function validName($name, $path, $messages, $type)
    {
        if (!isValidRegex(ALPHA_NUM, $name) && isset($messages['name'])) {
            view(
                $path,
                [
                    'warning' => $messages['name'],
                    'type' => $type
                ]
            );
        }
    }

    private static function validPassword($password, $path, $messages, $type)
    {
        if (!isValidRegex(PASSWORD, $password) && isset($messages['password'])) {
            view(
                $path,
                [
                    'warning' => $messages['password'],
                    'type' => $type
                ]
            );
        }
    }

    private static function validMail($mail, $path, $messages, $type)
    {
        if (!filterData($mail, "mail") && isset($messages['email'])) {
            view(
                $path,
                [
                    'warning' => $messages['email'],
                    'type' => $type
                ]
            );
        }
    }

    private static function validBase64Image($image, $path, $messages, $type)
    {
        if (!checkBase64Format($image)){
            view(
                $path,
                [
                    'warning' => $messages['image'],
                    'type' => $type
                ]
            );
        }
    }
}
