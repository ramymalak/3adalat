<?php

class ChatController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') 
            { $this->redirect("user/login"); }
    }

    public function indexAction()
    {
        // action body
//        var_dump($_SESSION["Zend_Auth"]['storage']->userName);
//        exit;
        $this->view->username=$_SESSION["Zend_Auth"]['storage']->userName;
    }


}

