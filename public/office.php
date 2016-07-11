<?php 
//session_start();
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
   <?php if(electionSelected()):?>
    
<?php

  if (isset($_POST['create'])) {

      if(startedVoting()) {
        echo "<h2>Voting has started. You cannot create any new office!</h2>";
      }else{
          if (empty($_POST['office'])) {
             echo "The office field can't be empty!";
        } 
        else
        {
          if(isset($_POST['ignore'])&&$_POST['ignore']=="yes")
          {
            $office = ucwords($_POST['office']);
            if(insert('offices',[
                 'office'=>$office
              ])) echo "The action was successful";
            else {
            echo "A problem might have occurred. Please try again";
           }
          }
          else{
            $office  = ucwords($_POST['office']);
            $office2 = ucwords($_POST['office2']);
            $office3 = ucwords($_POST['office3']);
            $office4 = ucwords($_POST['office4']);

            if(insert('offices',[
                 'office'=>$office
              ])&& insert('offices',[
                 'office'=>$office2
              ])&& insert('offices',[
                 'office'=>$office3
              ])&& insert('offices',[
                 'office'=>$office4
              ]))echo "The action was successful";
            else {
            echo "A problem might have occurred. Please try again";
           }
          }
          
       }

      }
        
    }
    
?>

  <!-- <h2>Create Offices For Election</h2> -->
  
    <form action="" method="POST">
      <fieldset class="fieldset">
        <legend>Create Offices</legend>
        <div style=" padding-left: 20%">
            <table class="table" style="/*margin-left:30%*/;">
            <tr><td>Office</td><td><input type="text" name="office" required  class="text-input" autofocus></td>
            </tr>
            <tr>
               <td>
              <input type="checkbox" name="ignore" value="yes" checked="checked" style="width:22px; height:22px"><span id = "ignore">Ignore</span>
              </td><td></td>
            </tr>
            <tr>
              <td>Office</td>
              <td>
                 <input type="text" name="office2" class="text-input">
              </td>
            </tr>
            <tr>
              <td>Office</td>
              <td>
                 <input type="text" name="office3" class="text-input">
              </td>
            </tr>
            <tr>
              <td>Office</td>
              <td>
                 <input type="text" name="office4" class="text-input">
              </td>
            </tr>
            <tr><td></td><td><input type="submit" name="create" value="CREATE" class="submit-btn"></td></tr>
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