<?php
 session_start();
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
<?php

$sql ="SELECT * FROM offices";
$result =mysql_query($sql);
$numrow =mysql_num_rows($result);

//handle delete messages
 if(isset($_GET['deloffi'])) {
 	echo "<font size='6' color='ff0000'>"."The office has been removed!"."</font>"."<br>";
 } elseif (isset($_GET['delerror1'])) {
 	echo "<font size='6' color='red'>"."Could not remove office!"."</font>"."<br>";
 } elseif (isset($_GET['delerror2'])) {
  echo "<font size='6' color='red'>"."Voting has started. You cannot delete any office!!"."</font>"."<br>";
 } 

echo "<table class='table2' style='width:70%'>";
echo "<tr>";
echo "<th></th>";
echo "<th>POSTIONS</th>";
echo "<th>ACTION</th>";
echo "</tr>";
if($numrow==0){
      echo "<font size='6' color='0000ff'>"."<b>"."No office has been created! <br>".
      "You can click "."<a href ='office.php'>"."HERE"."</a>"." to create offices for election."."</b>"."</font>";
    } else{
       echo "<font size='5' color='0000ff'>"."Available offices for election"."</font>";
    }
 $i =0;
while ($row=mysql_fetch_assoc($result)) {
     
       
     $i++;
     
      
	echo "<tr>";
	echo "<td>".$i."</td>";
	echo "<td>".$row['office']."</td>";
	

	echo "<td class='undo'>";
echo "<form action='viewoffice.php' method='POST'>";
echo "<input type='hidden' name='id' value='".$row['id']."'>";
echo "<input type='submit' name='delete' value='[ X ]'>";
echo "</form>";
echo "</td>";



}

echo "</table>";


//pop up message for delete confirmation

if (isset($_POST['delete'])) {

    $row = select("SELECT `firstname` FROM `candidates` WHERE `office_id`=".$_POST['id']);
 
    if(count($row)==0) {
       echo "<div class='alert'>";
          echo "<h2>Are you sure you want to remove this office?";
       echo "<form action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
        echo "<input type='submit' name='offino' value='NO'>";
        echo "<input type='submit' name='offiyes' value='YES'>";
       echo "</form>";
       echo "</div>";
    }
    else {
        echo "<div class='alert'>";
          echo "<h2>Are you sure you want to remove this office with related candidates?";
        echo "<form action='delete.php' method='POST'>";
        echo "<input type='hidden' name='id' value='".$_POST['id']."'>";
        echo "<input type='submit' name='offino' value='NO'>";
        echo "<input type='submit' name='offiyes' value='YES'>";
       echo "</form>";
       echo "</div>";
    }
    
}
?>
</div>

<?php

require_once 'includes/footer.php';
?>
</body>
</html>