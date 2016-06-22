<?php
require_once'../core/init.php';
// delete a voter upon yes response
 if (isset($_POST['vyes'])) {

 	$id =$_POST['id'];

    $query ="SELECT status, votingstatus, gendar FROM voters WHERE id=".$id;
    $result = mysql_query($query);
    $row =mysql_fetch_assoc($result);
    //makes deletion possible only when voting hasn't started
    if(($row['status']==1)&&($row['votingstatus']!==0)) {
    	if ($row['gendar']=='Male') {
            //post back to the voters' page with male related error
    		header("Location: voters.php?errorm");
    	}
    	elseif ($row['gendar']=='Female') {
            //post back to the voters' page with female related error
    		header("Location:voters.php?errorf");

    	}
    	    } else{ 
    $sql ="DELETE FROM voters WHERE id=".$id;
     if(mysql_query($sql)) {
        //post back to the voters' page with success message
     	header("Location: voters.php?del");
     } else {
        //post back to the voters' page with error message
     	header("Location:voters.php?error2");
     }
    } 
 }

 elseif (isset($_POST['vno'])) {
     header("Location:voters.php");
 }
 //handle deletion of candidates
  elseif (isset($_POST['yes'])) {
     $id =$_POST['id'];

     $candsql ="SELECT num_votes FROM candidates WHERE id=".$id;
     $candresult = mysql_query($candsql);
     $candrow = mysql_fetch_assoc($candresult);
     if($candrow['num_votes']==0) {

        $delsql = "DELETE FROM candidates WHERE id=".$id;
        if (mysql_query($delsql)) {
            header("Location:candidates.php?del");
        } else {
            header("Location:candidates.php?error1");
        }
     } else {
        header("Location: candidates.php?error2");
     }
 } elseif (isset($_POST['no'])) {
     header("Location:candidates.php");
 }
 //delete from offices
 elseif (isset($_POST['offiyes'])) {
    $offi_id = $_POST['id'];
    //checks if voting has started
    
    if(startedVoting()==false) {
         $offisql ="DELETE FROM offices WHERE id =".$offi_id;
         $candDel ="DELETE FROM `candidates` WHERE `office_id`=".$offi_id;
      if (mysql_query($offisql) && mysql_query($candDel)) {
          header("Location:viewoffice.php?deloffi");
      } else {
        header("Location: viewoffice.php?delerror1");
      }
    }
    else {
        header("Location: viewoffice.php?delerror2");
    }
      

 }  elseif (isset($_POST['offino'])) {
          header("Location: viewoffice.php");
      }
?>