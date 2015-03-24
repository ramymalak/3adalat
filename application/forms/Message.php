<?php

class Application_Form_Message extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");
        $this->setAttrib("calss", "form form-horizontal");
        
        $to = new Zend_Form_Element_Select('messageReviever');
        $to->setLabel("To: ");
        $to->setRequired();
        $to->setAttrib("class", "form-control");
        $model = new Application_Model_User();
        $array = $model->listUsers();
        $nameArray = array();
        for ($i=0;$i<count($array);$i++){    
            $nameArray[$array[$i]['userEmail']] = $array[$i]['userEmail'];
            //array_push($nameArray, $array[$i]['userName']);   
        }
        $to->addMultiOptions($nameArray);
        $this->addElement($to);
        
        $body = new Zend_Form_Element_Textarea('messageBody');
        $body->setLabel("Message: ");
        $body->setAttrib("rows", "5");
        $body->setRequired();
        $body->setAttrib("class", "form-control");
        $this->addElement($body);
        
        $submit = new Zend_Form_Element_Submit('Send');
        $submit ->setAttrib("class", "btn btn-success");
        $this->addElement($submit);
        
        $reset = new Zend_Form_Element_Reset("Cancel");
        $reset ->setAttrib("class", "btn btn-danger");
        $this->addElement($reset);
        
    }


}

