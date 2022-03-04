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
	return count(DB::getInstance()->select("SELECT * FROM $table WHERE `office_id`='$officeId' AND `cand_id` !=0")->all());
}


//echo count(voteCast(1));die();
function totalVoters()
{
  if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
      $table = 'voters';
  } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
      $table = 'voters2';
  }
	return count(DB::getInstance()->get($table, array())->all());
}


function numVoted() 
{
  
  $loginId = $_SESSION['user-id'];
  if(isset($_SESSION['USERNAME'])) {
    $table = "voters";
  } else {
    $table = "voters2";
  }

  $row = DB::getInstance()->select("SELECT * FROM $table WHERE id = ".$loginId)->all();
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
  

	return count(DB::getInstance()->select("SELECT * FROM $table WHERE `status`=1")->all());
}

function VotedOffice($officeId)
{
  if(isset($_SESSION['USERNAME'])) {
    $table = "voting";
  } else {
    $table = "voting2";
  }

  $voterId = $_SESSION['user-id'];
  return DB::getInstance()->select("SELECT `office_id` FROM $table WHERE `voter_id`='{$voterId}' AND `office_id` = '{$officeId}'")->all();
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
 	$row = DB::getInstance()->select("SELECT id FROM $table")->all();
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
 	 $row = DB::getInstance()->select("SELECT * FROM $table2 WHERE voter_id='{$voterId}' AND office_id = '{$officeId}'")->all();
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
         $office =DB::getInstance()->select("SELECT * FROM offices WHERE id =".$officeId)->first();
           
         $voterInfo = DB::getInstance()->select("SELECT id, votingstatus FROM $table WHERE voterid='".$_SESSION['ID']."'")->all();
           
           //selects data from the offices table
           $offices = DB::getInstance()->get("offices", array())->all();
           
           //selects data from the voting table to check if user has already voted
           $votingInfo = DB::getInstance()->select("SELECT * FROM $table2 WHERE `voter_id`='".$voterId."' AND office_id =
            '".$officeId."'")->all();
           
                if(count($votingInfo)==0) {
                    $inserted = DB::getInstance()->insert($table2, [
                                                                      'cand_id'=>$candId,
                                                                      'voter_id'=>$voterId,
                                                                      'office_id'=>$officeId,
                                                                      'dateTime'=>date('Y-m-d H:i:s')
                                                                   ]);
                    
                    $updated = DB::getInstance()->update2($table,['id'=>$voterId], ['votingstatus'=>1], '+');
                    $updated2 = DB::getInstance()->update2('candidates',['id'=>$candId], ['num_votes'=>1], '+');

       	     if($inserted&&$updated&&$updated2) {
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

    if(!DB::getInstance()->query("DROP TABLE $table")->getError()) {
        $updated = DB::getInstance()->query("UPDATE candidates SET num_votes=0")->getError();
        $updated2 = DB::getInstance()->query("UPDATE $table2 SET status = 0, votingstatus = 0")->getError();

        $tablesql ="CREATE TABLE IF NOT EXISTS $table(
          id INT UNSIGNED AUTO_INCREMENT,
          cand_id INT,
          office_id INT,
          voter_id INT,
          dateTime DATETIME,
          PRIMARY KEY(id))";
        if(!DB::getInstance()->query($tablesql)->getError() && $updated&&$updated2) {
            
            return true;
        }
    }
 }
 //clearVoting('voting');
?>