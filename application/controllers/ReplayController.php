<?php

class ReplayController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
    
    /////////////////////////////////////////////////
     public function addAction(){
        
         
         $reply= $this->_request->getParam("q");
        if($reply){
            $thread_id= $this->_request->getParam("thread_id");
            $reply_model = new Application_Model_Replay();
            $reply_info=["replayBody"=>$reply,"threadID"=>$thread_id,"userID"=>1];
            $reply_model->addReply($reply_info);
            
            
        }
        

    }

///////////////////////////////////////////////////////////////////
}

