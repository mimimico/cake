<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peTpl_include
 *  @Project: Proto Engine 3
 */

class peTpl_include
{
    public static function plugin()
    {
        peStorage::add(peTpl_Plugins, __CLASS__, true);
    }
    
    public static $syntax = "include\s{0,5}\(\s{0,5}(\S{1,64})\s{0,5}\)";
    
    public static function syntax(&$tpl, $n)
    {
        $matches = array();
        if (preg_match(peTemplate::exp(self::$syntax), $tpl[$n], $matches)) {
            $tpl[$n] = preg_replace(
                peTemplate::exp(self::$syntax),
                peTemplate::call($matches[1]), $tpl[$n]
            );
        }
    }
    
}