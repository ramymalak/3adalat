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
        $id = $this->_request->getParam("userID");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->deleteUser($id);
            
        }
        $this->redirect("user/list");
    }

    public function editAction()
    {
        // action body
        $userID = $this->_request->getParam("userID");
        $form  = new Application_Form_Signup();
        $form->getElement("password")->setRequired(false);
        $form->getElement("userEmail")->removeValidator("Db_NoRecordExists");
        $form->getElement("passwordConfirm")->setRequired(false);
        
        if($this->_request->isPost()){
            
           if($form->isValid($this->_request->getParams())){
               $user_info = $form->getValues();
               //var_dump($user_info);
               //exit;
               $user_model = new Application_Model_User();
               $user_model->editUser($user_info,$userID);
               
                    
           }
       }
       if(!empty($userID)){
            $user_model = new Application_Model_User();
            $user = $user_model->getUserById($userID);
            //var_dump($user[0]);
            $form->populate($user[0]);
        } else{
            $this->redirect("user/list");
        }
       
        $this->view->form = $form;
	$this->render('add');
    }


}









