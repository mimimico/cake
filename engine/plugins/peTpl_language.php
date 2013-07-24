<?php

/*
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peTpl_url
 *  @Project: Proto Engine 3
 */

class peTpl_language
{
    public static function plugin()
    {
        peStorage::add(peTpl_Plugins, __CLASS__, true);
    }
    
    public static $syntax = "l\(\s{0,5}(\S{1,64})\s{0,5}\)";
    
    public static function syntax(&$tpl, $n, &$data)
    {
        $matches = array();
        if (preg_match(peTemplate::exp(self::$syntax), $tpl[$n], $matches)) {
            if (!strpos($matches[0], peTpl_NoCacheSym)) {
                $string = peLanguage::get(trim($matches[1]));

                $tpl[$n] = preg_replace(
                    peTemplate::exp(str_replace("(\S{1,64})", $matches[1], self::$syntax)),
                    $string, $tpl[$n]
                );
            }
        }
    }
}