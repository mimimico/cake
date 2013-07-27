<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miComment
 *  @Project: Proto Engine 3
 */


class miComment extends peModel 
{
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