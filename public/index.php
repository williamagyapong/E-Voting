<?php 
session_start();
  require_once'create_db.php';
  require_once '../core/init.php';
  
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
   <title>Admin login</title>
   <link rel="stylesheet" type="text/css" href="css/main.css">

   <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <style type="text/css">
      body{
      margin:0;
      padding: 0;
      background-color: #c0c0c0;
    }

.login-form{
   margin-bottom: 200px;
  /*position: relative; left: 280px;
}*/
    </style>
</head>
<body>
   <?php require'includes/header3.php'; ?>
  <div class="wrapper">
    <?php

      if (isset($_POST['login'])) 
      {

        	if(empty($_POST['username']) || empty($_POST['password'])) {
        		echo "Please both fields are required.";
        	} else{
        		$username =trim($_POST['username']);
        		$password =md5(trim($_POST['password']));

            
        		$sql ="SELECT * FROM `admin` WHERE `username` ='$username' AND `password` ='$password'";
        		$result = mysql_query($sql)or die(mysql_error());
        		$numrow = mysql_num_rows($result);
        		//echo $numrow;die();
        		 if($numrow ==1 ) {
        		 	$row = mysql_fetch_assoc($result);

        		 	$_SESSION['ADMIN'] = $row['username'];
        		 	$_SESSION['ADMINID'] = $row['id'];

        		 	if(isset($_SESSION['ADMIN']/*, $_SESSION['ADMINID']*/))
              {
                header("Location: dashboard.php");
              }
              
        		 } else{
        		 	echo "<h3>Incorrect username or password. Please try again</h3>";
        		 }
        	}

        }  


    ?>

<div class="login-form" style="height: 400px; padding: 0 25% 0 25% ;margin-top: 60px;">
<h2>Sign in as an administrator</h2>

<form action="index.php" method="POST">
    
      
         <br>
         <input type="text" name="username" class=" name_input" autocomplete="off" autofocus required placeholder="Username"><br>
      
      
         <br>
         <input type="password" name ="password" class=" name_input" autocomplete="off" autofocus required placeholder="Password"><br><br>
      
      
         
         <input type="submit" name="login" value="LOGIN" class=" name_input" style="color: #fff;background: #0000ff;font-weight: bold;">
         
      
</form>
</div>
</div>
  <?php
  require_once 'includes/footer.php';
?>
</body>
</html>