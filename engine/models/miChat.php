<?php

/**
 *  @Author: Vladislav Gritsenko (Inlife)
 *  @Name: miChat
 *  @Project: Proto Engine 3
 */


class miChat extends peModel 
{
    public function send($data)
    {
        if ($data->id && $data->message) {
            $user = miUser::getLocal();
            $this->query()->insert()->table("messages")->values(array(
                "userid" => $data->id, "senderid" => $user->uid, "text" => $data->message
            ))->run();
            
            $this->redirect($this->url(array(
                "name" => "chat", "action" => "index", "id" => $data->id
            )));
        } else {
            $this->error(13);
        }
    }
    
    public function getPartner($senderid = 0)
    {
        $userid = miUser::getLocal()->uid;
        if (!$senderid) $senderid = $this->getLastSender($userid);
        return $senderid;
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
        $userid = miUser::getLocal()->uid;
        $senderid = $this->getPartner($this->getParam($params));
        if ($senderid && $userid) {
            $messages = $this->query()->select()->table("messages")->where(array(
                "(userid=$userid AND senderid=$senderid) OR (userid=$senderid AND senderid=$userid)"
            ))->run();
            foreach($messages as $message) {
                if ($message->senderid != $userid) {
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
        $o1 = $this->query()->select("GROUP_CONCAT(DISTINCT userid ORDER BY uid SEPARATOR ',')")->table("messages")->where(array("senderid" => $user->uid))->prepare();
        $o2 = $this->query()->select("GROUP_CONCAT(DISTINCT senderid ORDER BY uid SEPARATOR ',')")->table("messages")->where(array("userid" => $user->uid))->prepare();
        $condition = array("uid IN (SELECT senderid AS m1 FROM messages UNION SELECT userid AS m1 FROM messages)");
        $order = "FIND_IN_SET (uid,(CONCAT(($o1),',',($o2))))";
        $result = $this->query()->select()->table("accounts")->where($condition)->order($order, true)->run();
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
//SELECT * FROM accounts WHERE uid IN (SELECT senderid AS m1 FROM messages UNION SELECT userid AS m1 FROM messages) ORDER BY FIND_IN_SET (uid,(CONCAT((SELECT GROUP_CONCAT(DISTINCT senderid ORDER BY uid SEPARATOR ',') FROM messages WHERE userid=18),',',(SELECT GROUP_CONCAT(DISTINCT userid ORDER BY uid SEPARATOR ',') FROM messages WHERE senderid=18)))) DESC