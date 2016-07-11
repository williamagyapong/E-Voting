<?php 
//session_start();
 require_once '../core/init.php';
 auth();
 //fetch office data
 $offices = getOffices();
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
     <script type="text/javascript" src="js/custom.js"></script>
</head>
 <body>
   <?php 
    require_once 'includes/header.php';
  ?>
<div class="wrapper">
  <?php if(electionSelected()):?>
    
<?php

     if(startedVoting()) {
        echo "<h2>Voting has started. You cannot register any candidate!</h2>";
      } elseif(empty($offices) {
        echo "<h2>You can't register candidates. You must first create offices for election!";
        exit();
        
      } else{

          if(isset($_POST['submit']))  
          { 
             $fname = $_POST['fname'];
             $lname = $_POST['lname'];
             $office= $_POST['office'];
             $image = $_FILES['image'];

            if(isset($_POST['ignore'])&&$_POST['ignore']=="yes")
              {
                  
                  if(register($fname, $lname, $office, $image))
                  {
                    echo "Registration successful";
                  }
                  else{
                    echo "Please try again";
                  }
              }
              else
              {
                  $fname2 = $_POST['fname2'];
                  $lname2 = $_POST['lname2'];
                  $office2= $_POST['office2'];
                  $image2 = $_FILES['image2'];

                  $fname3 = $_POST['fname3'];
                  $lname3 = $_POST['lname3'];
                  $office3= $_POST['office3'];
                  $image3 = $_FILES['image3'];

                  /*$fname4 = $_POST['fname4'];
                  $lname4 = $_POST['lname4'];
                  $office4= $_POST['office4'];
                  $image4 = $_FILES['image4'];*/

                  if(register($fname, $lname, $office, $image)&&
                     register($fname2, $lname2, $office2, $image2)&&
                     register($fname3, $lname3, $office3, $image3)/*&&
                     register($fname4, $lname4, $office4, $image4)*/
                     )
                  {
                    echo "Registration successful";
                  }
                  else{
                    echo "Please try again";
                  }
              }


              }

      }
    

?>


<!-- <h2>CANDIDATES REGISTRATION FORM</h2> -->

<form  action="candregister.php"  method="POST" enctype="multipart/form-data" >
  <fieldset class="fieldset">
    <legend>Candidates Registration Form</legend>
    <div style=" padding-left: 19%">
    <table class="table">
    <tr>
      <td>First Name</td><td><input type ="text" name="fname" class="text-input" autofocus></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname" class="text-input"></td>
    </tr>
    <tr>
      <td>Image</td><td><input type ="file" name="image"></td>
    </tr>
    <tr>
      <td>Office</td>
      <td>
      <select name="office">
        <option value="">---select---</option>
      <?php
         foreach($offices as $office) {
          echo "<option value='".$office['id']."'>".$office['office']."</option>";
         }
      ?> 
      
    </select></td>
  </tr>

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
      <td>Image</td><td><input type ="file" name="image2"></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc">Office</td><td style="border-bottom: 1px solid #ccc"><select name="office2">
        <option value="none">---select---</option>
     <?php
         foreach($offices as $office) {
          echo "<option value='".$office['id']."'>".$office['office']."</option>";
         }
      ?> 
      
    </select></td>
  </tr>
   <tr>
      <td>First Name</td><td><input type ="text" name="fname3" class="text-input"></td>
    </tr>
     <tr>
      <td>Last Name</td><td><input type ="text" name="lname3" class="text-input"></td>
    </tr>
    <tr>
      <td>Image</td><td><input type ="file" name="image3"></td>
    </tr>
    <tr>
      <td style="border-bottom: 1px solid #ccc">Office</td><td style="border-bottom: 1px solid #ccc"><select name="office3">
        <option value="none">---select---</option>
      <?php
         foreach($offices as $office) {
          echo "<option value='".$office['id']."'>".$office['office']."</option>";
         }
      ?> 
      
    </select></td>
  </tr>
   
     <tr>
      <td></td><td><input type ="submit" name="submit" value="REGISTER" class="submit-btn"></td>
    </tr>
  </table>
  </div>
  </fieldset>
  
  </form>


   <?php else:?>
     <h2>You haven't selected any election!</h2>
   <?php endif;?>
 </div>

  <?php
  require_once 'includes/footer.php';
?>

 
</body>
</html>
