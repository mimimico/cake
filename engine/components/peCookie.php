<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peCookie
 *  @Project: Proto Engine 3
 */

class peCookie
{ 
    public static function set($name, $value, $exp = peCookie_Expire)
    {
        return setcookie($name, $value, $exp);
    }
    
    public static function get($name = NULL)
    {
        if (empty($name)) return $_COOKIE;
        if (isset($_COOKIE[$name])) 
            return $_COOKIE[$name];
        return null;
    }
    
    public static function exists($name)
    {
        return isset($_COOKIE[$name]);
    }
   
    public static function remove($name)
    {
        if (@$r = self::get($name)) {
            self::set($name, null, time() - 3600);
            return $r;
        }
        return null;
    }
}