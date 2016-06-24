<?php 
session_start();
 require_once '../core/init.php';
 auth();
?>
<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" type="text/css" href="css/main.css">
    <style type="text/css">
      body{
      margin:0;
      padding: 0;
      background-color: #c0c0c0;
    }
    </style>
</head>
<body>
	<?php 
	  require_once 'includes/header.php';
	?>

	 <div class="wrapper">
	<?php

	if(isset($_POST['submit']))
	{
		  if(startedVoting()) {
        echo "<h2>Voting has started. You cannot register any new voter!</h2>";
      }else{

          $fname = $_POST['fname'];
          $lname = $_POST['lname'];
          $gender= $_POST['gender'];

          if(isset($_POST['ignore'])&&$_POST['ignore']=="yes")
          {
            if(register2($fname, $lname, $gender))
            {
              echo "Registration successful";
            }
            else
            {
              echo "Please try again";
            }
          }
          else
          {
              $fname2 = $_POST['fname2'];
              $lname2 = $_POST['lname2'];
              $gender2= $_POST['gender2'];

              $fname3 = $_POST['fname3'];
              $lname3 = $_POST['lname3'];
              $gender3= $_POST['gender3'];

              $fname4 = $_POST['fname4'];
              $lname4 = $_POST['lname4'];
              $gender4= $_POST['gender4'];

              if(register2($fname, $lname, $gender)&&
                register2($fname2, $lname2, $gender2)&&
                register2($fname3, $lname3, $gender3)&&
                register2($fname4, $lname4, $gender4)
                )
            {
              echo "Registration successful";
            }
            else
            {
              echo "Please try again";
            }
          }

      }

	}

	?>


<!-- <h2>VOTERS REGISTRATION FORM</h2> -->

<form action="register.php" method="POST">
  <fieldset class="fieldset">
  	 <legend>Voters Registration Form</legend>
     <div style=" padding-left: 20%">
  	 <table class="table">
    <tr>
      <td>First Name</td><td><input type ="text" name="fname" class="text-input" autofocus></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname" class="text-input"></td>
    </tr>
    <tr>
      <td>Gender</td><td><select name="gender">
       <option value="">--select--</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option></select></td>
    </tr>
   <!-- provide multiple registration -->
    <tr>
    	<td>
      <input type="checkbox" name="ignore" value="yes" checked="checked" style="width:22px; height:22px"><span id = "ignore">Ignore</span>
      </td><td></td>
    </tr>
    <tr>
      <td style="border-top: 1px solid #ccc">First Name</td><td style="border-top: 1px solid #ccc"><input type ="text" name="fname2" class="text-input"></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname2" class="text-input"></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc">Gender</td>
      <td style="border-bottom: 1px solid #ccc"><select name="gender2">
       <option value="none">--select--</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option></select></td>
    </tr>
    <tr>
      <td>First Name</td><td><input type ="text" name="fname3" class="text-input"></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname3" class="text-input"></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc">Gender</td><td style="border-bottom: 1px solid #ccc"><select name="gender3">
       <option value="none">--select--</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option></select></td>
    </tr>
    <tr>
      <td>First Name</td><td><input type ="text" name="fname4" class="text-input"></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname4" class="text-input"></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc">Gender</td>
      <td style="border-bottom: 1px solid #ccc"><select name="gender4">
       <option value="none">--select--</option>
       <option value="Male">Male</option>
       <option value="Female">Female</option></select></td>
    </tr>

     <tr>
      <td></td><td><input type ="submit" name="submit" value="REGISTER" class="submit-btn"></td>
    </tr>


  </table>
  </div>
  </fieldset>
  
</form>
</div>
<?php
  require_once 'includes/footer.php';
?>
</body>
<html>