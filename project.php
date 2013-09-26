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
        "title"     => " | Mimimi.co",
        "host"      => "http://inlife.no-ip.org/proto/",
        "siteTheme" => "mimimi",
        "tplDirs"   => array("css", "slider", "script", "js", "images", "splash"),
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

peHook::addHook("onGetData", function($args) {
    if (miUser::logined()) {
        $args[0]->cuser = miUser::getLocal();
    } else {
        $args[0]->cuser->logined = false;
    }
});

peHook::addHook("onRequest", function($args) {
    $actions = array("index", "info", "login");
    if (!miUser::logined()) {
        if (($args[0]->name != "main" || !in_array($args[0]->action, $actions)) && !$args[0]->async) {
            peHttp::redirect(peHttp::url(
                array("name" => "main", "action" => "index")
            ));
        }
    }
});