<?php

class CategoryController extends Zend_Controller_Action
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
    ///////////////////////////////////////////////////////
    public function addAction()
      {
            $form  = new Application_Form_Category();
            if($this->_request->isPost()){
                if($form->isValid($this->_request->getParams())){
                    $category_info = $form->getValues();
                    //check if fcategory already in database
                    $flag=0;
                    $cat_model = new Application_Model_Category();
                    $categories=$cat_model->listCategories();
                    for($i = 0; $i<count($categories); $i++){
                        foreach ($categories[$i] as $key=>$value):
                            if($key=="categoryName"){
                                if($value==$category_info['categoryName'])
                                {
                                    echo "Category is already exist";
                                    $flag=1;
                                }
                            }                          
                        endforeach;
                    } 
                    
                    if($flag!=1)
                    {
                        //add Category
                       $cat_model->addCategory($category_info );
                       $this->redirect("category/listall");
                    }
                    
                    
                    
                    

                }
            }
            
         $this->view->form = $form;    
        

      }
    /////////////////////////////////////////////////////  
    public function listonecategoryAction()
    {
        $cat_id = $this->_request->getParam("cat_id");
        $cat_model = new Application_Model_Category();
        $category=$cat_model->getCategoryById($cat_id);
        $this->view->category = $category;
        
        $forum_model = new Application_Model_Forum();
        $forums=$forum_model->listForumsByCategoryId($cat_id);
        $this->view->forums = $forums; 
    }
    ////////////////////////////////////////////
    public function listallAction()
    {  //send all categories
          $cat_model = new Application_Model_Category();
          $categories=$cat_model->listCategories();
          $this->view->categories = $categories;
    }
    ////////////////////////////////////////////
    public function deleteAction()
    {
        $cat_id = $this->_request->getParam("cat_id");

        if(!empty($cat_id)){
            $cat_model = new Application_Model_Category();
            $cat_model->deleteCategory($cat_id);
        }
            $this->redirect("category/listall");
      
    }
    
    //////////////////////////////////
    
    
    
    public function editAction()
    {
        $cat_id= $this->_request->getParam("cat_id");
        $form  = new Application_Form_Category();
        $form->getElement("categoryName")->setRequired(false);
        $cat_model = new Application_Model_Category();
        if(!empty($cat_id)){
                $category = $cat_model->getCategoryById($cat_id);
                $form->populate($category[0]);
        }else{
                $this->redirect("category/listall");
        }        
        
        if($this->_request->isPost()){
            if($form->isValid($this->_request->getParams())){
                $category_info = $form->getValues();
                $cat_model = new Application_Model_Category();
                $cat_model->editCategory($category_info);
                $this->redirect("category/listall");
            }
        
     
        }
        $this->view->form = $form;
	$this->render('add');
    }
     
        
    ///////////////////////////////
}