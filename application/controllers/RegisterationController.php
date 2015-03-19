<?php

class RegisterationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function signupAction()
    {
        // action body
	$form = new Application_Form_Signup();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               echo"for is valid and post";
               $user_model = new Application_Model_User();
               $user_model->addUser($user_info);
                       
           }
       }
       
	$this->view->form = $form;
		
    }

    // this is my func
    // this is my awesome func
    public function adduserAction()
    {
        // action body
        $form  = new Application_Form_Signup();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               echo"for is valid and post";
               $user_model = new Application_Model_User();
               $user_model->addUser($user_info);
                       
           }
       }
       
	$this->view->form = $form;
    }


}





