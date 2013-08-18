<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peSession
 *  @Project: Proto Engine 3
 */

class peSession 
{ 
    public static function create()
    {
        return session_start();
    }
    
    public static function set($name, $value)
    {
        return $_SESSION[$name] = $value;
    }
    
    public static function get($name)
    {
        if (isset($_SESSION[$name])) 
            return $_SESSION[$name];
        return null;
    }
    
    public static function exists($name)
    {
        return isset($_SESSION[$name]);
    }
   
    public static function remove($name)
    {
        if (@$r = self::get($name)) {
            unset($_SESSION[$name]);
            return $r;
        }
        return null;
    }
}