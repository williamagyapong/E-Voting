<?php 
require '../core/init.php';
auth();//prevents unuathenticated users
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

/*.content{
  margin-left: 300px;
}*/
</style>
</head>
<body>
 <?php 
    require_once 'includes/header.php';
    
    
    
  ?>
<div class="wrapper">
  <?php if(electionSelected()):
    list($candidates,$pageControls, $text) = paginate('candidates',5);
  ?>

    <?php
    if (isset($_GET['del'])) 
    {
    	 echo "<font size='6' color='ff0000'>"."The candidate has been removed !"."</font>"."<br>";
    } 
    elseif (isset($_GET['error1'])) 
    {
    	 echo "<font size='6' color='ff0000'>"."Sorry, action not successful !"."</font>"."<br>";
    } 
    elseif(isset($_GET['error2'])) 
    {
    	echo "<font size='6' color='ff0000'>"."Voting has started, you can't remove any candidate !"."</font>"."<br>";
    }
    
    ?>

    <!-- display availabel candidates -->
    <?php if(empty($candidates)): ?>
      <h2>No candidates. <a href="candregister.php">Register</a> </h2>
    <?php else:?>
     <span style="font-size:14px; color:blue;">Showing candidates &nbsp; &nbsp;<?php echo $text;?></span>
     
     <table  class="table2">
       <tr>
       <th>Name</th>
       <th>Office</th>
       <th>Picture</th>
       <th colspan="2" style="border-right:thin solid #cccccc;">Action</th>
       </tr>
     <?php
     
    foreach($candidates as $row)
    {
    ?>
    	<tr>
        <td><?php echo $row['firstName']." ".$row['lastName'];?></td>
        <td><?php echo $row['office'];?></td>
        <td><img src="images/<?php echo $row['images'];?>" width="120" height= "100" title="<?php echo $row['firstName'];?>"></td>


        <td class="undo" title="Remove candidate">
        <form action="candidates.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        <input type="submit" name="delcand" value="[ X ]">
        </form>
        </td>

        <td class="edit" title="make changes">
        <form action="edit.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        <input type="submit" name="edit-candidate" value="[ Edit ]">
        </form>
        </td>
      </tr>

    <?php
      }
     
    ?> 

      </table>
      <div class="pagecontrols"><?php echo $pageControls;?></div>
      <div class="print-btn"><a href="print.php?print=candidates" target="_blank">Print</a></div>

      <?php endif;?>
    

    <!-- haddle removal of candidate -->
    <?php
    if (isset($_POST['delcand'])) {
    echo "<div class='alert'>";
          echo "<h2>Are you sure you want to delete this candidate?";
      echo "<form action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
        echo "<input type='submit' name='no' value='NO' autofocus>";
         echo "<input type='submit' name='yes' value='YES'>";
      echo "</form>";
    echo "</div>";
    }


    ?>


    <?php else:?>
     <h2>You haven't selected any election!</h2>
    <?php endif;?>
</div>

 <?php
  require_once 'includes/footer.php';
?>
</body>
</html>