<?php

class ReplayController extends Zend_Controller_Action
{

    public function init()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') 
            { $this->redirect("user/login"); }
            
        $ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('add', 'html')->initContext();
//        $contextSwitch=$this->_helper->getHelper('contextSwitch');
//        $contextSwitch->setActionContext('add');
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
            $mod=$reply_model->addReply($reply_info);
            //var_dump($mod);
            echo $mod;
            //$this->view->thedata="hamdaa";
            
            
            
        }
        

    }
    
//    /replay/delete/id/
    public function deleteAction()
    {
        $theid= $this->_request->getParam("id");
        $reply_model = new Application_Model_Replay();
        $reply_model->deleteReply($theid);
        
        // action body
    }
    public function editAction()
    {
        $theid= $this->_request->getParam("id");
        $newcom= $this->_request->getParam("newval");
        $reply_model = new Application_Model_Replay();
        $reply_model->editReply($theid,$newcom);
        
        // action body
    }

///////////////////////////////////////////////////////////////////
}

