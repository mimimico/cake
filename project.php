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
        "host"      => "http://inlife.no-ip.org/proto/",
        "siteTheme" => "mimimi",
        "tplDirs"   => array("css", "slider", "script", "js", "images"),
        "debug"     => true,
        "hashSalt"  => "qw123",
        "charset"   => "utf-8",
        "language"  => "en", // default language
        
        /* Mysql settings */
        "mysqlHost" => "localhost",
        "mysqlUser" => "root",
        "mysqlPass" => "usbw",
        "mysqlName" => "mimimi",
        
        /* Components */
        "components" => array(
            "components.peStorage",
            "components.peHttp",
            "components.peFile",
            "components.peImage",
            "components.peModel",
            "components.peQuery",
            "components.peLanguage",
            "components.peSession",
            "components.peCookie",
            "components.peTime",
            "components.peResponse",
            "models.miUser"
        )
    )
);
