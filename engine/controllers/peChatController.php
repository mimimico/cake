<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peChatController
 *  @Project: Proto Engine 3
 */

class peShopController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        
        /* Generating response */
        $categories = new miCategory();
        
        $response = new peResponse("chat");
        
        $response->page->title = "chat" . peProject::getTitle();
        $response->page->categories = $categories->bind("displayCategories");
        
        if (miUser::logined()) $response->user = miUser::getLocal();
        $response->user->logined = miUser::logined();
        
        return $response;
    }
}