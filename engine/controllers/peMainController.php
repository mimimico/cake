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
        
        $response->page->title = "Main" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, "main");
        $response->page->categories = $categories->bind("displayCategories");
        
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
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
        
        $input = new peRequest("page:i", "cname", "id:i");
        if (!$input->cname) $input->cname = "main";
        if (!$input->id) {
            if (miUser::logined())
                $input->id = miUser::getLocal()->uid;
            else 
                $input->id = 0;
        }
        
        $response = new peResponse("item_blocks", false);
        
        $response->page->items = $items->bind("displayItemPage", $input->page, $input->cname, $input->id);
        
        return $response;
    }
}