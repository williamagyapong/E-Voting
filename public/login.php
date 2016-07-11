<?php

 require_once '../core/init.php';
 auth();//prevents unauthorized users
 

?>
<!DOCTYPE html>
<html>
 <head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="css/main.css">
     <style type="text/css">
      body{
      margin:0;
      padding: 0;
      background-color: #c0c0c0;
    }
    </style>
   <body>
   <?php require'includes/header3.php'; ?>
	 <div class="wrapper"> 
	   <?php if(electionSelected()):
        
	   ?>
	   	
	  <div style="height: 400px; padding: 0 30% 0 30% ;margin-top: 70px;" >
	  	<?php

	 if(isset($_POST['login'])) {
         //handle voter log in
	 	 voterLogin();
	 }

	?>

      <div>
      	
	      </div>
		     <!-- <h2>Log in with your voter id to begin voting</h2>
	<hr> -->
		<form action="" method="POST">
			
			<input type="text" name="id" class=" name_input" placeholder="Please enter your voterid here" autocomplete="off" autofocus required><br><br><br>
			<input type="submit" name="login" value="LOGIN" class="name_input" style="color: #fff;background: #0000ff;font-weight: bold;">
		</form>
		  </div>
     
     <?php else:?>
       <h2>You haven't selected any election!</h2>
     <?php endif;?>

	</div>

  <?php
  require_once 'includes/footer.php';
?>
 </body>
