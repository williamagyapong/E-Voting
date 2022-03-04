<?php
   //session_start();
 require_once '../core/init.php';
 auth2();//prevents unauthorized entry
 $voterId = $_SESSION['user-id'];
 $candidates = getCandidateWithOffice();

 
?>
<!DOCTYPE html>
 <html>
 <head>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style type="text/css">

  </style>
 </head>
 <body>
  <?php 
    require_once 'includes/header2.php';
  ?>
 	<div class="summary">
    <?php if(empty($candidates)):?>
       <h2 style="color:red">You did not vote for any candidate!</h2>
    <?php else:?>
    <span class="summaryhead">
       Please <b>ACCEPT</b> to complete voting or <b>undo</b> to vote again.
    </span>
    
    <table class="table2" style="width:85%;margin-left:6%">
       <tr>
          <th>Candidate</th>
          <th>Office</th>
          <th>Image</th>
          <th style="border-right:thin solid #cccccc;">Action</th>
       </tr>
       <?php 
          foreach($candidates as $candidate) {

       ?>
       <tr>
         <?php if(isset($candidate['firstName'], $candidate['lastName'], $candidate['images'])):?>
          <td><?php echo $candidate['firstName']." ".$candidate['lastName'];?></td>
          <td><?php echo $candidate['office'];?></td>
          <td><img src = "images/<?php echo $candidate['images']?>" width ="160" height="150"></td>

          <td class="undo">
              <form action="summary.php" method="post">
                 <input type="hidden" name="officeid" value="<?php echo $candidate['office_id']?>">
                 <input type="hidden" name="candid" value="<?php echo $candidate['id']?>">
                 <input type ="submit" name="undo" value="undo">
              </form>
          </td>

          <?php else:?>
          <td>None</td>
          <td><?php echo $candidate['office'];?></td>
          <td>None</td>

          <td class="undo">
              <form action="summary.php" method="post">
                 <input type="hidden" name="officeid" value="<?php echo $candidate['id']?>">
                 <input type ="submit" name="undo" value="undo">
              </form>
          </td>
         <?php endif;?>

       </tr>
       <?php 
       }
       ?>
    </table>

   <!--display confirm button-->
   <div class="confirm">
       <form action="voting.php" method="post">
          <input type="submit" name="confirm" value="ACCEPT">
       </form>
   </div>
  <?php endif;?>
  

<!-- display alert dialog box  when the undo button is clicked-->
<?php if (isset($_POST['undo'])):?> 
  <div class="alert">
      <h2>Do you want to undo this vote and vote again?</h2>
      <form action="confirm.php" method="POST">
         <input type="hidden" name="officeid" value="<?php echo $_POST['officeid'];?>">

         <?php if(isset($_POST['candid'])):?>
           <input type="hidden" name="candid" value="<?php echo $_POST['candid'];?>">
         <?php endif;?>
         <input type="submit" name="uno" value="NO" autofocus="true">
         <input type="submit" name="uyes" value="YES">
      </form>
  </div> 
<?php endif;?>

 </div>


<?php
  require_once 'includes/footer.php';
?>
 </body>
 </html>