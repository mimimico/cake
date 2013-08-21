<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miFacebook
 *  @Project: Proto Engine 3
 */


peLoader::import("libraries.facebook");

class miFacebook 
{
    public static $__pointer;
    
    public static function get()
    {
        if (empty(self::$__pointer)) {
            self::$__pointer = new Facebook(array(
                'appId'  => '456012071164641',
                'secret' => '23ece1bae55c769fac97e08ec7954f65',
            ));
        }
        return self::$__pointer;
    }
    
    public function __call($name, $args)
    {
        return call_user_func_array(array(self::get(), $name), $args);
    }
}
