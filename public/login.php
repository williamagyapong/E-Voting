<?php
 session_start();

 require_once '../core/init.php';
 auth();

 //require("config.php");

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
	  <div style="height: 400px; padding: 0 30% 0 30% ;margin-top: 70px;" >
	  	<?php

	 if(isset($_POST['submit'])) {
	 	 if(empty($_POST['id'])) {
	 	 	echo "<h3>Please enter your voter's id</h3>";
	 	 } else{
	 	 	//$firstname =$_POST['firstname'];
	 	 	$id = $_POST['id'];

	 	 	$sql ="SELECT * FROM `voters` WHERE  `voterid` = '$id'";
	 	 	$result =mysql_query($sql);
	 	 	$numrow =mysql_num_rows($result);
	 	 	  if($numrow ==1) {
	 	 	  	$row =mysql_fetch_assoc($result);
	 	 	  	  if ($row['status']==1) {
	 	 	  	  	 echo "<font size='6' color='ff0000'>"."Sorry, you have already voted"."</font>";
	 	 	  	  }else {
	 	 	  	 
	 	 	  	$_SESSION['USERNAME'] =$row['firstname'];
	 	 	  	$_SESSION['user-id'] = $row['id'];
	 	 	  	$_SESSION['ID'] =$row['voterid'];

	 	 	  	if ($_SESSION['ID']==TRUE) {
	 	 	  		$query ="SELECT id FROM voters WHERE voterid='".$_SESSION['ID']."'
	 	 	  		 AND status='0'";
		 $re =mysql_query($query);
		 $voterrow = mysql_fetch_assoc($re);

		 $query2 ="SELECT voter_id FROM voting WHERE voter_id=".$voterrow['id'];
		 $re2 = mysql_query($query2);
		 $numrows = mysql_num_rows($re2);

		 $query3 = "SELECT id FROM offices";
		 $re3 = mysql_query($query3);
		 $numrows2 = mysql_num_rows($re3);

		          if ($numrows==$numrows2) {
		          
		             header("Location: summary.php");
		          }  
		          elseif($numrows!=$numrows2&& $numrows!=0){
	 	 	  	header("Location: voting.php?continue");
	 	 	    }
	 	 	    elseif($numrows==0){
	 	 	    	$id = $_SESSION['user-id'];
	 	 	      header("Location: voting.php?id=$id");
	 	 	    }
	 	 	} else {
	 	 		//header("Location: login.php");
	 	 	}

	 	         }  	 	  
	 	     } else{
	 	 	  	    echo "Incorrect voter id";
	             }
	          }   
	 }

	?>

      <div>
      	
	      </div>
		     <!-- <h2>Log in with your voter id to begin voting</h2>
	<hr> -->
		<form action="" method="POST">
			
			<input type="text" name="id" class=" name_input" placeholder="Please enter your voterid here" autocomplete="off" autofocus required><br><br><br>
			<input type="submit" name="submit" value="LOGIN" class="name_input" style="color: #fff;background: #0000ff;font-weight: bold;">
		</form>
		  </div>

	</div>

  <?php
  require_once 'includes/footer.php';
?>
 </body>
 </html>