<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miUser
 *  @Project: Proto Engine 3
 */


class miUser extends peModel 
{           
    const DEFAULT_AVATAR = "http://example.com/image.png";
    
    public function create()
    {
        if (self::logined()) $this->error(21); //already logined
            
        if (isset($this->email) && isset($this->password) && isset($this->repassword)) {
            
            if (!$this->validEmail()) $this->error(14); //non-valid email
            
            if ($this->password != $this->repassword) $this->error(15); //passwords are different
            unset($this->repassword);
            
            $query = $this->query()->table("accounts");
            
            $registered = $query->select()->where(array("email" => $this->email))->run(true);
            if (!empty($registered)) $this->error(16); //acc exists
            
            $this->password = $this->hash($this->password);
            $this->registered = time();
            $query->insert()->values($this)->run();
            
            $hash = $this->hash($this->email, $this->password);
            
            $this->mail("register", self::url(
                array("name" => "user", "action" => "activate", "email" => $this->email, "hash" => $hash)
            ));
            
            self::redirect();   //notification about mail
            
        } else {
            $this->error(13); //empty fields
        }
    }
    
    public function activate($input)
    {
        if (self::logined()) $this->error(21);//
        
        $query = $this->query()->table("accounts");
        
        if ($input->email && $input->hash) {
            $result = $query->select()->where(array(
                "email" => $input->email, "activated" => 0
            ))->run(true);
            
            if (empty($result) || $input->email != $result->email) $this->error(22); // activated or not exists
            
            if ($this->hash($result->email, $result->password) == $input->hash) {
                $query->update()->set(array("activated" => 1))->where(array("email" => $input->email))->run();
            }
        }
    }
    
    public function login($input)
    {
        if (self::logined()) $this->error(21); //already logined
        
        if ($input->email && $input->password) {
            $query = $this->query()->table("accounts");
            $result = $query->select()->where(array(
                "email" => $input->email, "password" => $this->hash($input->password), "activated" => 1
            ))->run(true);
            
            if (!empty($result)) {
                $this->insert($result);
                $this->setLocal();
                $query->update()->run(); // update user for 
            } else {
                $this->error(20); // logging in error
            }
        } else {
            $this->error(13); //
        }
    }
    
    public static function logined()
    {
        return peSession::exists("pe_local_user");
    }
    
    public static function getLocal()
    {
        return peSession::get("pe_local_user");
    }
    
    public function setLocal()
    {
        return peSession::set("pe_local_user", $this);
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
    
    public function validEmail()
    {
        return preg_match('|([a-z0-9_\.\-]{1,40})@([a-z0-9\.\-]{1,30})\.([a-z]{2,6})|is', $this->email); 
    }
    
    public function hash($string)
    {
        return md5(strrev(md5(implode(peProject::getHashSalt(), (array)$string))));
    }
}