<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miItem
 *  @Project: Proto Engine 3
 */


class miItem extends peModel 
{
    public function like()
    {
        if (!miUser::logined()) {
            $name = "mi_like_" . $this->uid;
            if (!peCookie::get($name)) {
                peCookie::set($name, date("Y-m-d H:i:s"));
            }
        } else {
            miUser::getLocal()->like($this);
        }
    }
    
    public function getLikes()
    {
        if (!miUser::logined()) {
            $likes = array();
            foreach(peCookie::get() as $name => $value) {
                if (strpos($name, "mi_like_") !== false) {
                    list(,$id) = explode("like_", $name);
                    $likes[$id] = $value;
                }
            }
            return $likes;
        } else {
            return miUser::getLocal()->getLikes();
        }
    }
    
    public function getItemsPage($page = 0)
    {
        $query = $this->query()->select()->table("items")->order("uid", true);
        return array(
            $query->where(array("size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array("size" => 2))->limit($page, 1)->run(true),
        );
    }
    
    public function getItem($id = 0) 
    {
        return $this->query()->select()->table("items")->where(array("uid" => $id))->run(true);
    }
    
    public static function get($input)
    {
        $item = new self;
        $item->insert($item->getItem($input->id));
        return $item;
    }
    
    public function view_displayItem($params) 
    {
        $id = $this->getParam($params);
        return $this->getItem($id);
    }
    
    public function view_displayItemPage($params)
    {
        $page = $this->getParam($params);
        
        list($small, $big) = $this->getItemsPage($page);
        $categories = $this->categories->getSubCategories();
        $likes = $this->getLikes();
        if (empty($small) || empty($big)) { return; }
        if (count($small) < 7) $row = 1; else $row = rand(1,2);
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
                    if (isset($likes[$items[$i][$j]->uid])) {
                        $items[$i][$j]->liked = "liked";
                    }
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