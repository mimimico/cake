<?php

class peErrorController
{
    public static function indexAction()
    {
        $param = new peRequest("code:i", "back:i");
        $errors = array(
            13 => "empty fileds",
            14 => "non valid email",
            15 => "diff pass",
            16 => "acc exists",
            20 => "acc not exists, or not activated",
            21 => "already logined",
            22 => "acc not exists, or activated",
            23 => "you must be logined",
            404 => "404, page doesn't exists",
        );
        if (isset($errors[$param->code])) {
            print($errors[$param->code]);
        } else {
            print("Unknown error #" . $param->code);
        }
        die();
    }
}