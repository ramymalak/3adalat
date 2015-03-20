<?php

class Application_Form_Login extends Zend_Form
{

    
    public function init()
    {
              
        $email = new Zend_Form_Element_Text("userEmail");
        $email->setRequired()
                ->setLabel("Email:")
                ->setAttrib("class", "form-control")
                ->addValidator(new Zend_Validate_EmailAddress());

         
         $password = new Zend_Form_Element_Password("password");
         $password->setRequired()
                 ->setAttrib("class", "form-control")
                 ->setLabel("Password:");
         
        
         $submit = new Zend_Form_Element_Submit("Log in");
         $submit-> setAttrib("class", "btn btn-success");
         $reset =new Zend_Form_Element_Reset("Reset");
         $reset->setAttrib("class", "btn btn-danger");
         $this->addElements(array($email,$password,$submit,$reset));
        
        
    }



}

