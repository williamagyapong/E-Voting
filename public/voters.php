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
/*table {
	margin top: 30px; position: absolute; left: 100px;
}*/
</style>
</head>
<body>
 <?php 
    require_once 'includes/header.php';
  ?>
 <div class="wrapper">
<?php
 require("config.php");
 require_once'../core/init.php';

list($voters,$pageControls, $text) = paginate('voters');

 if(isset($_GET['errorm'])) {
 	echo "<font size='6' color='ff0000'>"."You can't delete this voter because he 
 	has already votered!"."</font>"."<br>";
 } elseif (isset($_GET['errorf'])) {
 	echo "<font size='6' color='red'>"."You can't delete this voter because she 
 	has already votered!"."</font>"."<br>";
 } elseif (isset($_GET['del'])) {
 	echo"<font size='6' color='ff0000'>"."The voter has been removed from the database!".
 	"</font>"."<br>";
 } elseif (isset($_GET['error2'])) {
 	echo"<font size='6' color='ff0000'>"."The action was not successful!"."</font>"."<br>";
 }


?>
<!-- display availabel voters -->
<?php if(empty($voters)): ?>
  <h2>No voters. <a href="register.php">Register</a> </h2>
<?php else:?>
 <span style="font-size:14px; color:blue;">Showing voters &nbsp; &nbsp;<?php echo $text;?></span>
 <table class="table2">
   <tr>
     <th>name</th>
     <th>Gender</th>
     <th>Voter id</th>
     <th>status</th>
     <th>Action</th>
   </tr>
   <?php 
     foreach($voters as $voter)
     {
   ?>
   <tr>
     <td><?php echo $voter['firstname']." ".$voter['lastname'];?></td>
     <td><?php echo $voter['gendar'];?></td>
     <td><?php echo $voter['voterid'];?></td>
     <td><?php echo $voter['status'];?></td>

     <td class="undo">
        <form action= "voters.php" method="post">
           <input type="hidden" name="id" value = "<?php echo $voter['id'];?>">
           <input type ="submit" name="delete" value="[ X ]">
        </form>
     </td>
   </tr>   
    <?php };?>
 </table>

 <div class="pagecontrols"><?php echo $pageControls;?></div>
 <div class="print-btn"><a href="print.php?print=voters" target="_blank">Print</a></div>
<?php endif;?>
<!-- display alert dialog box -->
<?php
if (isset($_POST['delete'])) {
echo "<div class='alert'>";
      echo "<h2>Are you sure you want to delete this voter?";
  echo "<form action='delete.php' method='POST'>";
    echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
    echo "<input type='submit' name='vno' value='NO'>";
    echo "<input type='submit' name='vyes' value='YES'>";
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