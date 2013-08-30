<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miChat
 *  @Project: Proto Engine 3
 */


class miChat extends peModel 
{
    public function send($data, $user)
    {
        
    }
    
    public function getLastSender($userid)
    {
        if ($userid) {
            return @$this->query()->select("senderid")->table("messages")->where(
                array("userid" => $userid)
            )->limit(1)->run(true)->senderid;
        }
    }
    
    public function view_displayChatMessages($params)
    {
        $senderid = $this->getParam($params);
        $userid = miUser::getLocal()->uid;
        if (!$senderid) $senderid = $this->getLastSender($userid);
        if ($senderid && $userid) {
            $messages = $this->query()->select()->table("messages")->where(array(
                "(userid=$userid AND senderid=$senderid) OR (userid=$senderid AND senderid=$userid)"
            ))->order("uid", true)->run();
            foreach($messages as $message) {
                if ($message->senderid == $userid) {
                    $message->type = "request";
                }  else {
                    $message->type = "reply";
                }
            }
            return $messages;
        }
    }
    
    public function view_displayChatUsers($params)
    {
        $user = miUser::getLocal();
        $uids = $this->query()->select("DISTINCT senderid")->table("messages")->where(array("userid" => $user->uid))->prepare();
        $order = $this->query()->select("GROUP_CONCAT(DISTINCT senderid ORDER BY uid SEPARATOR ',')")->table("messages")->where(array("userid" => $user->uid))->prepare();
        $result = $this->query()->select()->table("accounts")->where(array("uid IN ($uids)"))->order("FIND_IN_SET (uid,($order))")->run();
        $users = array();
        foreach($result as $id => $messanger) {
            $users[$id] = new miUser();
            $users[$id]->insert($messanger);
            $users[$id]->load();
            if (!$id) $users[$id]->active = "class='active'";
        }
        return $users;
    }
}
//SELECT * FROM accounts WHERE uid IN (SELECT DISTINCT senderid FROM messages WHERE userid=18) ORDER BY FIND_IN_SET (uid, (SELECT GROUP_CONCAT(DISTINCT senderid ORDER BY uid DESC SEPARATOR ',') FROM messages WHERE userid=18))