<?php

namespace src\Validation;
/*
this  Validate username and password that we recive from register inputs
*/
class Validator
{
    protected $errors = [];

    public function validate($username, $password)
    {
        if (!$this->check_username($username)) {
            $this->errors['username'] = "Username is not valid and should be at least 3 charactor";
        }

        if (!$this->check_password($password)) {
            $this->errors['password'] = "Password is not valid and should be at least 6 charactor";
        }

        return $this->errors;
    }

    public static function check_username($value, $min = 3, $max = 255){
        
        $value = trim($value);

        return strlen($value) >= $min && strlen($value) <= $max;
    }

    public static function check_password($value, $min = 6, $max = 255) {
        $value = trim($value);


        return strlen($value) >= $min && strlen($value) <= $max;
    }
}