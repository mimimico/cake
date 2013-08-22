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
        
        $response = new peResponse("user");
        
        $response->page->title = "User" . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage");
        $response->page->categories = $categories->bind("displayCategories");
        //$response->user = miUser::getLocal();
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
        
        return $response;
    }
    
    public static function editAction()
    {
        peLoader::import("models.miCategory");
        
        $categories = new miCategory();
        
        $response = new peResponse("edit-profile");
        $response->page->categories = $categories->bind("displayCategories");
        
        return $response;
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
    }
    
    public static function facebookAction()
    {
        $user = new miUser();
        $user->facebookLogin();
    }
    
    public static function vkontakteAction()
    {
        $user = new miUser();
        $user->vkontakteLogin();
    }
}