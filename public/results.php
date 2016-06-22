<?php
 session_start();
  require_once'../core/init.php';
  auth();
  $offices = getOffices(); 
  $totalVoters = totalVoters();
  $votedVoters = votedVoters();
  
?>

<!DOCTYPE html>
<html>
<head>
  <title>Results Page</title>
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <style type="text/css">
  	li{
  		list-style: none;
  		font-weight: bold;
  		font-size: 20px;
  		background:;
  		color: red;

  	}
    .wrapper{
      margin-top: 20px;
      border: thin solid #cccccc;
    }
  </style>
</head>
<body>
 <?php 
    require_once 'includes/header.php';
    
  ?>
    
 <div class="wrapper">
      <?php if(startedVoting()):?>
    <div class="result">
      Election Results
    </div>
    <div class="box1">
       <table class="table3">
        <tr>
          <td>Registered voters:</td>
          <td style="color:red"><?php echo $totalVoters;?></td>
        </tr>
        <tr>
          <td>Number Voted:</td>
          <td style="color:red"><?php echo $votedVoters;?></td>
        </tr>
       </table>
    </div>
    <div class="">
      <ul>
       <hr>
       <?php
         foreach($offices as $office) {
           $voteCast = count(voteCast($office['id']));
       ?>
       
        <li><?php echo $office['office'];?></li>
             <table class="table2">
                <tr>
                  <th>CANDIDATE</th>
                  <th>PHOTO</th>
                  
                  <th>VOTES RECEIVED</th>
    
                  <th style="border-right:thin solid #cccccc;">%</th>
                </tr>
                 <?php
                    foreach(getCandidateByOffice($office['id']) as $candidate) {
                      
                      $percent = sprintf("%.2f",($candidate['num_votes']/$totalVoters)*100);
                 ?>
                <tr>
                    <td><?php echo $candidate['firstName']." ".$candidate['lastName'];?></td>

                    <td><img src="images/<?php echo $candidate['images'];?>" width="120" height="120" ></td>
                   
                    <td style="width:8%;"><?php echo $candidate['num_votes'];?></td>
                    <td><?php echo $percent;?></td>
                </tr>

                <?php }?>

                <tr>
                   <td colspan="2">TOTAL VOTES CAST</td>
                    <td><?php echo $voteCast; ?></td>

                </tr>
             </table>
             <hr>
       <?php }?>
     
      </ul>
    </div>
<?php else:?>
  <h2>No result available. Voting has not started</h2>
<?php endif;?>
 </div>
    

<?php require_once'includes/footer.php';?>
  </body>
</html>      