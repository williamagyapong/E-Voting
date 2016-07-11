<?php
// initialise necessary variables
 
 function unVotedOffice()
 {
   $data = [];
   $voterId = $_SESSION['user-id'];
   if(isset($_SESSION['USERNAME'])) {
    $table2 = "voting";
  } else {
    $table2 = "voting2";
  }
   $row = select("SELECT * FROM $table2 WHERE `voter_id`='$voterId' AND `cand_id`=0");
   foreach($row as $id) {
     $data[] = select("SELECT * FROM `offices` WHERE `id`=".$id['office_id']);
   }
   return $data;
 }

 //print_array(getCandidateWithOffice());die();

function voteCast($officeId)
{
  if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
      $table = 'voting';
  } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
      $table = 'voting2';
  }
	return count(select("SELECT * FROM $table WHERE `office_id`='$officeId' AND `cand_id` !=0"));
}


//echo count(voteCast(1));die();
function totalVoters()
{
  if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
      $table = 'voters';
  } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
      $table = 'voters2';
  }
	return count(select("SELECT * FROM $table"));
}


function numVoted() 
{
  
  $loginId = $_SESSION['user-id'];
  if(isset($_SESSION['USERNAME'])) {
    $table = "voters";
  } else {
    $table = "voters2";
  }

  $row = select("SELECT * FROM $table WHERE id = ".$loginId);
  foreach($row as $voter) {
     return $voter['votingstatus'];
  }
}

function votedVoters()
{
  if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
      $table = 'voters';
  } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
      $table = 'voters2';
  }
  

	return count(select("SELECT * FROM $table WHERE `status`=1"));
}

function VotedOffice($officeId)
{
  if(isset($_SESSION['USERNAME'])) {
    $table = "voting";
  } else {
    $table = "voting2";
  }

  $voterId = $_SESSION['user-id'];
  return select("SELECT `office_id` FROM $table WHERE `voter_id`='{$voterId}' AND `office_id` = '{$officeId}'");
}

 function getResults()
 {
 	$data = [];
 	$offices = getOffices();
    if(!empty($offices)) {
    	foreach($offices as $office) {

    	}
    }

 }

 function startedVoting()
 {
   $table ='';//to prevent problem of undefined variable table
   if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
    $table = 'voting';
} elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
    $table = 'voting2';
}
 	$row = select("SELECT id FROM $table");
 	if(count($row)>0){

 		return true;
 	} else{
 		return false;
 	}

 }


function isVoting()
{
   if(isset($_SESSION['user-id'])) {
      return true;
   } else {
      return false;
   }
}

 function hasVoted($officeId)
 {
  if(isset($_SESSION['USERNAME'])) {
    $table2 = "voting";
  } else {
    $table2 = "voting2";
  }

 	 $voterId = $_SESSION['user-id'];
 	 $row = select("SELECT * FROM $table2 WHERE voter_id='{voterId}' AND office_id = '{$officeId}'");
 	 if(count($row)>=1){
 	 	return true;
 	 } else{
 	 	return false;
 	 }
 }

/**
*@param table1|voters table, table2|voting table
*@return boolean
*/
 function castVote()
 {
   
       //initialise necessary variables
       $voterId = $_SESSION['user-id'];
       $officeId =$_POST['office-id'];
       $candId   =$_POST['candid'];
       if(isset($_SESSION['USERNAME'])) {
        $table = "voters";
        $table2 = "voting";
      } else {
          $table = "voters2";
          $table2 = "voting2";
      }
       //query tables  
         $office =select("SELECT * FROM offices WHERE id =".$officeId)[0];
           
         $voterInfo = select("SELECT id, votingstatus FROM $table WHERE voterid='".$_SESSION['ID']."'");
           
           //selects data from the offices table
           $offices = select("SELECT * FROM offices");
           
           //selects data from the voting table to check if user has already voted
           $votingInfo = select("SELECT * FROM $table2 WHERE `voter_id`='".$voterId."' AND office_id =
            '".$officeId."'");
           
                if(count($votingInfo)==0) {
                    $votesql ="INSERT INTO $table2(cand_id, voter_id, office_id, dateTime)
       	            VALUES('$candId','".$voterId."', '".$officeId."', NOW())";
                    
                    $update = "UPDATE $table SET votingstatus= votingstatus + 1 WHERE id ='".$voterId."'";

                     $update2 ="UPDATE candidates SET num_votes =num_votes+1 WHERE id ='{$candId}'";

       	     if(mysql_query($votesql)&&mysql_query($update)&&mysql_query($update2)) {
       	     	header("Location: voting.php");
        
              }

            } else { 
                 return false;
         } 
 }



 function clearVoting() 
 { 
    if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
    $table = 'voting';
    $table2 = 'voters';
  } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
      $table = 'voting2';
      $table2 = 'voters2';
  }

    if(mysql_query("DROP TABLE $table")) {

        $sql ="UPDATE candidates SET num_votes=0";
        $sql2="UPDATE $table2 SET status = 0, votingstatus = 0";

        $tablesql ="CREATE TABLE IF NOT EXISTS $table(
          id INT UNSIGNED AUTO_INCREMENT,
          cand_id INT,
          office_id INT,
          voter_id INT,
          dateTime DATETIME,
          PRIMARY KEY(id))";
        if(mysql_query($tablesql) && mysql_query($sql)&&mysql_query($sql2)) {
            return true;
        }
    }
 }
 //clearVoting('voting');
?>