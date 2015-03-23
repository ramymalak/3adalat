<?php

class Application_Model_Message extends Zend_Db_Table_Abstract
{
    // Define table name
    protected $_name= 'messages';
    
    function sendMessage($senderId,$recieverId,$body)
    {
        $row = $this->createRow();
        $row->messageBody= $body;
        $row->messageSender = $senderId;
        $row->messageReciever = $recieverId;
        return $row->save();
    }
    
    function listMessages($messageRecieverId){
        
        //return $this->fetchAll()->toArray();
        return $this->fetchAll("messageReciever = $messageRecieverId")->toArray();
    }
    
    function invseen($MessageID){
        
        $themsg=$this->find($MessageID)->toArray();
        if($themsg[0]['seenFlag']){
            $data['seenFlag']=false;
        }else{
           $data['seenFlag']=true; 
        }
        return $this->update($data, "MessageID=".$MessageID);
    }
    
    


}

