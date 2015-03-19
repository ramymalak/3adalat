<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
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

    public function listAction()
    {
        // action body
        $user_model = new Application_Model_User();
        $this->view->users = $user_model->listUsers();
    }

    public function deleteAction()
    {
        // action body
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->deleteUser($id);
        }
    }

    public function editAction()
    {
        // action body
        $userID = $this->_request->getParam("userID");
        $form  = new Application_Form_Signup();
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               $user_model = new Application_Model_User();
               $user_model->editUser($user_info);
               
                       
           }
        if(!empty($userID)){
            $user_model = new Application_Model_User();
            $user = $user_model->getUserById($userID);
            var_dump($user);
            
            $form->populate($user[0]);
        } else
            $this->redirect("user/list");
        
        
       }
       $form->getElement("password")->setRequired(false);
        $this->view->form = $form;
	$this->render('add');
    }


}









