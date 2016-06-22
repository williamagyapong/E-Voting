<?php 
session_start();
require '../core/init.php';
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

/*.content{
  margin-left: 300px;
}*/
</style>
</head>
<body>
 <?php 
    require_once 'includes/header.php';
    
    list($candidates,$pageControls, $text) = paginate('candidates',5);
    
  ?>
<div class="wrapper">
    <?php
    if (isset($_GET['del'])) 
    {
    	 echo "<font size='6' color='ff0000'>"."The delete action was successful"."</font>"."<br>";
    } 
    elseif (isset($_GET['error1'])) 
    {
    	 echo "<font size='6' color='ff0000'>"."The delete action was unsuccessful"."</font>"."<br>";
    } 
    elseif(isset($_GET['error2'])) 
    {
    	echo "<font size='6' color='ff0000'>"."You can't remove this candidate!"."</font>"."<br>";
    }
    $sql ="SELECT candidates.*,office FROM candidates, offices WHERE candidates.office_id=offices.id ";
     $result = mysql_query($sql);
     $numrows = mysql_num_rows($result);
    ?>
     <!-- <div style="width:80%; background: red"> -->
     <table  class="table2">
       <tr>
       <th>Name</th>
       <th>Office</th>
       <th>Picture</th>
       <th>Action</th>
       </tr>
     <?php
      if ($numrows==0) {
        echo "<font size='6' color='red'>"."No candidate exist for election! <br>".
        "You can click "."<a href ='candregister.php'>"."HERE"."</a>"." to register candidates".
          "</font>" ;
      } 
      else
      {
        echo "<span><font size='4' color='blue'>"."Showing Candidates &nbsp; &nbsp; $text".
           "</span></font>" ;

    /*while($row =mysql_fetch_assoc($result)) */
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
      </tr>

    <?php
      }
     }
    ?> 

      </table>
      <div class="pagecontrols"><?php echo $pageControls;?></div>
      <div class="print-btn"><a href="print.php?print=candidates" target="_blank">Print</a></div>
    <!-- </div> -->

    <!-- haddle removal of candidate -->
    <?php
    if (isset($_POST['delcand'])) {
    echo "<div class='alert'>";
          echo "<h2>Are you sure you want to delete this candidate?";
      echo "<form action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
        echo "<input type='submit' name='no' value='NO'>";
         echo "<input type='submit' name='yes' value='YES'>";
      echo "</form>";
    echo "</div>";
    }


    ?>
</div>

 <?php
  require_once 'includes/footer.php';
?>
</body>
</html>