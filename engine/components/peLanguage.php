<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peLanguage
 *  @Project: Proto Engine 3
 */

abstract class peLanguage
{
    public static $data;
    
    public static function load()
    {
        self::$data = array();
        foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $lang) {
            $pattern = '/^(?P<primarytag>[a-zA-Z]{2,8})'.
            '(?:-(?P<subtag>[a-zA-Z]{2,8}))?(?:(?:;q=)'.
            '(?P<quantifier>\d\.\d))?$/';

            $splits = array();

            if (preg_match($pattern, $lang, $splits)) {
                self::$data = peLoader::import("lang." . $splits["primarytag"], false);
                if (!empty(self::$data)) {
                    return;
                }
            }
        }
        self::$data = peLoader::import("lang." . peProject::getLanguage(), false);
    }
    
    public static function get($name)
    {
        return isset(self::$data[$name]) ? self::$data[$name] : $name;
    }
}