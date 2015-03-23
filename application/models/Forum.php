<?php

class Application_Model_Forum extends Zend_Db_Table_Abstract
{
   protected $_name = "forums";
    //add a new forum
    function addForum($data,$id){
        $row = $this->createRow();
        $row->forumName= $data;
        $row->categoryID = $id;
        return $row->save();
    }
    
    //get all forums
    function listForums(){
        return $this->fetchAll()->toArray();
    }
    
    //select forums where categoryid = ay 7aga
   function listForumsByCategoryId($id){
        
        return $this->fetchAll('categoryID='.$id)->toArray();
    }
    
    //get forum by id
    function getForumById($id){
        return $this->find($id)->toArray();
    }
    
    //delete forum
    function deleteForum($id){
        return $this->delete("forumID =$id");
    }
    //edit forum
    function editForum($data,$categoryID){
              
      unset ($data['category']);  
        
      if(!empty($data['forumName']))
            $data['forumName']=$data['forumName'];
        else
            unset ($data['forumName']);     
           
        $data['categoryID']=$categoryID;
              
       if(!empty($data['forumID']))
            $data['forumID']=$data['forumID'];
        else
            unset ($data['forumID']);  
        
     if(!empty($data['isLocked']))
            $data['isLocked']=$data['isLocked'];
        else
            unset ($data['isLocked']);
        
        
        $this->update($data, "forumID=".$data['forumID']);
        return $this->fetchAll()->toArray();
    }
       ///////////////////////////////////////
    //update sticky or lock
    function updateStatus($column,$status,$id){
        
        $data = array($column => $status);
        $this->update($data,'forumID = '.$id);
        return $this->fetchAll()->toArray();   
      }
    
    ///////////////////////////////////////
    
}

