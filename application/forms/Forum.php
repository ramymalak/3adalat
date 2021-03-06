<?php

class Application_Form_Forum extends Zend_Form
{

    public function init()
    {
        $this->setAttrib("class", "form-horizontal");
        $this->setMethod("post");
        $forumName = new Zend_Form_Element_Text("forumName");
        $forumName ->setAttrib("class", "form-control");
        $forumName ->setLabel("Forum Name : ");
        $forumName ->setRequired();
        
        $category = new Zend_Form_Element_Select("category");
        $category ->setAttrib("class", "form-control");
        $category ->setLabel("Category Name : ");
        $category ->setRequired();
        
        
        $category_id = new Zend_Form_Element_Hidden("categoryID");
        $forumID = new Zend_Form_Element_Hidden("forumID");
        
        $submit = new Zend_Form_Element_Submit("Save");
        $submit->setAttrib("class", "btn btn-success");
        $submit->setAttrib("id", "savebtn");
        
        $reset = new Zend_Form_Element_Reset("Cancel");
        $reset->setAttrib("class", "btn btn-danger");
        $reset->setAttrib("id", "cancelbtn");
        $this->addElements(array($forumName,$category,$submit,$reset,$forumID,$category_id));
    }


}

