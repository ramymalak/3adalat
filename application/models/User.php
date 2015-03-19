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

        $mail->setFrom('3adalatforum@gmail.com', '3adalat team');
        $mail->addTo($data["userEmail"], $data["userName"]);
        $mail->setSubject('3adalat register success !');
        $mail->setBodyText("Your personal data on 3adalat.net is : "."\n"
                . "User name:".$data["userName"]."\n"
                . "Mail address: ".$data["userEmail"]."\n"
                . "Gender: ".$data["gender"]."\n"
                . "Country: ".$data["country"]."\n"
                . "Thanks for join 3adalat :) ");
        $mail->send($transport);
        
        // print the default photo
        //echo "<img src='img/default.jpeg' width='100px' height='100px' /> ";
        
        
        
        // Save to database
        $row = $this->createRow();
        $row -> userName  = $data["userName"];
        $row -> userEmail = $data["userEmail"];
        $row -> password  = md5($data["password"]);
        $row -> gender    = $data["gender"];
        $row -> country   = $data["country"];
        $row -> photo     = "public/img/".$data["photo"];
        return $row->save();
    }


    function listUsers(){
        
        return $this->fetchAll()->toArray();
    }
    
    
    function getUserById($userID){
        return $this->find($userID)->toArray();
    }
    
    
     function editUser($data,$theid){
         
        if(empty($data['photo'])){
            unset ($data['photo']);
        }
         
        if(!empty($data['password'])){
            if($data['password']==$data['passwordConfirm']){
                $data['password']=md5($data['password']);
                unset ($data['passwordConfirm']);
                
            }else{
                return 1;
            }
            
        }else{
            unset ($data['password']);
            unset ($data['passwordConfirm']);
        }
        $this->update($data, "userID=".$theid);
        return $this->fetchAll()->toArray();
    }
    
    
    function deleteUser($userID){
        
        return $this->delete("userID=$userID");
    }

    
    
    
    
}

