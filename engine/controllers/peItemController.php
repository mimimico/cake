<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peItemController
 *  @Project: Proto Engine 3
 */

class peItemController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        peLoader::import("models.miComment");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $comments = new miComment();
        $items->categories = $categories;
        
        $request = new peRequest("id:i");
        $response = new peResponse("item", false);
        
        $response->page->title = "Главная" . peProject::getTitle();
        $response->page->categories = $categories->bind("displayCategories");
        $response->page->item = $items->getItem($request->id);
        $response->page->item->comments = $comments->bind("displayComments", $request->id);
        
        return $response;
    }
}