<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miCategory
 *  @Project: Proto Engine 3
 */


class miCategory extends peModel 
{
    public function loadAll()
    {
        $result = $this->query()->select()->table("categories")->run();
        $categories = array();
        foreach($result as $obj) $categories[$obj->uid] = $obj;
        return $categories;
    }
}