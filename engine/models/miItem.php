<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miItem
 *  @Project: Proto Engine 3
 */


class miItem extends peModel 
{
    public function getItemsPage($page = 0)
    {
        $query = $this->query()->select()->table("items")->order("uid", true);
        return array(
            $query->where(array("size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array("size" => 2))->limit($page, 1)->run(true)
        );
    }
    
    public function view_displayItemPage($params)
    {
        if (is_array($params) && isset($params[0])) {
            $page = array_shift($params);
        } else {
            $page = 0;
        }
        
        list($small, $big) = $this->getItemsPage($page);
        $categories = $this->categories->getSubCategories();
        if (empty($small) || empty($big)) { return; }
        $row = rand(1,2);
        $pos = rand(0,1);
        $items = array();
        for($i = 0; $i < 4; $i++) {
            for($j = 0; $j < 3; $j++) {
                if ($i == $row && ($j == $pos || $j == $pos + 1)) {
                    if ($j == $pos) {
                        $items[$i][$j] = $big;
                    }
                } else {
                    $items[$i][$j] = array_shift($small);
                }
                if (isset($items[$i][$j])) {
                    $price = new stdClass();
                    $price->usd = $items[$i][$j]->price;
                    $price->uah = $price->usd * 8;
                    $items[$i][$j]->price = $price;
                    $cname = $categories[$items[$i][$j]->category]->name;
                    $items[$i][$j]->category = $cname;
                    if (strlen($items[$i][$j]->title) > 31 && $items[$i][$j]->size == 1) {
                        $items[$i][$j]->title = substr($items[$i][$j]->title, 0, 31) . "...";
                    }
                }
            }
        }
        return $items;
    }
}