<?php

/*
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peLoader
 *  @Project: Proto Engine 3
 */

class peLoader
{
    public static function import($name, $engine = true)
    {
        $base = ($engine) ? pePath_Engine : pePath_Root;
        return peRequire($base . str_replace(".", ds, $name) . ".php");
    }
}