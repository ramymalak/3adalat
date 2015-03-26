<?php

class Application_Form_Signup extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
	$this->setMethod("post");
        $this->setAttrib("calss", "form form-horizontal");
        
//        $userID = new Zend_Form_Element_Hidden("userID");
//        $userID->setAttrib("value", "9");
        $userID = new Zend_Form_Element_Hidden('userID');
        
	$username = new Zend_Form_Element_Text("userName");
        $username -> setRequired()-> setLabel("Username: ");
        $username -> setAttrib("class", "form-control");
        $username -> setAttrib("placeholder", "Enter your Name");



	$email = new Zend_Form_Element_Text('userEmail');
        $email -> setLabel("Email: ");
        $email -> setAttrib("class", "form-control");
        $email-> setAttrib("placeholder", "you@example.com");
        $email -> setRequired();
        $email -> addValidator(new Zend_Validate_EmailAddress());


	$password = new Zend_Form_Element_Password("password");
        $password->setRequired()-> setLabel("Password");
        $password -> setAttrib("class", "form-control");
        $password-> setAttrib("placeholder", "Enter your password");

	$passwordConfirm = new Zend_Form_Element_Password("passwordConfirm");
        $passwordConfirm -> setRequired()-> setLabel("Confirm Password:");
        $passwordConfirm -> setAttrib("class", "form-control");
        $passwordConfirm -> setAttrib("placeholder", "Confirm your password");

	$country = new Zend_Form_Element_Select("country");
        $country -> setRequired()-> setLabel("Country: ");
        $country -> setAttrib("class", "form-control");
        $country->addMultiOptions(array(
            'Select your country' => 'Select your country',
            'Australia' => 'Australia',
            'Brazil' => 'Brazil',
            'China' => 'China',
            'Danimark' => 'Danimark',
            'Egypt' => 'Egypt',
            'Germany' => 'Germany',
            'France' => 'France',
            'Saudi Arabia' => 'Saudi Arabia',
            'Russia' => 'Russia',
            'United Kingdom' => 'United Kingdom',
            'United States' => 'United States'  
        ));

	$photo = new Zend_Form_Element_File('photo');
	$photo -> setLabel('Upload your photo: ');
	$photo -> setAttrib("class","form-control");
        
        
        $photo->setDestination('/var/www/html/3adalat/public/forum');
        // ensure only one file
        $photo->addValidator('Count', false, 1);
        $thedate = date_create();
        $photo->addFilter('Rename', array('target' => $thedate->format('U = Y-m-d H:i:s')));
        // max 2MB
        $photo->addValidator('Size', false, 2097152)
              ->setMaxFileSize(2097152);
        // only JPEG, PNG, or GIF
        $photo->addValidator('Extension', false, 'jpg,png,gif,jpeg');
        $photo->receive();
        $photo->setValueDisabled(true);
        
        

        $submit = new Zend_Form_Element_Submit('submit');
        $submit -> setAttrib("value", "Submit");
        $submit ->setAttrib("class", "btn btn-success");
        
        $reset = new Zend_Form_Element_Reset("reset");
        $reset-> setAttrib("value", "Cancel");
        $reset ->setAttrib("class", "btn btn-danger");
        
        $gender =new Zend_Form_Element_Radio("gender");
        $gender->setLabel("Gender: ");
        $gender->addMultiOptions(array(
            'Male' => 'Male',
            'Female' => 'Female'
        ));
        
	$this->addElements(array($userID,$username,$email,$password,$passwordConfirm,$country,$gender,$photo,$submit,$reset));
	
    }


}

