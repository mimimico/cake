<?php

class peErrorController
{
    public static function indexAction()
    {
        $param = new peRequest("code:i", "back:i");
        $errors = array(
            7  => "err_image_bigger",
            13 => "err_empty_fileds",
            14 => "err_non_valid_email",
            15 => "err_diff_pass",
            16 => "err_acc_exists",
            20 => "err_acc_not_exists_or_not_activated",
            21 => "err_already_logined",
            22 => "err_acc_not_exists_or_activated",
            23 => "err_you_must_be_logined",
            35 => "err_image_upload",
            404 => "err_404",
        );
        if (isset($errors[$param->code])) {
            $message = $errors[$param->code];
        } else {
            $message = "err_unknown";
        }
        
        peLoader::import("models.miCategory");
        peLoader::import("models.miItem");
        
        /* Generating response */
        $categories = new miCategory();
        $items = new miItem();
        $items->categories = $categories;
        
        $response = new peResponse("index");
        
        $response->page->title = peLanguage::get("page_error") . peProject::getTitle();
        $response->page->items = $items->bind("displayItemPage", 0, "main");
        $response->page->categories = $categories->bind("displayCategories");
        if (miUser::logined()) {
            $response->user = miUser::getLocal();
        }
        $response->user->logined = miUser::logined();
        $response->user->links = miUser::getLinks();
        $response->error->message = peLanguage::get($message);
        $response->page->error = true;
        return $response;
    }
}