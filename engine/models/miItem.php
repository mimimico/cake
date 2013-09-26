<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miItem
 *  @Project: Proto Engine 3
 */


class miItem extends peModel 
{
    const IMAGE_SIZE = 1000000;
    const IMAGES_LIMIT = 3;
    
    public function create($data)
    {
        if ($data->title && $data->category && $data->description && $data->price) {
            if (!miUser::logined()) $this->error(23);
            if (!miUser::getLocal()->isMaster()) $this->error(36); // only masters
            
            $image = new peImage(@$_FILES["upload"], self::IMAGE_SIZE); // 1000 kb
            $imagename = md5(time()) . "_". rand(100,100000);
            if ($image->save($imagename)) {
                $this->image = $image->getUrl();
            } else {
                $this->error(35); // wrong image
            }
            
            $images = peImage::rearrange(@$_FILES["uploadmore"]);
            for($i = 0; $i < self::IMAGES_LIMIT; $i++) {
                if (isset($images[$i]) && !empty($images[$i]) && !empty($images[$i]["name"])) {
                    $prop = "subimage_".$i;
                    $image = new peImage($images[$i], self::IMAGE_SIZE); // 1000 kb
                    $imagename = md5(time()) . "_". rand(100,100000);
                    if ($image->save($imagename)) {
                        $this->$prop = $image->getUrl();
                    } else {
                        $this->error(35); // wrong image
                    }
                }
            }
            
            $this->category = $data->category;
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
        $result = false;
        if (!miUser::logined()) {
            $name = "mi_like_" . $this->uid;
            if (!peCookie::get($name)) {
                peCookie::set($name, date("Y-m-d H:i:s"));
                $result = true;
            } else {
                peCookie::remove($name);
            }
        } else {
            $result = miUser::getLocal()->like($this);
        }
        print($result); die();
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
                $msg->message = peLanguage::get("text_buy") . $this->title;
                $msg->id = $this->userid;
                $chat = new miChat();
                $chat->send($msg);
            }
        }
    }
    
    public function getLikesCount()
    {
        return @$this->query()->select("COUNT(*) AS c")->table("likes")->where(array("itemid" => $this->uid))->run(true)->c;
    }
    
    public function getViewsCount($update = false) 
    {
        $q = $this->query()->table("items")->where(array("uid" => $this->uid));
        if ($update) {
            $q->update()->set(array("views" => "views+1:ns"))->run();
        }
        return @$q->select("views")->run(true)->views;
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
    
    public function getCategoriesItems($id = 0, $page = 0)
    {
        $query = $this->query()->select()->table("items")->order("uid", true);
        $cond = $this->query()->select("uid")->table("categories")->where(array("parent" => $id))->prepare();
        return array(
            $query->where(array("category IN ($cond)", "size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array("category IN ($cond)", "size" => 2))->limit($page, 1)->run(true),
        );
    }
    
    public function getSubCategoriesItems($id = 0, $page = 0) 
    {
        $query = $this->query()->select()->table("items")->order("uid", true);
        return array(
            $query->where(array("category" => $id, "size" => 1))->limit($page * 10, 10)->run(),
            $query->where(array("category" => $id, "size" => 2))->limit($page, 1)->run(true),
        );
    }
    
    public function getItem($id = 0) 
    {
        $item = $this->query()->select()->table("items")->where(array("uid" => $id))->run(true);
        $price = new stdClass();
        $price->usd = $item->price;
        $price->uah = $price->usd * 8;
        $item->price = $price;
        $subimages = array();
        for($i = 0; $i < self::IMAGES_LIMIT; $i++) {
            $prop = "subimage_".$i;
            if ($item->$prop) {
                $subimages[$i] = new stdClass();
                $subimages[$i]->image = $item->$prop;
            }
        }
        $item->subimages = $subimages;
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
        $owner = $this->getParam($params, 3);
        
        $rawitems = array();
        
        if ($type === 0 || $type == "main" || $type == "error") {
            $rawitems = $this->getItemsPage($page);
        } else if ($type == "user") {
            $rawitems = $this->getUserItems($userid, $page); 
        } else if ($type == "shop") {
            $rawitems = $this->getShopItems($userid, $page);
        } else if ($type == "categories") {
            $rawitems = $this->getCategoriesItems($userid, $page);
        } else if ($type == "subcategories") {
            $rawitems = $this->getSubCategoriesItems($userid, $page);
        }
        
        list($small, $big) = $rawitems;
        if ($owner) {
            $lobj = new stdClass();
            $lobj->button = true;
            array_unshift($small, $lobj);
        }
        $categories = $this->categories->getSubCategories();
        $likes = $this->getLikes();
        
        if (empty($small) && empty($big)) { return; }
        if (count($small) < 4) $row = 0; 
        elseif (count($small) < 7) $row = 1; 
        else $row = rand(1,2);
        
        $pos = rand(0,1);
        $items = array();
        for($i = 0; $i < 4; $i++) {
            for($j = 0; $j < 3; $j++) {
                if ($i == $row && ($j == $pos || $j == $pos + 1) && !empty($big)) {
                    if ($j == $pos) {
                        $items[$i][$j] = $big;
                    }
                } else {
                    $items[$i][$j] = array_shift($small);
                }
                if (isset($items[$i][$j]) && !$items[$i][$j] instanceof stdClass) {
                    $price = new stdClass();
                    $price->usd = $items[$i][$j]->price;
                    $price->uah = $price->usd * 8;
                    $items[$i][$j]->price = $price;
                    if (isset($likes[$items[$i][$j]->uid])) {
                        $items[$i][$j]->liked = "liked";
                    }
                    $items[$i][$j]->catid = $items[$i][$j]->category;
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