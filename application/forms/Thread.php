<?php

class Application_Form_Thread extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $threadTitle = new Zend_Form_Element_Text("threadTitle");
        $threadTitle->setAttrib("class", "form-control");
        $threadTitle->setLabel("Title: "."\n");
        $threadTitle->setRequired();
        $threadTitle->addFilter(new Zend_Filter_StripTags);
     
        
        $threadBody = new Zend_Form_Element_Textarea("threadBody");
        $threadBody->setAttrib('class', 'ckeditor');
        $threadBody->setLabel("Body: "."\n");
         $threadBody->setRequired();
         
         
         
         
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($threadTitle,$threadBody,$submit));
    }


}
