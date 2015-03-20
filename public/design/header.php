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
                <li class="active"><a href="<?php echo $this->baseUrl()?>/Forum/home/">Home</a></li>
                <li><a href="<?php echo $this->baseUrl()?>/Category/listall/"> Categories </a></li>
                <li><a href="<?php echo $this->baseUrl()?>/Forum/listall/"> Forums </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/Threads/list/"> Threads </a></li>
               <li><a href="<?php echo $this->baseUrl()?>/user/logout/"> Logout </a></li>

            </ul>
            
             
    </nav>
</html>