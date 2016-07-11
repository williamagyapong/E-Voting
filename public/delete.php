<?php
/*
*this page handles deletions
*the page never displays to the user hence no html needed
*/
require_once'../core/init.php';
// delete a voter upon yes response
 if (isset($_POST['vyes'])) {

     if(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="regular")) {
       $table = "voters";
   } elseif(isset($_SESSION['V-TYPE']) && ($_SESSION['V-TYPE']=="non-regular")) {
     $table = "voters2";
   }
    $id =$_POST['id'];
 	
    //allow deletion only when voting hasn't started
    if(startedVoting()==true) {
    	 header("Location: voters.php?error");
    } else{ 
    $sql ="DELETE FROM $table WHERE id=".$id;
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

     
     if(startedVoting() == false) {

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