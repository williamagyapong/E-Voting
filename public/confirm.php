<?php
//session_start();
require'../core/init.php';
auth2();

if(isset($_SESSION['USERNAME'])) {
    $table = "voters";
    $table2 = "voting";
  } else {
    $table = "voters2";
    $table2 = "voting2";
  }

if(isset($_POST['confirm']))
  {
  	$sql = "UPDATE $table SET status =1 WHERE voterid=".$_SESSION['ID'];
  	if(mysql_query($sql)){
  		header("Location: voting.php?ID=73");
  	} else{
  		echo "unable to confirm votes";
  	}

  }
   elseif (isset($_POST['uyes'])) {

       $row  = select("SELECT id FROM $table WHERE voterid=".$_SESSION['ID'])[0];

       $officeId =$_POST['officeid'];

      if(isset($_POST['candid']))
      {
          if(empty($officeId) && empty($_POST['candid'])) 
          {
            echo "Cannot undo vote!";
          } else{
          
            $candId = $_POST['candid'];

            $delsql ="DELETE FROM $table2 WHERE voter_id ='".$row['id']."' AND cand_id='".$candId."'";

            $updatesql ="UPDATE candidates SET num_votes = num_votes-1 WHERE id =".$candId;

            $updatesql2 ="UPDATE $table SET votingstatus = votingstatus-1 WHERE id =".$row['id'];
            

            if(mysql_query($delsql)&&mysql_query($updatesql)&&mysql_query($updatesql2)) {
              //header("Location: voting.php?ID2=74");
            
              unset($_SESSION['office-id']);
              $_SESSION['office-id'] = $officeId;
              header("Location: castvote.php?id=".$officeId);
            }
        }

      } else{

              $delsql ="DELETE FROM $table2 WHERE voter_id ='".$row['id']."' AND office_id='".$officeId."'";

              $updatesql ="UPDATE $table SET votingstatus = votingstatus-1 WHERE id =".$row['id'];

              if(mysql_query($delsql)&&mysql_query($updatesql)) {
                
                unset($_SESSION['office-id']);
                $_SESSION['office-id'] = $officeId;
                header("Location: castvote.php?id=".$officeId);
              }
      }
     	  
   }
    elseif (isset($_POST['uno'])) {
      header("Location:summary.php");
    }
    
?>