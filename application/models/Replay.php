<?php

class Application_Model_Replay extends Zend_Db_Table_Abstract
{
   protected $_name = "replay";
   
    //add a new comment
    function addReply($data,$thread_id,$user_id){
        $row = $this->createRow();
        $row->replayBody= $data['repalyBody'];
        $row->threadID = $thread_id;
        $row->userID = $user_id;
        return $row->save();
    }
  //select replies where threadid = ay 7aga
   function listRepliesByThreadId($id){
        return $this->fetchAll('threadID='.$id)->toArray();
    }
    
    function deleteReply($id){
         return $this->delete("replayID=$id");
    }
function editReply($id,$val){
    $this->update(['replayBody'=>$val], "replayID=".$id);
    return $this->fetchAll()->toArray();
    
}

}

