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
        
        $request = new peRequest("id:i", "mode:i");
        if (!$request->id || !miUser::getUser($request->id)->isMaster()) self::error(404);
        if (!$request->mode) $request->mode = 1;
        
        if ($request->mode === 1) {
            $type = "shop";
        } else {
            $type = "user";
        }
        
        $response = new peResponse("shop", false);
        $response->page->title = "Shop" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, $type, $request->id);
        $response->page->categories = $categories->bind("displayCategories");
        if ($request->mode === 1) {
            $response->page->active->master = "active";
            $response->page->mode = true;
        }  else {
            $response->page->active->user = "active";
            $response->page->mode = false;
        }
        $response->user->uid = $request->id;
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
        
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
}