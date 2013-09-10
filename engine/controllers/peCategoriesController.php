<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peCategoriesController
 *  @Project: Proto Engine 3
 */

class peCategoriesController extends peController
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
        
        $request = new peRequest("id:i");
        $response = new peResponse("categories");
        
        $response->page->title = peLanguage::get("page_categories") . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, "categories", $request->id);
        $response->page->categories = $categories->bind("displayCategories");
        if (miUser::logined()) {
            $response->user = miUser::getLocal();
        }
        $response->user->logined = miUser::logined();
        $response->page->subcategories = $categories->bind("displaySubCategories", $request->id);
        return $response;
    }
    
    public static function subAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");        
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $request = new peRequest("id:i");
        $response = new peResponse("categories");
        
        $response->page->title = peLanguage::get("page_subcategories") . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, "subcategories", $request->id);
        $response->page->categories = $categories->bind("displayCategories");
        if (miUser::logined()) {
            $response->user = miUser::getLocal();
        }
        $response->user->logined = miUser::logined();
        $response->page->subcategories = $categories->bind("displaySubCategories", $request->id, 1);
        return $response;
    }
}