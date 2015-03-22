<?php

class Application_Form_Reply extends Zend_Form
{

    public function init()
    {
        $replyBody = new Zend_Form_Element_Textarea("repalyBody");
        $replyBody->setOptions(array('cols' => '40', 'rows' => '4'));
        $replyBody->setLabel("Comment : ")
                    ->setRequired();
        
        $thread_Id = new Zend_Form_Element_Hidden("threadID");
        $reply_Id = new Zend_Form_Element_Hidden("replayID");
        $user_Id = new Zend_Form_Element_Hidden("userID");
        $submit = new Zend_Form_Element_Submit("Add Commment");
        //$submit->setAttrib("class", "col-sm-offset-4 btn btn-success");
        $this->addElements(array($replyBody,$submit,$thread_Id,$reply_Id,$user_Id ));

    }


}

