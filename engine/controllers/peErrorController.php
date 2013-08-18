<?php

class peErrorController
{
    public static function indexAction()
    {
        $param = new peRequest("code:i", "back:i");
        pre($param); die();
    }
}