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
    $updated = DB::getInstance()->update($table, $_SESSION['ID'], ['status'=>1], 'voterid');
  	
  	if($updated){
  		header("Location: voting.php?ID=73");
  	} else{
  		echo "unable to confirm votes";
  	}

  }
   elseif (isset($_POST['uyes'])) {

       $row  = DB::getInstance()->select("SELECT id FROM $table WHERE voterid=".$_SESSION['ID'])->first();

       $officeId =$_POST['officeid'];

      if(isset($_POST['candid']))
      {
          if(empty($officeId) && empty($_POST['candid'])) 
          {
            echo "Cannot undo vote!";
          } else{
          
            $candId = $_POST['candid'];

            $deleted = DB::getInstance()->delete('','', "DELETE FROM $table2 WHERE voter_id ='".$row['id']."' AND cand_id='".$candId."'");
            $candUpdated = DB::getInstance()->update2('candidates',['id'=>$candId], ['num_votes'=>1], '-' );
  
            $voterUpdated = DB::getInstance()->update2($table,['id'=>$row['id']], ['votingstatus'=>1], '-' );

            if($deleted&&$candUpdated&&$voterUpdated) {
              //header("Location: voting.php?ID2=74");
            
              unset($_SESSION['office-id']);
              $_SESSION['office-id'] = $officeId;
              header("Location: castvote.php?id=".$officeId);
            }
        }

      } else{
              $deleted = DB::getInstance()->delete('','', "DELETE FROM $table2 WHERE voter_id ='".$row['id']."' AND office_id='".$officeId."'");

              $voterUpdated = DB::getInstance()->update2($table,['id'=>$row['id']], ['votingstatus'=>1], '-' );

              if($deleted&&$voterUpdated) {
                
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