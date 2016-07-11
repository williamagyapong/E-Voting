<?php 
//session_start();
 require_once '../core/init.php';
 auth(); //prevents unuathenticated users
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
  <?php if(electionSelected()):?>

<?php
 require_once'../core/init.php';

  if(isset($_GET['generated'])) {
     unset($_SESSION['regular']);
     $_SESSION['generated'] = $_GET['generated'];

  } elseif(isset($_GET['regular'])) {
    unset($_SESSION['generated']);
    $_SESSION['regular'] = $_GET['regular'];
  }
  //get on the fly voters
  list($voters2,$pageControls2, $text2) = paginate('voters2');

  //get regular voters
 list($voters,$pageControls, $text) = paginate('voters');

 

//display deletion error messages
 if (isset($_GET['error'])) {
  echo "<font size='6' color='red'>"."Voting has started, you can't remove any voter !"."</font>"."<br>";

 }elseif (isset($_GET['del'])) {
 	echo"<font size='6' color='ff0000'>"."The voter has been removed!".
 	"</font>"."<br>";

 } elseif (isset($_GET['error2'])) {
 	echo"<font size='6' color='ff0000'>"."Sorry, action not successful !"."</font>"."<br>";
 }


?>
<!-- display available voters -->
<?php if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=='non-regular')): ?>

    <?php if(empty($voters2)): ?>
      <h2>No voters. <a href="register.php?generate">Generate Voters id</a> </h2>
    <?php else:?>
     <span style="font-size:14px; color:blue;">Showing voters &nbsp; &nbsp;<?php echo $text2;?></span>
     <table class="table2">
       <tr>
         <th>#</th>
         <th>Voter id</th>
         <th>Status</th>
         <th style="border-right:thin solid #cccccc;">Action</th>
       </tr>
       <?php 
         $counter = 0;
         foreach($voters2 as $voter)
         {
          $counter++;
       ?>
       <tr>
         <td><?php echo $counter;?></td>
         <td><?php echo $voter['voterid'];?></td>
         <td><?php echo $voter['status'];?></td>

         <td class="undo" title="Remove voterid">
            <form action= "voters.php" method="post">
               <input type="hidden" name="id" value = "<?php echo $voter['id'];?>">
               <input type ="submit" name="delete" value="[ X ]">
            </form>
         </td>
       </tr>   
        <?php };?>
     </table>

     <div class="pagecontrols"><?php echo $pageControls2;?></div>
     <div class="print-btn"><a href="print.php?print=voters2" target="_blank">Print</a></div>
    <?php endif;?>

<!-- elseif block of isset get variable generated condition -->
<?php elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=='regular')): ?>

    <?php if(empty($voters)): ?>
    <h2>No voters. <a href="register.php">Register voters</a> </h2>
    <?php else:?>
  <span style="font-size:14px; color:blue;">Showing voters &nbsp; &nbsp;<?php echo $text;?></span>
  <table class="table2">
     <tr>
       <th>name</th>
       <th>Gender</th>
       <th>Voter id</th>
       <th>status</th>
       <th colspan="2">Action</th>
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

       <td class="undo" title="Remove voter">
          <form action= "voters.php" method="post">
             <input type="hidden" name="id" value = "<?php echo $voter['id'];?>">
             <input type ="submit" name="delete" value="[ X ]" title="Remove">
          </form>
       </td>

       <td class="edit">
          <form action= "edit.php" method="post">
             <input type="hidden" name="id" value = "<?php echo $voter['id'];?>">
             <input type ="submit" name="edit-voter" value="[ Edit ]" title="Make changes">
          </form>
       </td>

     </tr>   
      <?php };?>
   </table>

   <div class="pagecontrols"><?php echo $pageControls;?></div>
   <div class="print-btn"><a href="print.php?print=voters" target="_blank">Print</a></div>
  <?php endif;?>

<!-- end the isset get variable generated condition -->
<?php endif; ?>

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

<?php else:?>
   <h2>You haven't selected any election!</h2>
<?php endif;?>
</div>
<?php
  require_once 'includes/footer.php';
?>
</body>
</html>