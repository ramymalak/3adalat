<?php

class ThreadsController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
        //ay kalma
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
       $form  = new Application_Form_Thread();
       
       if($this->_request->isPost()){
           if($form->isValid($this->_request->getParams())){
               $thread_info = $form->getValues();
               $thread_model = new Application_Model_Thread();
               $thread_model->addTread($thread_info);
                       
           }
       }
        $this->view->headScript()->appendFile('/3adalat/public/js/tinymce/tinymce.min.js','text/javascript'); 
	$this->view->form = $form;

    }
    public function listAction()
    {
          $thread_model = new Application_Model_Thread();
          $this->view->threads=$thread_model->listTread();

    }
     public function deleteAction()
    {
        
        $id = $this->_request->getParam("id");
        if(!empty($id)){
            $thread_model = new Application_Model_Thread();
            $thread_model->deleteTread($id);
        }
            $this->redirect("Threads/list");
      
    }
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
            $this->redirect("Threads/list");
        }
        
       
       $this->view->headScript()->appendFile('/3adalat/public/js/tinymce/tinymce.min.js','text/javascript');
        $this->view->form = $form;
	$this->render('add');
    }

}
