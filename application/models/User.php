<?php


class Application_Model_User extends Zend_Db_Table_Abstract
{
    // Define table name
    protected $_name= 'users';
    
    /**
     * addUser() is a function that used to add new user to the database
     * often used in registeration process .
     * @author Mohamed Ramadan
     * @param array $data
     * @return int number of affected rows
     */
    function addUser($data){
        
        
        
        // send email with user data to his email address
        $currentFilePath = dirname(realpath(__FILE__));
        set_include_path($currentFilePath . '/../../library/' . PATH_SEPARATOR . get_include_path());
        
        require_once 'Zend/Mail.php';
        require_once 'Zend/Mail/Transport/Smtp.php';
        
        $smtpServer = 'smtp.gmail.com';
        $username = '3adalatforum@gmail.com';
        $password = '3adalatadmin';
        
        $config = array('ssl' => 'tls',
                'auth' => 'login',
                'username' => $username,
                'password' => $password);
        $transport = new Zend_Mail_Transport_Smtp($smtpServer, $config);
        $mail = new Zend_Mail();

        $mail->setFrom('mramadan181291@gmail.com', '3adalat team');
        $mail->addTo($data["email"], $data["username"]);
        $mail->setSubject('3adalat register success !');
        $mail->setBodyText("Your personal data on 3adalat.net is : "."\n"
                . "User name:".$data["username"]."\n"
                . "Mail address: ".$data["email"]."\n"
                . "Gender: ".$data["gender"]."\n"
                . "Country: ".$data["country"]."\n"
                . "Thanks for join 3adalat :) ");
        $mail->send($transport);
        
        // print the default photo
        echo "<img src='img/default.jpeg' width='100px' height='100px' /> ";
        
        
        
        // Save to database
        $row = $this->createRow();
        $row -> userName  = $data["username"];
        $row -> userEmail = $data["email"];
        $row -> password  = md5($data["password"]);
        $row -> gender    = $data["gender"];
        $row -> country   = $data["country"];
        $row -> photo     = "public/img/".$data["photo"];
        return $row->save();
        
        
        
        
        
        
        
        
        
        
        /*
        $mail = new Zend_Mail();
        $mail->setFrom("mramadan181291@gmail.com");
        $mail->addTo($data["email"]);
        $mail->setSubject("3adalat registeration Success !");
        $mail->setBodyText(
                  "Your personal data on 3adalat.net is : "."\n"
                . "user name:".$data["username"]."\n"
                . "email address".$data["email"]."\n"
                . "gender".$data["gender"]."\n"
                . "country".$data["country"]."\n"
                . "Thanks for join 3adalat :) ");
        $mail->send();
        */
    }


}

