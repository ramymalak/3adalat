<?php

class Application_Form_Category extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");
        $categoryName = new Zend_Form_Element_Text("categoryName");
        $categoryName->setAttrib("class", "form-control");
        $categoryName->setLabel("CategoryName : ");
        $categoryName->setRequired();
        
        $category_id = new Zend_Form_Element_Hidden("categoryID");
        $submit = new Zend_Form_Element_Submit("submit");
        $this->addElements(array($categoryName,$category_id,$submit));
    }


}

