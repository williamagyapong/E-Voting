<?php
  session_start();
  require_once '../core/init.php';
  auth(); // protects this page against unauthenticated users

   if(isset($_POST['save']))
   {
       $userId   = $_SESSION['ADMINID'];
       $prevPass = $_POST['prevPass'];
       $newPass1 = $_POST['newPass1'];
       $newPass2 = $_POST['newPass2'];
        // use change password function to changes
       $messages = changePassword($userId, $prevPass, $newPass1, $newPass2);
   }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Change Password</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/changepass.css">
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
      require 'includes/header3.php';
    ?>
    <div class="">
        
    </div>
    <div class="container">
      <div class="row contained">
       <form action="changepass.php" method="POST">
        <fieldset>
          <legend class="col-md-8 col-md-offset-2">Change Password:</legend>
          <div class="col-md-6 col-md-offset-3 ">
              <div class="form-group has-success has-feedback">
                  <label class="control-label sr-only" for="inputGroupSuccess4"></label>
                  <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                    <input type="password" name= "prevPass" class="form-control name_input" placeholder ="Current Password" id="inputGroupSuccess4" required>
                  </div>
                  <span class="glyphicon glyphicon-ok form-control-feedback glyphicon_ok" aria-hidden="true"></span>
                  <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
               </div>


              <div class="form-group has-success has-feedback">
                  <label class="control-label sr-only" for="inputGroupSuccess4"></label>
                  <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                    <input type="password" name= "newPass1" class="form-control name_input" placeholder ="New Password" id="inputGroupSuccess4" required>
                  </div>
                  <span class="glyphicon glyphicon-ok form-control-feedback glyphicon_ok" aria-hidden="true"></span>
                  <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
               </div>


               <div class="form-group has-success has-feedback">
                  <label class="control-label sr-only" for="inputGroupSuccess4"></label>
                  <div class="input-group">
                     <span class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                    <input type="password" name= "newPass2" class="form-control name_input" placeholder ="Confirm Password" id="inputGroupSuccess4" required>
                  </div>
                  <span class="glyphicon glyphicon-ok form-control-feedback glyphicon_ok" aria-hidden="true"></span>
                  <span id="inputGroupSuccess4Status" class="sr-only">(success)</span>
               </div>
               <button type="submit" name="save" class="btn btn-primary pull-right">Save Changes</button>
               <a style="margin-right: 15px;" class="btn btn-primary btn-md pull-right" href="dashboard.php">Control Panel</a>
               
            </div>
          </fieldset>

          
             <div class="col-md-6 col-md-offset-3 red">
               <?php
                
                 if(!empty($messages))
                  {
                    echo "<p class = reports>";
                    foreach($messages as $message)
                    {
                      echo $message."<br>";
                    }
                      echo "</p>";
                  }
               ?>
            </div>
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
  </body>
</html>