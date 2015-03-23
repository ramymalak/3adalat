<?php

class Application_Model_System extends Zend_Db_Table_Abstract
{
   protected $_name = "system";
   
   function checkSystem(){
        return $this->fetchAll()->toArray();
    }
    
    ///////////////
    //update system status
     function updateStatus(){
         $system=$this-> checkSystem() ;
           if($system[0]['isLocked']==1){
               $data = array("isLocked" => 0); 
            }else{
               $data = array("isLocked" => 1);  
            }
        $this->update($data);
        return $this->fetchAll()->toArray();   
      }

}
