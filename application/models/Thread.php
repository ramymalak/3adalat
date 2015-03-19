<?php

class Application_Model_Thread extends Zend_Db_Table_Abstract
{
    protected $_name = "threads";
    
    function addTread($data,$id){
        $row = $this->createRow();
        $row->threadTitle = $data['threadTitle'];
        $row->threadBody = $data['threadBody'];
        $row->forumID = $id ;
        $row->userID = 1 ;
        return $row->save();
    }
    function listTread(){
        return $this->fetchAll()->toArray();
    }
    function deleteTread($id){
        return $this->delete("threadID=$id");
    }
    function editTread($data,$thid){
//        var_dump($data);
//        var_dump($thid);
//        exit;
        $this->update($data, "threadID=".$thid);
        return $this->fetchAll()->toArray();
    }

    function getTreadById($id){
        return $this->find($id)->toArray();
    }

    
    ////////////////////////////
    
     //select threads where forumid = ay 7aga
   function listThreadsByForumId($id){
        
        return $this->fetchAll('forumID ='.$id)->toArray();
    }
    ///////////////////////////////////////
    //update sticky or lock
    function updateStatus($column,$status,$id){
        
        $data = array($column => $status);
        $this->update($data,'threadID = '.$id);
        return $this->fetchAll()->toArray();   
      }
    
    ///////////////////////////////////////
}
