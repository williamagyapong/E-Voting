<?php
//candidates registration function
	function  register($fname, $lname, $office, $image)
	{
		//$errors = [];
		if(!empty($lname)&&!empty($fname)&& !empty($image)&& !empty($office))
		{
		  if(uploadImage($image))
		  {

		  	 if(insert('candidates',[
		  	 	'firstname'=>ucwords($fname),
		  	 	'lastname'=>ucwords($lname),
		  	 	'office_id'=>$office,
		  	 	'images'=>$image['name']
		  	 	]))
		  	 {
                return true;
		  	 }
		  	 else
		  	 {
		  	 	return false;
		  	 }
	      } 
	      else 
	      {
	          return false;
	      }   
		}
		else{
           
		      return false;
			}

	} //End of register function


//voter registration function
function register2($fname, $lname, $gender)
{
	//$errors = [];
		if(!empty(trim($lname))&& !empty(trim($fname))&& !empty(trim($gender)))
		{
			//generates voter's id
			$d = date("n").date("d");
			$voterid = $d;
			for($i=0; $i<5; $i++) 
			{ 
				$voterid .= mt_rand(0, 9);	
			}

			$idsql ="SELECT voterid FROM voters WHERE voterid = $voterid";
			$idresult = mysql_query($idsql);
			$idnum =mysql_num_rows($idresult);

			if($idnum>0) {
			   return false;
			}
			else
			{
				if(insert('voters',[
				   'firstname'=>ucwords($fname),
				   'lastname'=>ucwords($lname),
				   'gendar' =>$gender,
				   'voterid'=>$voterid
				]))
				{
					return true;
				}
				else
				{
					return false;
				}
		}

			
		}
		else 
			{
				return false;
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



function isLoggedIn()
{
	return isset($_SESSION['ADMIN']);
}

/*function auth()
{
	if(!isLoggedIn())
		redirect('index');
}*/

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
function getVoter()
{
	$loginId = $_SESSION['user-id'];
	return select("SELECT * FROM voters WHERE id = ".$loginId);
	
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
	       $password =  select("SELECT password FROM users WHERE id =".$userId)[0];
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
                 if(mysql_query("UPDATE users SET password = '".$password_hash."' WHERE id ='".$userId."'"))
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

 function updateStatus()
 {
 	if(mysql_query("UPDATE `voters` SET `status`=1 WHERE `id`=".$_SESSION['user-id']))
 	{
 		mysql_query("UPDATE `offices` SET `status` = 0");

 		return true;
 	}else{
 		return false;
 	}
 }