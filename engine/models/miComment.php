<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miComment
 *  @Project: Proto Engine 3
 */


class miComment extends peModel 
{
    public function create($data)
    {
        if ($data->comment && $data->id) {
            if (!miUser::logined()) $this->error(23);
            $user = miUser::getLocal();
            
            $this->query()->insert()->table("comments")->values(array(
                "userid" => $user->uid, "itemid" => $data->id, "text" => $data->comment  
            ))->run();
            
            $this->redirect($this->url(array(
                "name" => "item", "action" => "index", "id" => $data->id
            )));
            
        } else {
            $this->error(13);
        }
    }
    
    public function getComments($condition)
    {
        return $this->query()->select()->table("comments")->where($condition)->order("uid", true)->run();
    }
    
    public function view_displayComments($params)
    {
        $itemid = $this->getParam($params);
        return $this->getComments(array("itemid" => $itemid));
    }
}