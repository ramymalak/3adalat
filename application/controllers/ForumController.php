<?php

class ForumController extends Zend_Controller_Action
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
                    }

                }
            }
         
         
         //show forum   
         $this->view->form = $form;    
        
      }
      
      public function homeAction()
        { 
          //send all categories
          $cat_model = new Application_Model_Category();
          $categories=$cat_model->listCategories();
          $this->view->categories = $categories; 
          //send all forums
          $forum_model = new Application_Model_Forum();
          $forums=$forum_model->listForums();
          $this->view->forums = $forums; 
            
        }
        
      public function listallAction()
        { 
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
            $forum_id = $this->_request->getParam("forum_id");

            if(!empty($forum_id)){
                $forum_model = new Application_Model_Forum();
                $forum_model->deleteForum($forum_id);
            }
                $this->redirect("forum/listall");

        }
        
      public function editAction()
    {
        $forum_id= $this->_request->getParam("forum_id");
        $form  = new Application_Form_Forum();
        $form->getElement("forumName")->setRequired(false);
        //$form->getElement("select")->setRequired(false);
        $forum_model = new Application_Model_Forum();
        if(!empty($forum_id)){
                $forum = $forum_model ->getForumById($forum_id);
                $form->populate($forum[0]);
        }else{
                $this->redirect("forum/listall");
        }        
        
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getParams())){
                $forum_info = $form->getValues();
                $forum_model = new Application_Model_Forum();
                $forum_model->editForum($forum_info);
                $this->redirect("Forum/listall");
            }
        
     
        }
        $this->view->form = $form;
	$this->render('add');
    }
     
        
      

///////////////////////////////////////////////////////
}




