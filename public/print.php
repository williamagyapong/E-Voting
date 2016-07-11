<?php
 //session_start();
 require_once '../core/init.php';
  auth();
  
  if(isset($_GET['print']))
  {
  	$_SESSION['PRINT'] = $_GET['print'];
  }
   list($result,$pageControls, $text) = paginate('voters');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>print page</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<style type="text/css">
	.print{
	width: 70%;
	border: 1px solid #000000; 
	border-radius: 10px;
    background: #ffffff; 
    margin-top: 30px;
    margin-left: 15%;
    margin-bottom: 20px;
    border-collapse: collapse;
    
}
.print th { 
	letter-spacing: 2.5px; 
	 color: #000000; 
	 text-transform: uppercase; 
	 text-align: center;
	 border-top: 1px solid #000000;
	 border-bottom: thin solid #000000;
	 padding: 10px;
	 border-right: 1px solid black;
}

.print td { 
	border: 1px dashed #000000;
	 padding: 20px 0 20px 40px; 
	 font-size: 18px; 
	font-family: verdana;

	 /*font-weight: bold;*/
	 
}
	</style>
</head>
<body>

	 <div class="container-fluid">
	 <!-- display regular voters -->
	 	<?php if(isset($_SESSION['PRINT'])&& ($_SESSION['PRINT']=='voters')): ?>
     <h3><?php echo $text;?></h3>
	 <table class="print">
	   <tr>
	     <th>name</th>
	     <th>Voter id</th>
	    
	     
	   </tr>
	   <?php 
	     foreach($result as $voter)
	     {
	   ?>
	   <tr>
	     <td><?php echo $voter['firstname']." ".$voter['lastname'];?></td>
	     <td><?php echo $voter['voterid'];?></td>
	     
	   </tr>   
	    <?php };?>
	 </table>
    <div><?php echo $pageControls;?></div>

     <!--display on the fly voters -->
	 <?php elseif(isset($_SESSION['PRINT'])&& ($_SESSION['PRINT']=='voters2')): 
       list($voters2,$pageControls, $text) = paginate('voters2');
	 ?>
     <h3><?php echo $text;?></h3>
	 <table class="print">
	   <tr>
	     <th>#</th>
	     <th>Voter id</th>
	    
	     
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
	     
	   </tr>   
	    <?php };?>
	 </table>

	 <div><?php echo $pageControls;?></div>
    <!-- display candidates -->
	 <?php elseif(isset($_SESSION['PRINT'])&& ($_SESSION['PRINT']=='candidates')):
	     list($candidates,$pageControls, $text) = paginate('candidates',4);

	   ?>
      <h3><?php echo $text;?></h3>
	  <table  class="print">
       <tr>
       <th>Name</th>
       <th>Office</th>
       <th>Picture</th>
       </tr> 
	 <?php
       foreach($candidates as $row)
    {
    ?>
    	<tr>
        <td><?php echo $row['firstName']." ".$row['lastName'];?></td>
        <td><?php echo $row['office'];?></td>
        <td><img src="images/<?php echo $row['images'];?>" width="120" height= "100" title="<?php echo $row['firstName'];?>"></td>

      </tr>

    <?php
      }
     
    ?> 

      </table>
      <div><?php echo $pageControls;?></div>
	  <?php elseif(isset($_GET['results'])):
	     //list($result,$pageControls, $text) = paginate('voters');

	  ?>

	  <?php endif;?>
		 </div>
	   
 </body>
</html>