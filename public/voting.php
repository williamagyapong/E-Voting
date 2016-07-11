<?php
//session_start();
require_once '../core/init.php';
auth2();

//fetch offices data
 $offices = getOffices();
 $numOffices = count($offices);
 $numVoted = numVoted();
 $finished = false;
 //echo $numVoted;die();

 if(isset($_SESSION['USERNAME'])) {
   //use the regular voters table
   $table = "voters";
 } else {
   //use on the fly voters table
   $table = "voters2";
 
 }

 if(!electionSelected()) {
    die("<h2>The election has been closed!</h2>");
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
  
  <!-- display content only if offices have been created -->
  <?php if(empty($offices)):?>
   <div class="wrapper">
    <div class="nav-buttons">
       <button class="link-btn"><a href="logout.php?exit">Logout</a></button>
    </div>
         <h2>System is not ready for voting.
             Please consult the administrator
         </h2>
  </div>
      <!-- else block of empty office condition-->
  <?php else: ?>

     <!-- initialize necessary variables -->
       <?php 
        $voter = getVoter($table)[0];
        $numVoted = $voter['votingstatus'];

        if(isset($_POST['confirm'])|| ($voter['status']==1)) {

           if(updateStatus($table))
              {
                   $finished = true;
              }
         }
       ?>
  <div class="nav-buttons">
      <?php if(getVoter($table)[0]['status']==1 ||empty($offices)):?>
      <button class="link-btn"><a href="logout.php?exit">Logout</a></button> 
    <?php endif;?>
		
  </div>
  <div class="wrapper">
     <div class="v-status">
	     	  <h3>
	     	  	 Voted <?php echo $numVoted;?>
	     	  	 out of <?php echo $numOffices;?>
	     	  </h3>
	  </div>
  
   <!--  check if user is done voting -->
     <?php if($finished == true): ?>
     	
         <div class="confirm-msg">
  	 	  Thank you for voting. You can now logout.
  	     </div> 
  	     
    <!-- the else block of the finished condition -->
    <?php else: ?>

     <div class="votingmain">
  		<?php
  	 if(isset($_GET['id'])){
  	 	
  	 	echo "Welcome to the voting page.";
  	 	 
  	 }
  	   elseif(isset($_GET['continue'])){
  	   	  echo "Please continue voting";
  	   }
  	    elseif(($numVoted == $numOffices)&&($voter['status']!=1)&&($numVoted!=0)) {
            //show voter the summary of choices for confirmation
             redirect('summary');
  	    }
  	  else{
  	  	 unset($_SESSION['office-id']);
  	  	 echo "Continue voting.";
  	  }
  		?>

     </div>
     <div class="positions">
      
     	    <?php
            foreach($offices as $office)
            {
              $votedOffice = votedOffice($office['id']);
          ?>
        
         <div class="office">

             <form action="castvote.php" method="post">
               <input type ="hidden" name="office-id" value="<?php echo $office['id'];?>">
             <!-- display offices -->
               <?php if(!empty($votedOffice)):?>
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
  <!-- end the finished condition-->
  <?php endif; ?>
</div>

<!-- end empty office condition -->
      <?php endif;?>
  
  <?php
  require_once 'includes/footer.php';
?>

<script type="text/javascript" src="js/jQuery.js"></script>
<script type="text/javascript">
//disable buttons when user is done voting
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

