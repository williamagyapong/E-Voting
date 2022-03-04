<?php

/**
*candidate registration function
*@param string firstname, lastname, office, image
*@return boolean
*/
	function  register($fname, $lname, $office, $image)
	{
		//$errors = [];
		$fname = trim($fname);
	    $lname = trim($lname);
	    $office = trim($office);

		if(!empty($lname)&&!empty($fname)&& !empty($image)&& !empty($office))
		{
			//parameters are not empty

		  if(uploadImage($image))
		  {
		  	//image uploaded; insert data

		  	 if(DB::getInstance()->insert('candidates',[
		  	 	'firstname'=>ucwords($fname),
		  	 	'lastname'=>ucwords($lname),
		  	 	'office_id'=>$office,
		  	 	'images'=>$image['name']
		  	 	]))
		  	 {
		  	 	//data inserted
                return true;
		  	 }
		  	 else
		  	 {
		  	 	//data not inserted
		  	 	return false;
		  	 }
	      } 
	      else 
	      {
	      	  //could not upload image
	          return false;
	      }   
		}
		else{
              //function parameters are empty
		      return false;
			}

	} 

/**
*voter registration function
*@param string firstname, lastname, gender
*@return boolean
*/
function register2($fname, $lname, $gender)
{
	//$errors = [];
	    $fname = trim($fname);
	    $lname = trim($lname);
	    $gender = trim($gender);
		if(!empty($lname)&& !empty($fname)&& !empty($gender))
		{
			//parameters are not empty

			//generates voter's id
			$d = date("n").date("d");
			$voterid = $d;
			for($i=0; $i<5; $i++) 
			{ 
				$voterid .= mt_rand(0, 9);	
			}

			//$idsql ="SELECT voterid FROM voters WHERE voterid = $voterid";
			//$idresult = mysql_query($idsql);
			//$idnum =mysql_num_rows($idresult);
			$idnum = count(DB::getInstance()->get('voters', array('voterid','=',$voterId))->all());

			if($idnum>0) {
			   //voterid already exists
			   return false;
			}
			else
			{
				//voterid has not been taken; insert data
				if(DB::getInstance()->insert('voters',[
				   'firstname'=>ucwords($fname),
				   'lastname'=>ucwords($lname),
				   'gendar' =>ucwords($gender),
				   'voterid'=>$voterid
				]))
				{
					//data was inserted
					return true;
				}
				else
				{
					//data was not inserted
					return false;
				}
		}

			
		}
		else 
			{
				//parameters are empty
				return false;
			}

			
}

function generateId() {
	$voterid = "";
	$d = date("n").date("d");
			$voterid = $d;
			for($i=0; $i<5; $i++) 
			{ 
				$voterid .= mt_rand(0, 9);	
			}
   return $voterid;
}

/**
*voterid generator
*@param
*@return
*/

function createVoters()
{
	$voters = $_POST['voters'];
    $count = 0;

	for($i=1; $i<=$voters; $i++) {
       $voterId = generateId();
       $idExists = DB::getInstance()->select("SELECT voterid FROM voters2 WHERE voterid = $voterId")->all();
       if(empty($idExists)) {
         
          DB::getInstance()->insert('voters2',[
       	       'voterid'=>$voterId
       	  ]);
       	  $count++;
    }
       
	}

	if($count == $voters) {
		return true;
	}
}

/**
* voterLogin function
*@param string $table
*@return 
*/
function voterLogin() {
   if(isset($_POST['login'])) {
	 	 if(empty($_POST['id'])) {
	 	 	echo "<h3>Please enter your voter's id</h3>";
	 	 	return;
	 	 } else{
	 	 	
	 	 	$id = $_POST['id'];
	 	 	//regular voters' data row
            $row = DB::getInstance()->select("SELECT * FROM `voters` WHERE  `voterid` = '$id'")->all();
            //on-the-fly-voters data row
            $row2 = DB::getInstance()->select("SELECT * FROM `voters2` WHERE  `voterid` = '$id'")->all();
            $numRows = count($row);
            $numRows2 = count($row2);

	 	 	  if($numRows==1) {
	 	 	  	  $row = $row[0];
	 	 	  	  if ($row['status']==1) {
	 	 	  	  	 echo "<h2>"."Sorry, you have already voted"."</h2>";
	 	 	  	  	 return;
	 	 	  	  }else {
	 	 	  	 
	 	 	  	$_SESSION['USERNAME'] =$row['firstname'];
	 	 	  	$_SESSION['user-id'] = $row['id'];
	 	 	  	$_SESSION['ID'] =$row['voterid'];

	 	 	  	if ($_SESSION['ID']==TRUE) {

	 	 	  		$voterRow =DB::getInstance()->select("SELECT id FROM voters WHERE voterid='".$_SESSION['ID']."'
	 	 	  		 AND status='0'")->first();
		 

		 $query2 =DB::getInstance()->select("SELECT voter_id FROM voting WHERE voter_id=".$voterRow['id'])->all();
		 $numVoted = count($query2);

		 $query3 = DB::getInstance()->select("SELECT id FROM offices")->all();
		 $numOffices = count($query3);

		          if ($numVoted==$numOffices && $numVoted!=0) {
		             //allows voter to confirm his/her previous votes
		             header("Location: summary.php");
		          }  
		          elseif($numVoted!=$numOffices&& $numVoted!=0){
		          	//allows voter to continue from where he/she stoppped
	 	 	  	    header("Location: voting.php?continue");
	 	 	    }
	 	 	    elseif($numVoted==0){
	 	 	    	//logs the new voter onto the voting page
	 	 	    	$id = $_SESSION['user-id'];
	 	 	      header("Location: voting.php?id=$id");
	 	 	    }
	 	 	} else {
	 	 		// session variable ID doesn't exists
	 	 	}

	 	         }

	 	   } 
	 	   //handle on the fly voter login
	 	   elseif($numRows2==1) {
	 	   	     $row2 = $row2[0];
	 	 	  	 if ($row2['status']==1) {
	 	 	  	  	 echo "<h2>"."Sorry, you have already voted"."</h2>";
	 	 	  	  	 return;
	 	 	  	  }else {
	 	 	  	 
		 	 	  	$_SESSION['user-id'] = $row2['id'];
		 	 	  	$_SESSION['ID'] =$row2['voterid'];

		 	 	  	if ($_SESSION['ID']==TRUE) {

		 	 	  		$voterRow =DB::getInstance()->select("SELECT id FROM voters2 WHERE voterid='".$_SESSION['ID']."'
		 	 	  		 AND status='0'")->first();
			 

			 $query2 =DB::getInstance()->select("SELECT voter_id FROM voting2 WHERE voter_id=".$voterRow['id'])->all();
			 $numVoted = count($query2);

			 $query3 = DB::getInstance()->select("SELECT id FROM offices")->all();
			 $numOffices = count($query3);

			          if ($numVoted==$numOffices && $numVoted!=0) {
			             //allows voter to confirm his/her previous votes
			             header("Location: summary.php");
			          }  
			          elseif($numVoted!=$numOffices&& $numVoted!=0){
			          	//allows voter to continue from where he/she stoppped
		 	 	  	    header("Location: voting.php?continue");
		 	 	    }
		 	 	    elseif($numVoted==0){
		 	 	    	//logs the new voter onto the voting page
		 	 	    	$id = $_SESSION['user-id'];
		 	 	      header("Location: voting.php?id=$id");
		 	 	    }
		 	 	} else {
		 	 		// session variable ID doesn't exists
		 	 	}

		 	         }

		 	   } elseif($numRows==0 && $numRows2==0) {
		 	   	   echo "<h2>Incorrect voter id. Try again.</h2>";
		 	   	   return;
		 	   }
	     }
	}   
}




 function login($username, $password, $table="users")
   
 {
     $errors = array(); // initializes error variable

 	//validates username and password
 	if(empty($username)|| empty($password))
 	{
 		$errors[] = "You forgot to enter username or password";
 	}
 	else{
 		 $username = escape(trim($username));
 		 $password = escape(trim(md5($password)));
 	}
 	      if(empty($errors))// handles user login upon no errors
 	       {
 	         $userData = select("SELECT `id` FROM `$table` WHERE `username`='$username' 
 		               AND password='$password'");
             if(count($userData)==1) // got the right user
             {
             	
                return array(true, $userData);
             } 
             else{
             	$errors[] = "Invalid username or password";
             }
 	    } 
 	    return array(false, $errors);
 }


function changePassword($userId, $prevPass, $newPass1, $newPass2)
		{
			 $msg = [];
			if(empty($prevPass) || empty($newPass1) || empty($newPass2))
			{
				$msg[] = "All fields are required";
			}
			else{
				   // retrieve user previous password
			       $password =  select("SELECT password FROM admin WHERE id =".$userId)[0];
			       
			      if($password['password'] != md5($prevPass))
			       {
                      $msg[] = " Incorrect current password";
			       }

			       if($newPass1 == $newPass2)
			       {
				       	  $passlength = strlen($newPass1);
			       	    if(!($passlength>=5 && $passlength<=20))
			       	    {
			       	    	$msg[] = "New password characters out of required range( 5 - 20 )";
			       	    }
			       	  
			       }
			       else{
			       	     $msg[] = "New passwords do not match";
			       }
			      
		       	 
			          if(count($msg)== 0)
			          {
			          	// no errors 
			          	 $newPass1 = escape($newPass1);
			          	 $password_hash = md5($newPass1);
                         if(mysql_query("UPDATE admin SET password = '".$password_hash."' WHERE id ='".$userId."'"))
                         {
                         	$msg[] = "Password has been successfully updated";
                         }
                         else{
                         	$msg[] = "Unable to save changes";
                         }
			          }

			}
              return $msg;
		}
  

function auth()
{
	if(!isset($_SESSION['ADMIN'])) {
		redirect('index');
	}
}

function auth2()
{
	if(!isset($_SESSION['user-id'])) {
		redirect('login');
	}
}

function getVoter($table,$id=null)
{
	
	if($id) {
		
		return DB::getInstance()->select("SELECT * FROM $table WHERE id = ".$id)->first();
	}else {
		$loginId = $_SESSION['user-id'];
		return DB::getInstance()->select("SELECT * FROM $table WHERE id = ".$loginId)->first();
	}
	
	
}

/**
*retrieve available candidates or specific candidate 
*@param 
*@return array
*/
function getCandidate($id = null)
{

   if($id) {
		
		return DB::getInstance()->select("SELECT offices.office,candidates.* FROM offices, candidates WHERE candidates.id = $id AND candidates.office_id= offices.id")->first();
	}else {

		return DB::getInstance()->select("SELECT offices.office,candidates.* FROM offices, candidates WHERE candidates.office_id= offices.id")->all();
	}
}
//print_array(getCandidate(3)); die();
/**
*retrieve available offices or specific office
*@param 
*@return array
*/
function getOffices($id= "*")
 {
 	if($id== "*")
 	{
 		return DB::getInstance()->select("SELECT * FROM offices ORDER BY office ASC")->all();
 	}
 	else
 	{
 		return DB::getInstance()->select("SELECT * FROM offices WHERE id ='$id' ORDER BY office ASC")->first();
 	}
 }

/**
*retrieve candidates by the office specified
*@param 
*@return array
*/
 function getCandidateByOffice($officeid = "*")
 {
    if($officeid== "*")
 	{
 		return DB::getInstance()->get('candidates', array())->all();
 	}
 	else
 	{
 		return DB::getInstance()->select("SELECT * FROM `candidates` WHERE `office_id` ='$officeid'")->all();
 	}
 }

/**
*retrieve candidates the active voter voted for
*@param 
*@return array
*/
 function getCandidateWithOffice()
 {
 	$data = [];
 	$voterId = $_SESSION['user-id'];
  if(isset($_SESSION['USERNAME'])) {
    $table2 = "voting";
  } else {
    $table2 = "voting2";
  }
 	$row = DB::getInstance()->select("SELECT * FROM $table2 WHERE `voter_id`='$voterId'")->all();
 	foreach($row as $ids)
 	{
 		$data[] = DB::getInstance()->select("SELECT offices.*,candidates.* FROM offices, candidates WHERE candidates.id=".$ids['cand_id']." AND offices.id=".$ids['office_id'])->first();

    if($ids['cand_id']==0) {

       $data[] = DB::getInstance()->select("SELECT * FROM `offices` WHERE `id`=".$ids['office_id'])->all();
    }
 	}

 	return $data;
 }


 function updateStatus($table)
 {
 	if(DB::getInstance()->update($table, $_SESSION['user-id'], ['status'=>1]))
 	{

 		return true;

 	}else{
 		
 		return false;
 	}
 }

