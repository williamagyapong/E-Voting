<?php
session_start();
require_once '../core/init.php';
auth2();
//require("config.php");

//make a call to get offices function
 $offices = getOffices();
 $voter = getVoter()[0];
 $numVoted = $voter['votingstatus'];
 $numOffices = count($offices);

 //accepts votes and indicates that current user has voted
 if(isset($_POST['confirm'])|| ($voter['status']==1)) {
    $finished =   TRUE;

     if(updateStatus()) {
       $updated = TRUE;
     }
 }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>voting page</title>

	<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.css"> -->
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" type="text/css" href="css/voting.css">
   <style type="text/css">
   	  body{
      margin:0;
      padding: 0;
      background-color: #c0c0c0;
   </style>
</head>

<body>
  

	<div id="header"> 
		 <?php 
		 //echo $config_appName; ?>
     <div class="logo">
         <img src="images/logo/logo3.png" width="150" height="80">

     </div>
		 <div class="sub-text">Experience smartness in voting</div>
  </div>
  <div class="nav-buttons">
      <?php if(getVoter()[0]['status']==1):?>
      <button class="btn"><a href="logout.php?exit">Logout</a></button> 
    <?php endif;?>

      <?php if(($numVoted==$numOffices)&&(getVoter()[0]['status']!=1)):?>
      <button class="btn"><a href="voting.php?done">Confirm</a></button>
     <?php endif;?>
	    
		
  </div>
  <div class="wrapper">
	  <div class="v-status">
	     	  <h3>
	     	  	 Voted <?php echo $numVoted;?>
	     	  	 out of <?php echo $numOffices;?>
	     	  </h3>
	  </div>
  
     <?php if(isset($finished)): ?>
     	<?php 
     	  //accepts voter's choices and indicates he/she has voted
           if(isset($updated))
           	{
         ?> 
         <div class="confirm-msg">
  	 	 Thank you for voting. You can now logout
  	     </div> 
  	     <?php		
            }
     	?>
  	 
      
    <?php else: ?>

   <div class="votingmain">
		<?php
	 if(isset($_GET['id'])){
	 	
	 	echo "Welcome "."<font color='white'>"."<i>".$voter['firstname']." ".$voter['lastname']."</i>".
	 	"</font>"." to the voting page. Click the buttons below to cast your vote.";
	 	 
	 } 

	   elseif(isset($_GET['continue'])){
	   	  echo "Please continue voting";
	   }
	   elseif (isset($_GET['ID'])) {
	      echo "You've finished voting.<br>
	            Click the logout button to exit.";
	   }
	    elseif (isset($_GET['ID2'])) {
	    	echo "You've just undone some voting. Navigate to that link to vote again.";
	    }
	    elseif(isset($_GET['done']))
	    {
	    	 header("Location: summary.php");
	    }
	    elseif(($numVoted == $numOffices)&&($voter['status']!=1)){
           echo "Voting completed. Please click the <i style='color:red'>Confirm</i> button to accept your votes.";
	    }
	  else{
	  	 unset($_SESSION['office-id']);
	  	 echo "Click on the next button to continue voting.";
	  }
		?>

   </div>
   <div class="positions">
   	    <?php
          foreach($offices as $office)
          {

        ?>
      
       <div class="office">

           <form action="castvote.php" method="post">
             <input type ="hidden" name="office-id" value="<?php echo $office['id'];?>">

             <?php if(!empty(votedOffice($office['id']))):?>
             <button  id="office_btn2" type="submit" name="select-office" title="Voted"><?php echo $office['office'];?></button>

             <?php else:?>
             <button  id="office_btn" type="submit" name="select-office" title="Not voted" ><?php echo $office['office'];?></button>
             <?php endif;?>
           </form>
         	

    

         
     </div>
      <?php
        }
      ?>
   </div>
   
        
	


 
  <?php endif; ?>

</div>>
  
  <?php
  require_once 'includes/footer.php';
?>

<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript">
   $(document).ready(function(){
    var numVoted   = "<?php echo $numVoted?>";
    var numOffices = "<?php echo $numOffices?>";
    if(numOffices== numVoted) {
      $('button').prop('disabled',true);
    }
   })
</script>

</body>
</html>

