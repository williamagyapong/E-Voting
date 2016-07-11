<?php
 //session_start();
 require_once'../core/init.php';
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
 <!-- display content only if an election has been selected -->
 <?php if(electionSelected()):

 //select offices
 $offices = getOffices();

 ?>

<?php

/*$sql ="SELECT * FROM offices";
$result =mysql_query($sql);
$numrow =mysql_num_rows($result);*/

//handle delete messages
 if(isset($_GET['deloffi'])) {
 	echo "<font size='6' color='ff0000'>"."The office has been removed!"."</font>"."<br>";
 } elseif (isset($_GET['delerror1'])) {
 	echo "<font size='6' color='red'>"."Could not remove office!"."</font>"."<br>";
 } elseif (isset($_GET['delerror2'])) {
  echo "<font size='6' color='red'>"."Voting has started. You cannot delete any office!!"."</font>"."<br>";
 } 
?>
<!-- ensure offices variable is not empty -->
<?php if(empty($offices)):?>
  <h2>No office available</h2>
  <!-- provide a link to the create office page -->
  <a href="office.php"> Create Office</a>
<!-- display office data table -->
<?php else: ?>
<table class="table2">
  <tr>
    <th>#</th>
    <th>POSITIONS</th>
    <th colspan="2" style="border-right:thin solid #cccccc;">ACTION</th>
  </tr>
  <!-- loop through offices array -->
  <?php  
    // initialize counter
    $counter = 0;
     foreach($offices as $office) {
    //update counter
    $counter++;
  ?>
  <tr>
    <td><?php echo $counter ?></td>
    <td><?php echo $office['office'];?></td>
    <td class = "undo">
      <form action = "viewoffice.php" method = "post">
       <input type = "hidden" name = "id" value = " <?php echo $office['id'] ?>" >
       <input type = "submit" name = "delete" value = "[ X ]" title="Delete">
      </form>
    </td>

    <td class = "edit">
      <form action = "edit.php" method = "post">
       <input type = "hidden" name = "id" value = " <?php echo $office['id'] ?>" >
       <input type = "submit" name = "edit-office" value = "[ Edit ]" title="Make changes">
      </form>
    </td>
  </tr>
  <!-- end foreach loop -->
  <?php } ; ?>
</table>
 <!-- end the if condition -->
 <?php endif; ?>



<?php
//pop up message for delete confirmation

if (isset($_POST['delete'])) {

    $row = select("SELECT `firstname` FROM `candidates` WHERE `office_id`=".$_POST['id']);
 
    if(count($row)==0) {
?>
       <div class='alert'>
          <h2>Are you sure you want to remove this office?
          <form action= "delete.php" method="POST">
            <input type='hidden' name='id' value="<?php echo $_POST['id'] ?>">
            <input type="submit" name="offino" value="NO" autofocus= "true">
            <input type="submit" name="offiyes" value="YES">
         </form>
       </div>
       <?php 
    }
    else {
      ?>
        <div class='alert'>
          <h2>Are you sure you want to remove this office with related candidates?
           <form action='delete.php' method='POST'>
             <input type='hidden' name='id' value="<?php echo$_POST['id']?>">
             <input type='submit' name='offino' value='NO' autofocus= "true">
             <input type='submit' name='offiyes' value='YES'>
          </form>
       </div>
  <?php 
    }
    
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