<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peUserController
 *  @Project: Proto Engine 3
 */

class peUserController extends peController
{
    public static function indexAction()
    {
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        peLoader::import("models.miUser");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $request = new peRequest("id:i");
        if (!$request->id) $request->id = miUser::getLocal()->uid;
        $response = new peResponse("user");
        
        $response->page->title = "User" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, "user", $request->id);
        $response->page->categories = $categories->bind("displayCategories");
        
        $response->user = miUser::getUser($request->id);
        if ($response->user->isMaster()) {
            self::redirect(self::url(array(
                "name" => "shop", "action" => "index", "id" => $request->id
            )));
        }
        
        return $response;
    }
    
    public static function editAction()
    {
        peLoader::import("models.miCategory");
        
        $categories = new miCategory();
        
        $response = new peResponse("edit-profile");
        $response->page->categories = $categories->bind("displayCategories");
        if (!miUser::logined()) self::error(23);
        $response->user = miUser::getLocal();
        
        return $response;
    }
    
    public static function updateAction()
    {
        if (!miUser::logined()) self::error(23);
        $user = miUser::getLocal();
        $user->update(new peRequest(
            "firstname", "lastname", "password", "repassword", 
            "email", "phone", "country", "city", "address", "postindex"
        ));
        self::redirect(self::url(array(
            "name" => "user", "action" => "index"
        )));
    }
    
    public static function createShopAction() 
    {
        if (!miUser::logined()) self::error(23);
        miUser::getLocal()->setType(1);
        self::redirect(self::url(array(
            "name" => "user", "action" => "edit"
        )));
    }
    
    public static function removeImageAction() 
    {
        if (!miUser::logined()) self::error(23);
        miUser::getLocal()->removeImage();
        self::redirect(self::url(array(
            "name" => "user", "action" => "edit"
        )));
    }
    
    public static function registerAction()
    {
        $user = new miUser();
        $user->insert(new peRequest("email", "password", "repassword"));
        $user->create();
    }
    
    public static function activateAction()
    {
        $user = new miUser();
        $user->activate(new peRequest("hash", "email"));
    }
    
    public static function loginAction()
    {
        $user = new miUser();
        $user->login(new peRequest("email", "password"));
    }
    
    public static function logoutAction()
    {
        if (miUser::logined()) miUser::getLocal()->logout();
        self::redirect();
    }
    
    public static function facebookAction()
    {
        $user = new miUser();
        $user->socialLogin(1);
    }
    
    public static function vkontakteAction()
    {
        $user = new miUser();
        $user->socialLogin(0);
    }
}