<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: project
 *  @Project: Proto Engine 3
 */

require("core.php");

peCore::init(
    array(
        /* Basic project settings */
        "title"     => " | Proto Engine",
        "host"      => "http://localhost/",
        "siteTheme" => "mimimi",
        "tplDirs"   => array("style", "css", "slider", "script", "js", "images"),
        "debug"     => true,
        "hashSalt"  => "qw123",
        "charset"   => "utf-8",
        
        /* Mysql settings */
        "mysqlHost" => "localhost",
        "mysqlUser" => "root",
        "mysqlPass" => "database_password", //CHANGEME!
        "mysqlName" => "mimimi",
        
        /* Components */
        "components" => array(
            "components.peStorage",
            "components.peHttp",
            "components.peFile",
            "components.peImage",
            "components.peModel",
            "components.peQuery",
            "components.peResponse"
        )
    )
);

/* Language section */
peStorage::add("lang-en", array(
    "button_buy" => "Buy",
    "button_sell" => "Sell",
    
    "category_jewerly" => "Jewels",
    "category_eggs" => "Eggs :)"
));

peStorage::add("lang-ru", array(
    "button_buy" => "Купить",
    "button_sell" => "Продать"
));