<?php
session_start();
 require '../core/config.php';
 //require '../core/init.php';
 
 if(isset($_GET['electid'])) {
    
    $_SESSION['V-TYPE'] = getElection($_GET['electid'])[0]['voters'];
    
     if(isset($_SESSION['V-TYPE'])) {
       //set election session variable to switch between elections
       $_SESSION['ELECTID'] = $_GET['electid'];
       header("Location:dashboard.php");
     }else {
      echo "<h2>Unable to set election! Please consult developer.";
     }
     
 } elseif(isset($_POST['edit-election'])) {
  $_SESSION['EDIT'] = "election";
  $_SESSION['EDIT-ID'] = $_POST['id'];
}
 elseif(isset($_POST['save'])) {

  if(update('elections', $_SESSION['EDIT-ID'], [
     'name'=>ucwords($_POST['name']),
         'institute'=>ucwords($_POST['institute']),
         'voters'=>$_POST['voters']
    ] )) {
    header('Location:dashboard.php');
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

     <style type="text/css">
       .text-input{
          width: 100%;
       }
       table{
         width: 100%;
         margin-left: 
       }
     </style>
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
               	   $electId = createElection();
               	  
                     if(createDb($electId)) {
               	  	 echo "Election successfully created.";
               	  } else {
               	  	 echo "Sorry, could not create election.";
               	  }
               }
         	?>
         </div>
        <!-- handle editing of previously created election-->
                 <?php if(isset($_SESSION['EDIT']) && $_SESSION['EDIT']=="election"):
         
         $election = getElection($_SESSION['EDIT-ID']);
      ?>
     <form  action="create-elect.php" method="post">
       <fieldset class="fieldset">
       <legend>Edit election</legend>
    <div style=" padding-left: 20%">
        <table class="table">
        <?php
          foreach($election as $value) {
        ?>
        <tr>
      <td> Name</td><td><input class="text-input" type="text" name="name" value="<?php echo $value['name']?>"></td> 
      </tr>
      <tr>
      <td>Institute</td><td><input class="text-input" type="text" name="institute" value="<?php echo $value['institute']?>"></td>
      </tr>
        <tr>
      <td>Voters</td>
      <td><select  name="voters" >
         <option value="<?php echo $value['voters']?>"><?php echo $value['voters']?></option>

          <?php if($value['voters']=='non-regular'):?>
          <option value="regular">regular</option>
           <?php elseif($value['voters']=='regular'):?>
          <option value="non-regular">non-regular</option>
          <?php endif;?>
          </select>
      </td>
      </tr>
   
       <tr>
      <td></td><td><input type="submit" name ="save" value="Save Changes" class="submit-btn" style="width:70%"></td>
       </tr>
      <?php } ?>
      </table>
     </div>
      </fieldset>
     </form>
   <?php else:?>
      <!-- provide election creation form -->
      	  <form role="form" action="create-elect.php" method="post">
         <fieldset class="fieldset">
         	<legend>Create Election</legend>

         	<div class="form-group">
       	   
       	   <input type="text" name="name" class="form-control" placeholder="Enter name of election" autofocus="true" required="required">
       	 </div>
       	 <div class="form-group">
       	   
       	   <input type="text" name="institute" class="form-control" placeholder="Enter institution" autofocus="true" required="required">
       	 </div>
         <div class="form-group">
            <select name="voters" required="required">
              <option value="" title="select type of voters">--select voters--</option>
              <option value="regular" title="voters must be fully registered">Regular voters</option>
              <option value="non-regular" title="You only generate voters id">Non regular voters</option>
            </select>
         </div>
       	 <button type="submit" name="create" class="btn btn-default">Create</button>
         </fieldset>
       	 
       </form>

   <?php endif;?>
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