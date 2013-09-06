<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peCategoryController
 *  @Project: Proto Engine 3
 */

class peCategoryController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $response = new peResponse("categories");
        
        $response->page->title = "Main" . peProject::getTitle();
        $response->page->categories = $categories->bind("displayCategories");
        if (miUser::logined()) {
            $response->user = miUser::getLocal();
        }
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
        return $response;
    }
}