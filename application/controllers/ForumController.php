<?php

class ForumController extends Zend_Controller_Action
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
    
//amany    
     public function addAction()
      {
         //allow this page only for admin
         $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }
         
        //get all categories  
        $allCategories=array(); 
        $cat_model = new Application_Model_Category();
        $result=$cat_model->listCategories();
        
        //add categories into combo box 
        $form  = new Application_Form_Forum();
        for($i = 0; $i<count($result); $i++){
            foreach ($result[$i] as $key=>$value):
                 $form->getElement("category")->addMultiOption($i,$value);
                 $allCategories[$i]=$value;
            endforeach;
         }
         
         //if post 
         if($this->_request->isPost()){
                if($form->isValid($this->_request->getParams())){
                    $forum_info = $form->getValues();
                    //check if forum already in database
                    $flag=0;
                    $forum_model = new Application_Model_Forum();
                    $forums=$forum_model->listForums();
                    for($i = 0; $i<count($forums); $i++){
                        foreach ($forums[$i] as $key=>$value):
                            if($key=="forumName"){
                                    if($value==$forum_info['forumName'])
                                    {
                                        echo "Forum is already exist";
                                        $flag=1;
                                    }
                            }                          
                        endforeach;
                    } 
                    
                    if($flag!=1)
                    {
                        //get id of category
                        $cat_id=$cat_model->getCategoryId($allCategories[$forum_info['category']]);
                        foreach ($cat_id[0] as $key=>$value):
                        $id=$value;
                        endforeach;
                        //add forum
                        $forum_model->addForum($forum_info['forumName'],$id);
                        $this->redirect("/category/listonecategory/cat_id/".$id);
                    }

                }
            }
         
         
         //show forum   
         $this->view->form = $form;    
        
      }
      
      public function homeAction()
        { 
          $system_model = new Application_Model_System();
          $system=$system_model->checkSystem();
          $this->view->system= $system; 
          //send all categories
          $cat_model = new Application_Model_Category();
          $categories=$cat_model->listCategories();
          $this->view->categories = $categories; 
          //send all forums
          $forum_model = new Application_Model_Forum();
          $forums=$forum_model->listForums();
          $this->view->forums = $forums;
          
         
          $thread_model = new Application_Model_Thread();
          for($i = 0; $i<count($forums); $i++){
            $thread=$thread_model->selectNewestThread($forums[$i]['forumID']);
            if ( $thread!=NULL){
                $threads[] =$thread;
            }
          }
         $this->view->threads = $threads;          
     
          
           
            
        }
        
      public function listallAction()
        { 
          //allow this page only for admin
          $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }
          
          //send all categories
          $cat_model = new Application_Model_Category();
          $categories=$cat_model->listCategories();
          $this->view->categories = $categories;
          //send all forums
          $forum_model = new Application_Model_Forum();
          $forums=$forum_model->listForums();
          $this->view->forums = $forums; 
        }
        
     public function deleteAction()
        {
         //allow this page only for admin
         $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }
         
         
            $forum_id = $this->_request->getParam("forum_id");

            if(!empty($forum_id)){
                $forum_model = new Application_Model_Forum();
                $forum_model->deleteForum($forum_id);
            }
                $this->redirect("forum/listall");

        }
        
      public function editAction()
    {
        //allow this page only for admin  
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }  
          
        $forum_id= $this->_request->getParam("forum_id");
        $form  = new Application_Form_Forum();
        $form->getElement("forumName")->setRequired(false);
        //$form->getElement("select")->setRequired(false);
        
        //data about this forum
        $forum_model = new Application_Model_Forum();
        $forum = $forum_model ->getForumById($forum_id);
        $cat_model = new Application_Model_Category();
        $selected_category=$cat_model->getCategoryById($forum[0]['categoryID']);
        
        //add categories into combo box 
        $result=$cat_model->listCategories();
        for($i = 0; $i<count($result); $i++){
            foreach ($result[$i] as $key=>$value):
                if($key=="categoryName"){
                    $form->getElement("category")->addMultiOption($result[$i]['categoryID'],$value);
                    if($value==$selected_category[0]['categoryName'])
                    {
                     $form->getElement("category")->setValue($result[$i]['categoryID']);   
                    }
                }    
             endforeach;
         }
            
        
        if(!empty($forum_id)){
                $form->populate($forum[0]);
        }else{
                $this->redirect("forum/listall");
        }        
        
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getParams())){
                $forum_info = $form->getValues();
                $forum_model = new Application_Model_Forum();
                $forum_model->editForum($forum_info,$forum_info['category']);
                $this->redirect("Forum/listall");
            }
        
     
        }
        $this->view->form = $form;
	$this->render('add');
    }
     
        
      

///////////////////////////////////////////////////////
    
    public function listoneforumAction()
    {
        $forum_id= $this->_request->getParam("forum_id");
        $forum_model = new Application_Model_Forum();
        $forum=$forum_model->getForumById($forum_id);
        $this->view->forum = $forum;
        
       
        $thread_model = new Application_Model_Thread();
        $threads=$thread_model->listThreadsByForumId($forum_id);
        $this->view->threads = $threads;
     
    } 
    
    
    
    /////////////////////////////////////////////////
    public function statusAction()
    {
        //allow this page only for admin
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }
        
        $id = $this->_request->getParam("id");
        $column = $this->_request->getParam("column");
        $status=$this->_request->getParam("status");
        if(!empty($column)){
            
        $forum_model = new Application_Model_Forum();
            
          $forum_model->updateStatus($column,$status,$id);

        }
            $this->redirect("Forum/listall");
      
    }
    /////////////////////////////////////////////////
    
    public function systemstatusAction()
    {
        $userInfo = Zend_Auth::getInstance()->getStorage()->read();
          if(!$userInfo->isAdmin){
              $this->redirect("forum/home");
          }
        
       $system_model = new Application_Model_System();
       $system_model->updateStatus();
       $this->redirect("Forum/home");
    }
    
    
}




