<?php

class Application_Model_Category extends Zend_Db_Table_Abstract
{
    protected $_name = "categories";
    
    function listCategories(){
        return $this->fetchAll()->toArray();
    }
    
    function addCategory($data){
        $row = $this->createRow();
        $row->categoryName = $data['categoryName'];
        return $row->save();
    }
    
    function getCategoryId($name){
        $query =  $this->select()->from($this,array('categoryID'))->where('categoryName = ?', $name);
        return $this->fetchAll($query)->toArray();
    }
    
    function getCategoryById($id){
        return $this->find($id)->toArray();
    }
    
    function deleteCategory($id){
        return $this->delete("categoryID=$id");
    }
    
    function editCategory($data){
      if(!empty($data['categoryName']))
            $data['categoryName']=$data['categoryName'];
        else
            unset ($data['categoryName']);
        
           
      if(!empty($data['categoryID']))
            $data['categoryID']=$data['categoryID'];
        else
            unset ($data['categoryID']);
        
        $this->update($data, "categoryID=".$data['categoryID']);
        return $this->fetchAll()->toArray();
    }
    

}

