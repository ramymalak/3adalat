<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $this->setAttrib("class", "form-responsive");
        $this->setMethod("post");
        $categoryName = new Zend_Form_Element_Text("categoryName");
        $categoryName->setAttrib("class", "form-control");
        $categoryName->setAttrib("placeholder", "Insert Category Name here");
        $categoryName->setLabel("CategoryName : ");
        $categoryName->setRequired();
        
        $category_id = new Zend_Form_Element_Hidden("categoryID");
        $submit = new Zend_Form_Element_Submit("Submit");
        $submit->setAttrib("class", "btn btn-success");
        
        $reset = new Zend_Form_Element_Reset("Cancel");
        $reset->setAttrib("class", "btn btn-danger");
        
        $this->addElements(array($categoryName,$category_id,$submit,$reset));
    }


}

