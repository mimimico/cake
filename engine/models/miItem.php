<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miItem
 *  @Project: Proto Engine 3
 */


class miItem extends peModel 
{
    public function create($data)
    {
        if ($data->title && $data->category && $data->description && $data->price) {
            if (!miUser::logined()) $this->error(23);
            if (!miUser::getLocal()->isMaster()) $this->error(36); // only masters
            
            $image = new peImage("upload", 1000 * 1000); // 300 kb
            $imagename = md5(time()) . "_". rand(100,100000);
            if ($image->save($imagename)) {
                $this->image = $image->getUrl();
            } else {
                $this->error(35); // wrong image
            }
            $this->insert($data);
            $this->userid = miUser::getLocal()->uid;
                    
            $this->query()->insert()->table("items")->values($this)->run();
            
            $this->redirect();
            
        } else {
            $this->error(13);
        }
    }
    
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
    
    public function buy($data)
    {
        if ($data->id) {
            peLoader::import("models.miChat");
            $result = $this->getItem($data->id);
            if (!empty($result)) {
                $this->insert($result);
                $msg = new stdClass();
                $msg->message = "Добрый день, я бы хотел заказать ваш товар под именем " . $this->title;
                $msg->id = $this->userid;
                $chat = new miChat();
                $chat->send($msg);
            }
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
    
    public function getUserItems($userid, $page = 0)
    {
        $comments = $this->query()->select("itemid")->table("comments")->where(array("userid=". $userid))->prepare();
        $likes = $this->query()->select("itemid")->table("likes")->where(array("userid=$userid UNION ($comments)"))->prepare();
        $query = $this->query()->select()->table("items")->order("uid", true);
        $condition = "uid IN (" . $likes . ")";
        return array(
            $query->where(array($condition, "size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array($condition, "size" => 2))->limit($page, 1)->run(true),
        );
    }
    
    public function getShopItems($userid, $page = 0) 
    {
        $query = $this->query()->select()->table("items")->order("uid", true);
        return array(
            $query->where(array("userid" => $userid, "size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array("userid" => $userid, "size" => 2))->limit($page, 1)->run(true),
        );
    }
    
    public function getItem($id = 0) 
    {
        $item = $this->query()->select()->table("items")->where(array("uid" => $id))->run(true);
        $price = new stdClass();
        $price->usd = $item->price;
        $price->uah = $price->usd * 8;
        $item->price = $price;
        return $item;
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
        $item = $this->getItem($id);
        $price = new stdClass();
        $price->usd = $item->price;
        $price->uah = $price->usd * 8;
        $item->price = $price;
        return $item;
    }
    
    public function view_displayItemPage($params)
    {
        $page = $this->getParam($params);
        $type = $this->getParam($params, 1);
        $userid = $this->getParam($params, 2);
        
        $rawitems = array();
        
        if ($type === 0 || $type == "main" || $type == "error") {
            $rawitems = $this->getItemsPage($page);
        } else if ($type == "user") {
            $rawitems = $this->getUserItems($userid, $page); 
        } else if ($type == "shop") {
            $rawitems = $this->getShopItems($userid, $page);
        }
        
        list($small, $big) = $rawitems;
        $categories = $this->categories->getSubCategories();
        $likes = $this->getLikes();
        if (empty($small) && empty($big)) { return; }
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
                    $items[$i][$j]->price = $price;
                    if (isset($likes[$items[$i][$j]->uid])) {
                        $items[$i][$j]->liked = "liked";
                    }
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