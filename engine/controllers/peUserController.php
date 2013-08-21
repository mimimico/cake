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
        $response = new peResponse("user");
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