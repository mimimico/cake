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
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $response = new peResponse("index");
        
        $response->page->title = "Главная" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage");
        $response->page->categories = $categories->bind("displayCategories");
        
        return $response;
    }
    
    public static function getItemsAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        
        $items->categories = $categories;
        
        $input = new peRequest("page:i");
        $response = new peResponse("item_blocks");
        
        $response->page->items = $items->bind("displayItemPage", $input->page);
        
        return $response;
    }
}