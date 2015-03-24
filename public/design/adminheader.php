<?php
    $userInfo = Zend_Auth::getInstance()->getStorage()->read();
?>

<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src ="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </head>


    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                        
            </button>
            
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li ><a href="<?php echo $this->baseUrl()?>/Forum/home/">Home</a></li>
                <li><a href="<?php echo $this->baseUrl()?>/user/profile/"> Profile </a></li> 
                <li><a href="<?php echo $this->baseUrl()?>/Category/listall/"> Categories </a></li>
                <li><a href="<?php echo $this->baseUrl()?>/Forum/listall/"> Forums </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/Threads/list/"> Threads </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/Threads/mythread"> My Treads </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/user/list/"> Users </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/user/sendmsg"> send private message </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/chat/index"> Chat </a></li>
            </ul>
            

             <ul class="nav navbar-nav navbar-right">
                <li><a href=""><?php echo $userInfo->userName; ?></a></li>
                <li><img class="image" src='<?php echo $this->baseUrl()."/forum/".$userInfo->photo;?>' width="50px" height="50px"/></li>
                 <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"> <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="<?php echo $this->baseUrl()?>/user/logout/">Log out</a></li>
                    </ul>

                </li>
            </ul>
             
    </nav>
