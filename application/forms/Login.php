<?php

class Application_Form_Login extends Zend_Form
{

    
    public function init()
    {
              
        $email = new Zend_Form_Element_Text("userEmail");
         $email->setRequired()
                ->setLabel("Email:")
                 ->addValidator(new Zend_Validate_EmailAddress());

         
         $password = new Zend_Form_Element_Password("password");
         $password->setRequired()
                 ->setLabel("Password:");
         
        
         $submit = new Zend_Form_Element_Submit("submit");
         $this->addElements(array($email,$password,$submit));
        
        
    }



}

