<?php

class ThreadsController extends Zend_Controller_Action
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
/////////////////////////////////////////////////////////////////
    public function addAction()
    {
       $forum_id= $this->_request->getParam("forum_id");
       $form  = new Application_Form_Thread();
       $userInfo = Zend_Auth::getInstance()->getStorage()->read();
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $thread_info = $form->getValues();
               $thread_model = new Application_Model_Thread();
               $thread_model->addTread($thread_info,$forum_id,$userInfo->userID);
               $this->redirect("/Forum/listoneforum/forum_id/".$forum_id);
                       
           }
       }
        $this->view->headScript()->appendFile('../../../js/tinymce/tinymce.min.js','text/javascript'); 
	$this->view->form = $form;

    }
  ///////////////////////////////////////////////////////////////////  
    public function listAction()
    {
          //send all categories
          $cat_model = new Application_Model_Category();
          $categories=$cat_model->listCategories();
          $this->view->categories = $categories;
          //send all forums
          $forum_model = new Application_Model_Forum();
          $forums=$forum_model->listForums();
          $this->view->forums = $forums;
          //send all threads
          $thread_model = new Application_Model_Thread();
          $this->view->threads=$thread_model->listTread();
          

    }
    ///////////////////////////////////////////////////////////
     public function deleteAction()
    {
        
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $thread_model = new Application_Model_Thread();
            $thread_model->deleteTread($id);
        }
            $this->redirect("Threads/list/");
      
    }
    //////////////////////////////////////////////////
    public function editAction()
    {
        
        $id = $this->_request->getParam("id");
        $form  = new Application_Form_Thread();
        
        if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $thread_info = $form->getValues();
               //var_dump($thread_info);
               //exit;
               $thread_model = new Application_Model_Thread();
               $thread_model->editTread($thread_info,$id);
               
                       
           }
        }
        if(!empty($id)){
            $thread_model = new Application_Model_Thread();
            $thread = $thread_model->getTreadById($id);
            //var_dump($user);
            
            $form->populate($thread[0]);
        } else{
            $this->redirect("Threads/list/");
        }
        
       
       $this->view->headScript()->appendFile('../../../js/tinymce/tinymce.min.js','text/javascript');
        $this->view->form = $form;
	$this->render('add');
    }
    /////////////////////////////////////////////////
    public function statusAction()
    {
        $id = $this->_request->getParam("id");
        $column = $this->_request->getParam("column");
        $status=$this->_request->getParam("status");
        if(!empty($column)){
            
            $thread_model = new Application_Model_Thread();
            
            $thread_model->updateStatus($column,$status,$id);

        }
            $this->redirect("Threads/list/");
      
    }
    /////////////////////////////////////////////////
        public function listonethreadAction()
        {
            $thread_id= $this->_request->getParam("thread_id");
            $thread_model = new Application_Model_Thread();
            $thread=$thread_model->getTreadById($thread_id);
            $this->view->thread = $thread;


            $reply_model = new Application_Model_Replay();
            $reply=$reply_model->listRepliesByThreadId($thread_id);
            $this->view->reply = $reply;

        } 
    
    
    /////////////////////////////////////////////////
}
