<?php 
session_start();
 require_once '../core/init.php';
 require_once'create_db.php';
 auth();
?>
<!DOCTYPE html>
<html>
   <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>dashboard</title>
     <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <style type="text/css">
    	li{
    		font-weight: bold;
    		font-size: 18px;
    	}
    </style>
   </head>
   <body>
   	 <?php 
    require_once 'includes/header3.php';
    
  ?>
 <div class="wrapper">
    <nav class="navbar navbar-default" role="navigation">
    	<div class="container-fluid">
    		
    		<ul class="nav navbar-nav">
    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Create<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="#">Election</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="office.php">Offices</a></li>
    		  	  </ul>
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Register<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="candregister.php">Candidates</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="register.php">Voters</a></li>
    		  	  </ul>
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Display<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="viewoffice.php">Offices</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="candidates.php">Candidates</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="voters.php">Voters</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="results.php">Results</a></li>
    		  	  	
    		  	  </ul>
    		  </li>

    		  <li><a href="login.php" target="_blank">Voting Section</a></li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Settings<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="reset.php">Reset Election</a></li>
    		  	  	<li class="divider"></li>

    		  	  	<li><a href="#">Select Election</a></li>
    		  	  	<li class="divider"></li>
    		  	  	
    		  	  </ul>
    		  </li>

    		  <li class="dropdown">
    		  	<a href="#" class="dropdown n-toggle" data-toggle="dropdown" role="button" area-expanded="false">Administrator<span class="caret"></span></a>
    		  	  <ul class="dropdown-menu" role="menu">
    		  	  	<li><a href="adminlogout.php">Logout</a></li>
    		  	  	<li class="divider"></li>
    		  	  	<li><a href="#">Change Password</a></li>
    		  	  </ul>
    		  </li>

    			
    		</ul>
    	</div>
    </nav>
   
 </div>

<?php
//require("create_db.php");
require_once 'includes/footer.php';
?>


    <script type="text/javascript" src = "js/jquery-2.1.4.min.js"></script>
    
    <script src="js/bootstrap.min.js"></script>
</body>
</html>