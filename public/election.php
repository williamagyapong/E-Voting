<?php
 require '../core/init.php';
 if(isset($_POST['create']))
 {
 	if(createElection())
 	{

 	}
 }
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Create election</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php
      require 'includes/header.php';
    ?>
  
    <div class="container-fluid">
      <div class="wrapper">
         <div>
         	<?php 
               if(isset($_POST['create']))
               {
               	  if(createElection())
               	  {
               	  	 echo "Election has been successfully created.";
               	  } else {
               	  	 echo "Sorry, could not create election.";
               	  }
               }
         	?>
         </div>
      	  <form role="form" action="election.php" method="post">
         <fieldset class="fieldset">
         	<legend>Create Election</legend>

         	<div class="form-group">
       	   
       	   <input type="text" name="name" class="form-control" placeholder="Enter name" autofocus="true" required="required">
       	 </div>
       	 <div class="form-group">
       	   
       	   <input type="text" name="institute" class="form-control" placeholder="Enter institution" autofocus="true" required="required">
       	 </div>
       	 <button type="submit" name="create" class="btn btn-default">Create</button>
         </fieldset>
       	 
       </form>
      </div>
       
    	
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!-- currently disabled: activate by replacing #activate with #response -->
    <script type="text/javascript" src = "js/jquery-2.1.4.min.js"></script>
      <script type="text/javascript" src = "js/time.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    </script>
    <?php require'includes/footer.php'; ?>
  </body>
</html>