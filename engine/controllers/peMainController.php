<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peMainController
 *  @Project: Proto Engine 3
 */

class peMainController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miItem");
        peLoader::import("models.miCategory");
        
        /* Generating response*/
        $c = new miCategory();
        $items = new miItem();
        $items->categories = $c->loadAll();
        $response = new peResponse("index", true);
        $response->page->title = "Главная" . peProject::getTitle();
        $response->page->items = $items->call("loadAll");
        
        $response->lang = (object)peStorage::get("lang-en");
        return $response;
    }
}