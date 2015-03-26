<?php

class UserController extends Zend_Controller_Action
{

    public function init()
    {
        
//        $authorization =Zend_Auth::getInstance(); 
//        if(!$authorization->hasIdentity() && $this->_request->getActionName()!='login') 
//            { $this->redirect("user/login"); }
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
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
        // action body
        $user_model = new Application_Model_User();
        $this->view->users = $user_model->listUsers();
    }
    
     public function profileAction()
    {
         // action body(
         $userInfo = Zend_Auth::getInstance()->getStorage()->read();
         
         function objectToArray($d){
                if (is_object($d)){
                    $d = get_object_vars($d);
                    return $d;
                }       
            }
         
         $userInfoArray = objectToArray($userInfo);   
         $userId = $userInfoArray['userID'];
  
         $user_model = new Application_Model_User();
         $this->view->user=$user_model->listOneUser($userId);
         
    }

    public function profileotherAction()
    {
         // action body(
  
        $userId= $this->_request->getParam("userId"); 
        $user_model = new Application_Model_User();
        $this->view->user=$user_model->listOneUser($userId);
        $this->render('profile');
         
    }

    
    
    
    
    public function deleteAction()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
        // action body
        $id = $this->_request->getParam("userID");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->deleteUser($id);
            
        }
        $this->redirect("user/list");
    }

    public function banAction()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
        // action body
        $id = $this->_request->getParam("userID");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->invbanUser($id);
            
        }
        $this->redirect("user/list");
    }

    public function adminAction()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
        // action body
        $id = $this->_request->getParam("userID");
        if(!empty($id)){
            $user_model = new Application_Model_User();
            $user_model->invadminUser($id);
            
        }
        $this->redirect("user/list");
    }

    public function editAction()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
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
               $user = Zend_Auth::getInstance()->getStorage()->read();
              if($user_info['userID']==$user->userID){
               $user->userName=$user_info['userName'];
               if(!empty($user_info['photo'])){
                   unlink('/var/www/html/3adalat/public'."/forum/".$user->photo);
                   $user->photo=$user_info['photo'];
               }
           }
               
              $this->redirect("user/profile");      
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

    public function loginAction()
    {
        // disable master layout
       $this->_helper->layout->disableLayout();
       $form  = new Application_Form_Signup();
       $form->removeElement("userName");
       $form->removeElement("passwordConfirm");
       $form->removeElement("country");
       $form->removeElement("gender");
       $form->removeElement("photo");
       //$form->removeElement("reset");
       $form->getElement("userEmail")->removeValidator('Db_NoRecordExists');
       $this->view->form = $form;
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $email = $form->getValue("userEmail");
               $password = $form->getValue("password");
               $db =Zend_Db_Table::getDefaultAdapter();
               $auth = new Zend_Auth_Adapter_DbTable($db,'users','userEmail', 'password');
               $auth->setIdentity($email);
               $auth->setCredential(md5($password));
                
               $result = $auth->authenticate();
               if ($result->isValid()) {
                 $autho =Zend_Auth::getInstance();
                 $storage = $autho->getStorage();
                 $storage->write($auth->getResultRowObject(array('userName' , 'photo' , 'isAdmin','isBan','userID')));
                 
                 $system_model = new Application_Model_System();
                 $system=$system_model->checkSystem(); 
                    $userInfo = Zend_Auth::getInstance()->getStorage()->read();
                    if ($userInfo->isAdmin==0){
                        if($system[0]['isLocked']==1){
                            session_destroy();
                           $this->redirect("user/lock"); 
                        }
                          if($userInfo->isBan==1){
                            session_destroy();
                           $this->redirect("user/banuser"); 
                        }

                    }
                 
                 
                 $this->redirect("forum/home");
                      //exit();
                 }else{
                     $this->view->form = $form;
                    }
                       
           }
       }
        
    }

    public function lockAction()
    {
         
    }

      public function banuserAction()
    {
         
    }

    public function logoutAction()
    {
         $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
            { $this->redirect("user/login"); }
         session_destroy();
         $this->redirect("user/login");      
    }
    
    public function sendmsgAction()
    {
        // action body
        $form  = new Application_Form_Message();
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $msg_info = $form->getValues();
               $userInfo = Zend_Auth::getInstance()->getStorage()->read();
               function objectToArray($d){
                    if (is_object($d)){
                        $d = get_object_vars($d);
                        return $d;
                       }       
                   }
                $userInfoArray = objectToArray($userInfo);   
                $senderId = $userInfoArray['userID'];
                $userModel = new Application_Model_User();
                $recieverId = $userModel->getUserIdByName($msg_info['messageReviever']);
                $body  =  $msg_info['messageBody'];
                $msg_model = new Application_Model_Message();
                $msg_model->sendMessage($senderId, $recieverId, $body);
           }
       }
	$this->view->form = $form;     
    }  
    
    public function listmsgAction()
    {
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();
               function objectTooArray($d){
                    if (is_object($d)){
                        $d = get_object_vars($d);
                        return $d;
                       }       
                   }
                $userInfoArray = objectTooArray($userInfo);   
                $userId = $userInfoArray['userID'];
        $message_model = new Application_Model_Message();
        $message_model->setSeen();
        $message_model->checkForSeen();
        $this->view->data = $message_model->listMessages($userId);    
    }
    
    public function seenAction()
    {
        $authorization =Zend_Auth::getInstance(); 
        if(!$authorization->hasIdentity()) 
        {
            $this->redirect("user/login"); 
        }
        $msgid = $this->_request->getParam("msgID");
        if(!empty($msgid)){
            $msg_model = new Application_Model_Message();
            $msg_model->invseen($msgid);      
        }
        $this->redirect("user/listmsg");
    }
    
    public function unseenAction()
    {
        $msg_model = new Application_Model_Message();
        $result = $msg_model->checkForSeen();
        $this->redirect("Forum/home/seen/$result");   
    }
}