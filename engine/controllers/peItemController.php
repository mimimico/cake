<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peItemController
 *  @Project: Proto Engine 3
 */

peLoader::import("models.miItem");
        
class peItemController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        peLoader::import("models.miComment");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $comments = new miComment();
        $items->categories = $categories;
        
        $request = new peRequest("id:i");
        if (!$request->id) self::error(404);
        $response = new peResponse("item");
        
        $response->page->title = "Главная" . peProject::getTitle();
        $response->page->categories = $categories->bind("displayCategories");
        $response->page->item = $items->getItem($request->id);
        $response->page->item->comments = $comments->bind("displayComments", $request->id);
        
        return $response;
    }
    
    public static function addAction()
    {
        peLoader::import("models.miCategory");
        $response = new peResponse("add-item");
        $categories = new miCategory();
        $response->page->categories = $categories->bind("displayCategories");
        return $response;
    }
    
    public static function likeAction()
    {
        $item = miItem::get(new peRequest("id:i"));
        $item->like();
        self::redirect();
    }
}