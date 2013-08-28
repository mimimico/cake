<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peShopController
 *  @Project: Proto Engine 3
 */

class peShopController extends peController
{
    public static function indexAction()
    {
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $request = new peRequest("id:i");
        $response = new peResponse("shop");
        
        $response->page->title = "Shop" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage");
        $response->page->categories = $categories->bind("displayCategories");
        //$response->user = miUser::getLocal();
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
        
        return $response;
    }
}