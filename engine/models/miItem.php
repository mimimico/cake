<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miItem
 *  @Project: Proto Engine 3
 */


class miItem extends peModel 
{
    public function callable_loadAll()
    {
        $small = $this->query()->select()->table("items")->where(
            array('size' => 1)
        )->limit(10)->order("uid", true)->run();
        
        $big = $this->query()->select()->table("items")->where(
            array('size' => 2)
        )->limit(1)->order("uid", true)->run();
        
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
                    $cname = $this->categories[$items[$i][$j]->category]->name;
                    $obj = (object)peStorage::get("lang-en");
                    $items[$i][$j]->category = $obj->$cname;
                    if (strlen($items[$i][$j]->title) > 31 && $items[$i][$j]->size == 1) {
                        $items[$i][$j]->title = substr($items[$i][$j]->title, 0, 31) . "...";
                    }
                }
            }
        }
        return $items;
    }
}