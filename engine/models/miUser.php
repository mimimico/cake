<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miUser
 *  @Project: Proto Engine 3
 */


class miUser extends peModel
{           
    const DEFAULT_AVATAR = "http://soft.vsevnet.ru/templates/soft/images/noavatar.png";
    
    public function like($item, $date = null)
    {
        $date = (!empty($date)) ? $date : date("Y-m-d H:i:s");
        if ($item instanceof miItem) $item = $item->uid;
        $item = peRequest::getInput($item, peInput_Int);
        
        $liked = $this->query()->table("likes")->select()->where(
            array("itemid" => $item, "userid" => $this->uid)
        )->run(true);
        
        if (empty($liked)) {
            $this->query()->insert()->table("likes")->values(
                array("itemid" => $item, "userid" => $this->uid, "date" => $date)
            )->run();
            return true;
        } else {
            $this->query()->delete()->table("likes")->where(
                array("itemid" => $item, "userid" => $this->uid)
            )->run();
            return false;
        }
        return null;
    }
    
    public function getLikes()
    {
        $data = $this->query()->table("likes")->select()->where(array("userid" => $this->uid))->run();
        $likes = array();
        foreach($data as $like) {
            $likes[$like->itemid] = $like;
        }
        return $likes;
    }
    
    public function transferLikes()
    {
        foreach(peCookie::get() as $name => $value) {
            if (strpos($name, "mi_like_") !== false) {
                list(,$id) = explode("_like_", $name);
                $this->like($id, peCookie::remove($name));
            }
        }
    }
    
    public function create()
    {
        if (self::logined()) $this->error(21);
            
        if (isset($this->email) && isset($this->password) && isset($this->repassword)) {
            
            if (!$this->validEmail()) $this->error(14);
            
            if ($this->password != $this->repassword) $this->error(15);
            unset($this->repassword);
            
            $query = $this->query()->table("accounts");
            
            $registered = $query->select()->where(array("email" => $this->email))->run(true);
            if (!empty($registered)) $this->error(16);
            
            $this->password = $this->hash($this->password);
            $this->registered = date("Y-m-d H:i:s");
            $query->insert()->values($this)->run();
            
            $hash = $this->hash($this->email, $this->password);
            
            $this->mail("register", self::url(
                array("name" => "user", "action" => "activate", "email" => $this->email, "hash" => $hash)
            ));
            
            self::redirect();   //notification about mail
            
        } else {
            $this->error(13);
        }
    }
    
    public function removeImage()
    {
        $this->query()->update()->table("accounts")->set(array("avatar" => ""))->where(array("uid" => $this->uid))->run();
        unset($this->avatar);
        $this->removeLocal();
        $this->unload();
        $this->load();
        $this->setLocal();
    }
    
    public function activate($input)
    {
        if (self::logined()) $this->error(21);
        
        $query = $this->query()->table("accounts");
        
        if ($input->email && $input->hash) {
            $result = $query->select()->where(array(
                "email" => $input->email, "activated" => 0
            ))->run(true);
            
            if (empty($result) || $input->email != $result->email) $this->error(22); 
            
            if ($this->hash($result->email, $result->password) == $input->hash) {
                $query->update()->set(array("activated" => 1))->where(array("email" => $input->email))->run();
            }
            
            $this->redirect();
        }
    }
    
    public function update($data)
    {
        if (!$this->validEmail($data->email)) $this->error(14);
        if ($data->password != $data->repassword) $this->error(15);
        if (!$data->password) unset($data->password);
        else $data->password = $this->hash($data->password);
        
        if ($data->email != $this->email) {
            $result = $this->query()->select()->table("accounts")->where(array("email" => $data->email))->run(true);
            if (!empty($result)) $this->error(16);
        }
        $this->insert($data);
        $this->removeLocal();
        $this->unload();
        $image = new peImage(@$_FILES["upload"], 1000 * 1000); // 1000 kb
        $imagename = md5(time()) . "_". rand(100,100000);
        if ($image->save($imagename)) {
            $this->avatar = $image->getUrl();
        }
        
        $this->query()->update()->table("accounts")->set($this)->where(array("email" => $this->email))->run();
        $this->load();
        $this->setLocal();
    }
    
    public function login($input)
    {
        if (self::logined()) $this->error(21);
        
        if ($input->email && $input->password) {
            if (!$this->validEmail($input->email)) $this->error(14);
            $query = $this->query()->table("accounts");
            $result = $query->select()->where(array(
                "email" => $input->email, "password" => $this->hash($input->password), "activated" => 1
            ))->run(true);
            
            if (!empty($result)) {
                $this->insert($result);
                $this->load();
                $this->setLocal();
                $this->transferLikes();
                $this->redirect();
            } else {
                $this->error(20); 
            }
        } else {
            $this->error(13);
        }
    }
    
    
    public function socialLogin($type = 0)
    {
        if ($type) {
            peLoader::import("models.miFacebook");
            $handler = miFacebook::get();
        } else {
            peLoader::import("models.miVkontakte");
            $handler = miVkontakte::get();
        }
        
        if ($handler->getUser()) {
            
            $query = $this->query()->table("accounts");
            
            if ($type) {
                $data = (object)$handler->api("/me");
                $this->email = $data->email;
                $this->fbid = $data->id;
                $this->avatar = "https://graph.facebook.com/".$data->id."/picture?width=100&height=100";
                $registered = $query->select()->where(array("fbid" => $this->fbid))->run(true);
            } else {
                $response = $handler->api("users.get", array(
                    "fields" => "uid,first_name,last_name,photo,photo_medium"
                ));
                $data = (object)$response["response"][0];
                $this->vkid = $data->uid;
                $this->avatar = $data->photo_medium;
                $registered = $query->select()->where(array("vkid" => $this->vkid))->run(true);
            }
            $this->firstname = $data->first_name;
            $this->lastname = $data->last_name;
            
            if (empty($registered)) {
                $this->registered = date("Y-m-d H:i:s");
                $this->activated = 1;
                $query->insert()->values($this)->run();
            } else {
                $this->insert($registered);
            }
            $this->load();
            $this->transferLikes();
            $this->setLocal();
            $this->redirect();
        }
    }
    
    public function load()
    {
        if ($this->firstname || $this->lastname) {
            $this->name = $this->firstname . " " . $this->lastname;
        } else {
            $this->name = $this->email;
        }
        if ($this->fbid || $this->vkid) {
            $this->image = $this->avatar;
        } else {
            $this->image = $this->getAvatar(100);
        }
        if (!$this->image) {
            $this->image = $this->getAvatar(100);
        }
        $this->master = $this->isMaster();
        $this->not_master = !$this->master;
        if ($this->master) {
            $this->status = "user_status_master";
        } else {
            $this->status = "user_status_user";
        }
        $this->status = peLanguage::get($this->status);
    }
    
    public function unload()
    {
        if (!$this->password) unset($this->password);
        unset($this->repassword);
        unset($this->name);
        unset($this->master);
        unset($this->not_master);
        unset($this->image);
        unset($this->status);
        unset($this->logined);
        unset($this->links);
    }
    
    public function setType($type = 0)
    {
        if ($this->type == 0 && $type == 1) {
            if (!$this->firstname || !$this->lastname || !$this->address || !$this->country || !$this->city || !$this->phone) {
                $this->error(25);
            }
        }
        $this->type = $type;
        $this->removeLocal();
        $this->unload();
        $this->load();
        $this->setLocal();
        $this->query()->update()->table("accounts")->where(array("uid" => $this->uid))->set(array("type" => $type))->run();
    }
    
    public function subscribe($user) 
    {
        if ($this->uid == $user->uid) return;
        if (!$this->isMaster()) return;
        $cond = array("userid" => $user->uid, "shopid" => $this->uid);
        $result = $this->query()->table("subscribers")->select()->where($cond)->run();
        if (!$result) {
            $this->query()->insert()->table("subscribers")->set($cond)->run();
        }
    }
    
    public function getSubscribers() 
    {
        return @$this->query()->select("COUNT(*) AS count")->table("subscribers")->where(array(
            "shopid" => $this->uid
        ))->run(true)->count;
    }
    
    public function isMaster()
    {
        if ($this->type == 1) {
            return true;
        }
        return false;
    }
    
    public static function getUser($id)
    {
        $user = new self;
        $result = $user->query()->select()->table("accounts")->where(array("uid" => $id))->run(true);
        if (!$result) return false;
        $user->insert($result);
        $user->load();
        return $user;
    }
    
    public function logout()
    {
        $this->removeLocal();
    }
    
    public static function logined()
    {
        return peSession::exists("pe_local_user");
    }
    
    public static function getLocal()
    {
        return peSession::get("pe_local_user");
    }
    
    public function removeLocal()
    {
        return peSession::remove("pe_local_user");
    }
    
    public function setLocal()
    {
        return peSession::set("pe_local_user", $this);
    }
    
    public static function getLinks()
    {
        $links = array();
        if (!self::logined()) {
            peLoader::import("models.miFacebook");
            peLoader::import("models.miVkontakte");

            $links = new peResponse();

            $links->facebook = miFacebook::get()->getLoginUrl(
                self::url(array("name" => "user", "action" => "facebook")),
                array("scope" => array("email", "user_about_me"))
            );

            $links->vkontakte = miVkontakte::get()->getLoginUrl(
                peHttp::url(array("name" => "user", "action" => "vkontakte")),
                array("scope" => array("notify", "offline", "photo"))
            );
        }
        return $links;
    }    
    
    public function getAvatar($size = 50)
    {
        if ($this->email == "viktori.bona@gmail.com") return "http://mimimi.co/tpl/mimimi/images/victory.jpg";
        return "http://www.gravatar.com/avatar/" . md5(strtolower(trim($this->email))) . "?d=" . urlencode(self::DEFAULT_AVATAR) . "&s=" . $size;
    }
    
    public function mail($topic, $message)
    {
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= "From: noreply <Admin>\r\n";
        mail($this->email, $topic, $message, $headers);
        return true;
    }
    
    public function validEmail($email = null)
    {
        $email = (empty($email)) ? $this->email : $email;
        return preg_match('|([a-z0-9_\.\-]{1,40})@([a-z0-9\.\-]{1,30})\.([a-z]{2,6})|is', $email); 
    }
    
    public function hash($string)
    {
        return md5(strrev(md5(implode(peProject::getHashSalt(), (array)$string))));
    }
}