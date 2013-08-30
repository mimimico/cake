<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miUser
 *  @Project: Proto Engine 3
 */


class miUser extends peModel
{           
    const DEFAULT_AVATAR = "https://i2.sndcdn.com/avatars-000045339377-uj67gq-t500x500.jpg?0769104";
    
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
        }
        return false;
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
        }
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
        $this->master = $this->isMaster();
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