<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peChatController
 *  @Project: Proto Engine 3
 */

class peChatController extends peController
{
    public static function indexAction()
    {
        /* Imports */
        peLoader::import("models.miCategory");
        peLoader::import("models.miChat");
        
        /* Generating response */
        $categories = new miCategory();
        $chat = new miChat();
        
        $request = new peRequest("id:i");
        if (!miUser::logined()) self::error(23);
        
        $response = new peResponse("chat", false);
        
        $response->page->title = "chat" . peProject::getTitle();
        
        $response->page->categories = $categories->bind("displayCategories");
        $response->chat->users = $chat->bind("displayChatUsers");
        $response->chat->messages = $chat->bind("displayChatMessages", $request->id);
        $response->chat->partner = $chat->getPartner($request->id);
        
        if (miUser::logined()) $response->user = miUser::getLocal();
        $response->user->logined = miUser::logined();
        
        return $response;
    }
    
    public static function sendAction()
    {
        peLoader::import("models.miChat");
        $chat = new miChat();
        $chat->send(new peRequest("id:i", "message:t"));
    }
}