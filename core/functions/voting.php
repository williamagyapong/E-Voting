<?php
 
 function getOffices($id= "*")
 {
 	if($id== "*")
 	{
 		return select("SELECT * FROM offices ORDER BY office ASC");
 	}
 	else
 	{
 		return select("SELECT * FROM offices WHERE id ='$id' ORDER BY office ASC");
 	}
 }

 function getCandidateByOffice($officeid = "*")
 {
    if($officeid== "*")
 	{
 		return select("SELECT * FROM `candidates`");
 	}
 	else
 	{
 		return select("SELECT * FROM `candidates` WHERE `office_id` ='$officeid'");
 	}
 }


 function getCandidateWithOffice()
 {
 	$data = [];
 	$voterId = $_SESSION['user-id'];
 	$row = select("SELECT * FROM `voting` WHERE `voter_id`='$voterId'");
 	foreach($row as $ids)
 	{
 		$data[] = select("SELECT offices.*,candidates.* FROM offices, candidates WHERE candidates.id=".$ids['cand_id']." AND offices.id=".$ids['office_id']);

    if($ids['cand_id']==0) {

       $data[] = select("SELECT * FROM `offices` WHERE `id`=".$ids['office_id']);
    }
 	}

 	return $data;
 }


 function unVotedOffice()
 {
   $data = [];
   $voterId = $_SESSION['user-id'];
   $row = select("SELECT * FROM `voting` WHERE `voter_id`='$voterId' AND `cand_id`=0");
   foreach($row as $id) {
     $data[] = select("SELECT * FROM `offices` WHERE `id`=".$id['office_id']);
   }
   return $data;
 }

 //print_array(getCandidateWithOffice());die();

function voteCast($officeId)
{
	return select("SELECT * FROM `voting` WHERE `office_id`='$officeId' AND `cand_id` !=0");
}
//echo count(voteCast(1));die();
function totalVoters()
{
	return count(select("SELECT * FROM `voters`"));
}

function votedVoters()
{
	return count(select("SELECT * FROM `voters` WHERE `status`=1"));
}

function VotedOffice($officeId)
{
  $voterId = $_SESSION['user-id'];
  return select("SELECT `office_id` FROM `voting` WHERE `voter_id`='{$voterId}' AND `office_id` = '{$officeId}'");
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
 	$row = select("SELECT * FROM `voting`");
 	if(count($row)>0){
 		return true;
 	} else{
 		return false;
 	}

 }

 function hasVoted($officeId)
 {
 	 $voterId = $_SESSION['user-id'];
 	 $row = select("SELECT * FROM voting WHERE voter_id='{voterId}' AND office_id = '{$officeId}'");
 	 if(count($row)>=1){
 	 	return true;
 	 } else{
 	 	return false;
 	 }
 }
/* 
  
*/
 function castVote()
 {
       //initialise necessary variables
       $voterId = $_SESSION['user-id'];
       $officeId =$_POST['office-id'];
       $candId   =$_POST['candid'];
       //query tables  
         $office =select("SELECT * FROM offices WHERE id =".$officeId)[0];
           
         $voterInfo = select("SELECT id, votingStatus FROM voters WHERE voterid='".$_SESSION['ID']."'");
           
           //selects data from the offices table
           $offices = select("SELECT * FROM offices");
           
           //selects data from the voting table to check if user has already voted
           $votingInfo = select("SELECT * FROM `voting` WHERE `voter_id`='".$voterId."' AND office_id =
            '".$officeId."'");
           
                if(count($votingInfo)==0) {
                    $votesql ="INSERT INTO voting(cand_id, voter_id, office_id, dateTime)
       	            VALUES('$candId','".$voterId."', '".$officeId."', NOW())";
                    
                    $update = "UPDATE voters SET votingstatus= votingstatus + 1 WHERE id ='".$voterId."'";

                     $update2 ="UPDATE candidates SET num_votes =num_votes+1 WHERE id ='{$candId}'";

       	     if(mysql_query($votesql)&&mysql_query($update)&&mysql_query($update2)) {
       	     	header("Location: voting.php");
        
              }

            } else { 
                 return false;
         } 
 }
?>