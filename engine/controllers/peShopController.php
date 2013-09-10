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
        if (!$request->id) self::error(404);
        $user = miUser::getUser($request->id);
        if (!$user->isMaster()) self::error(404);
        
        if (!$request->mode) $request->mode = 1;
        
        if ($request->mode === 1) {
            $type = "shop";
        } else {
            $type = "user";
        }
        $user->owner = false;
        if (miUser::logined()) {
            if (miUser::getLocal()->uid == $user->uid && $request->mode === 1) {
                $user->owner = true;
            }
        }
        $response = new peResponse("shop", false);
        $response->page->title = peLanguage::get("page_shop") . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, $type, $request->id, $user->owner);
        $response->page->categories = $categories->bind("displayCategories");
        if ($request->mode === 1) {
            $response->page->active->master = "active";
            $response->page->mode = true;
        }  else {
            $response->page->active->user = "active";
            $response->page->mode = false;
        }
        $response->shop = $user;
        
        return $response;
    }
    
    public static function addAction()
    {
        if (!miUser::logined()) self::error(23);
        if (!miUser::getLocal()->isMaster()) self::error(404);
        peLoader::import("models.miCategory");
        $response = new peResponse("add-item");
        $categories = new miCategory();
        $response->page->title = peLanguage::get("page_additem") . peProject::getTitle();
        $response->page->categories = $categories->bind("displayCategories");
        $response->categories = $categories->bind("listCategoryWithSub");
        return $response;
    }
    
    public static function handleAddAction()
    {
        peLoader::import("models.miItem");
        $item = new miItem();
        $item->create(new peRequest(
            "title", "description", "price", "category"
        ));
    }
}