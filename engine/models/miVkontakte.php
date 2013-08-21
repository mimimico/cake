<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miVkontakte
 *  @Project: Proto Engine 3
 */


peLoader::import("libraries.Vkontakte");

class miVkontakte 
{
    public static $__pointer;
    
    public static function get()
    {
        if (empty(self::$__pointer)) {
            self::$__pointer = new Vkontakte(array(
                'app_id'        => '3831918',
                'api_secret'    => 'oyF9iOCB7HdoT06oFsKK'
            ));
        }
        return self::$__pointer;
    }
    
    public function __call($name, $args)
    {
        return call_user_func_array(array(self::get(), $name), $args);
    }
}
