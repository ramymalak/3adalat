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
    
    //delete replay
     function deleteReply($id){
        return $this->delete("replayID=$id");
    }
    
    //get reply by id
      function getReplyById($id){
        return $this->find($id)->toArray();
    }
    
    function editReply($data){
       
//       if(!empty($data['replayID']))
//            $data['replayID']=$data['replayID'];
//        else
//            unset ($data['replayID']); 
//        
//        if(!empty($data['repalyBody']))
//            $data['repalyBody']=$data['repalyBody'];
//        else
//            unset ($data['repalyBody']); 
//        
        var_dump($data);
                exit();
         $this->update($data,"replayID=".$data['replayID']);
        return $this->fetchAll()->toArray();
    }

}

