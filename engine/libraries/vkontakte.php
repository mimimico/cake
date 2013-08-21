<?php

require_once "base_vkontakte.php";

class Vkontakte extends BaseVkontakte
{
    private $userid = 0;

    public function __construct($params)
    {
        parent::__construct($params['app_id'], $params['api_secret']);
    }
    
    public function getLoginUrl($url, $params)
    {
        $scope = implode(",", $params["scope"]);
        return $this->getAuthorizeURL($scope, $url);
    }
    
    public function getUser()
    {
        if (!$this->userid) {
            if (peSession::exists("vk_api_token")) {
                $token = peSession::get("vk_api_token");
                $this->access_token = $token["access_token"];
            } else {
                $token = $this->getAccessToken($_REQUEST["code"], 
                    peHttp::url(array("name" => "user", "action" => "vkontakte"))
                );
                peSession::set("vk_api_token", $token);
            }
            $this->userid = $token["user_id"];
        }
        return $this->userid;
    }
}