<?php

class ReplayController extends Zend_Controller_Action
{

    public function init()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') 
            { $this->redirect("user/login"); }
    }

    public function indexAction()
    {
        // action body
    }
    
    /////////////////////////////////////////////////
     public function addAction(){
        
         
         $reply= $this->_request->getParam("q");
         $userInfo = Zend_Auth::getInstance()->getStorage()->read();
        if($reply){
            $thread_id= $this->_request->getParam("thread_id");
            $reply_model = new Application_Model_Replay();
            $reply_info=["replayBody"=>$reply,"threadID"=>$thread_id,"userID"=>($userInfo->userID)];
            $reply_model->addReply($reply_info);
                      
            
        }
        

    }

///////////////////////////////////////////////////////////////////
    
   public function deleteAction()
    {
        $thread_id = $this->_request->getParam("thread_id");
        $reply_id = $this->_request->getParam("reply_id");
        if(!empty($reply_id)){
            $reply_model = new Application_Model_Replay();
            $reply_model->deleteReply($reply_id);
        }
        $this->redirect("/Threads/listonethread/thread_id/".$thread_id);
      
    }
    

    
    
 //////////////////////////////////////////////////////////////////   
}

