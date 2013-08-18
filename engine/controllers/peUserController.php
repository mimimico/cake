<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: peUserController
 *  @Project: Proto Engine 3
 */

class peUserController extends peController
{
    public static function registerAction()
    {
        /* Imports */
        peLoader::import("models.miUser");
        
        $user = new miUser();
        $user->insert(new peRequest("email", "password", "repassword"));
        $user->create();
    }
    
    public static function activateAction()
    {
        /* Imports */
        peLoader::import("models.miUser");
        
        $user = new miUser();
        $user->activate(new peRequest("hash", "email"));
    }
    
    public static function loginAction()
    {
        /* Imports */
        peLoader::import("models.miUser");
        
        $user = new miUser();
        $user->login(new peRequest("email", "password"));
    }
}