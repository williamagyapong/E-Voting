<?php
@mysql_connect("localhost", "root", "") or die("db server not found");
 @mysql_select_db("admin_db")or die("attempting to select non existing database");


 // functions
function print_array($array)
{
  echo '<pre>',print_r($array, true),'</pre>';
}


 function insert($table, array $data)
 {
 	          // builds  query statement
 	  $fields = '';

    $values = '';

    foreach ($data as $key => $value) 
    {
       $fields .= '`'.$key.'`,';
       if(is_numeric($value))
        $values .= $value.',';
      else
        $values .= "'".$value."',";
    }    

    $fields = rtrim($fields, ',');
    $values = rtrim($values, ',');

    $sql = 'INSERT INTO '.'`'.$table.'` '.'('.$fields.') VALUES ('.$values.')';

    // runs the query against database
    $query_run = mysql_query($sql);

    if ($query_run) 
    {
      return true;
    }
    else
    {
       return false;
    }
       
     
 } //end of insert function


// select function begins here

 function select($sql)
 {
    $results = [];

    if($queryrun = mysql_query($sql))
    {
      while($sqlresult = mysql_fetch_assoc($queryrun))
      {

        $results[] = $sqlresult;
      }

    }
    else{
      return "Please make sure to enter the right query statement";
    }
    return $results;
 }

function update( $table, $id, array $data)
 {
    $fieldsValues ="";
    foreach($data as $field =>$value)
    {
       $fieldsValues .= '`'.$field.'`='."'$value',";
    }

    $fieldsValues = rtrim($fieldsValues,",");

    $sql = "UPDATE ". '`'.$table.'` '. "SET ".$fieldsValues." WHERE `elect_id`=".$id;

    if(mysql_query($sql))
    {
      return true;
    }
 }

 function createElection()
{   
   
    $name        = ucwords($_POST['name']);
    $institution = ucwords($_POST['institute']);
    $voters      = $_POST['voters'];
    $date = date('Y-m-d H:i:s');
    
    if(insert('elections',
      [
               'name'=>$name,
               'institute'=>$institution,
               'voters'=>$voters,
               'date_created'=>$date
      ])){

      	//returns the last inserted table id
        return mysql_insert_id();
    }
}


function createdb($electId)
{     
 
        $electionName = 'election'.$electId;
        $sql ="CREATE DATABASE IF NOT EXISTS $electionName";
       if(mysql_query($sql)) {

        mysql_query("USE $electionName");
       
        $tablesql ="CREATE TABLE IF NOT EXISTS offices(
          id INT UNSIGNED AUTO_INCREMENT,
          office VARCHAR(40),
          status VARCHAR(10) DEFAULT'0', 
          PRIMARY KEY(id))";
      
        
        $tablesql2 ="CREATE TABLE IF NOT EXISTS candidates(
        id INT  UNSIGNED AUTO_INCREMENT,
        firstName VARCHAR(20),
        lastName VARCHAR(20),
        office_id INT,
        images VARCHAR(100),
        num_votes VARCHAR(10) DEFAULT'0',
        PRIMARY KEY(id))";

        $tablesql3 ="CREATE TABLE IF NOT EXISTS voters(
          id INT UNSIGNED AUTO_INCREMENT,
          firstname VARCHAR(20),
          lastname VARCHAR(20),
          voterid VARCHAR(10),
          votingstatus VARCHAR(10) DEFAULT'0',
          status VARCHAR(5) DEFAULT'0',
          gendar VARCHAR(16),
          PRIMARY KEY(id))";

         $tablesql4 ="CREATE TABLE IF NOT EXISTS voters2(
          id INT UNSIGNED AUTO_INCREMENT,
          voterid VARCHAR(10),
          votingstatus VARCHAR(10) DEFAULT'0',
          status VARCHAR(5) DEFAULT'0',
          PRIMARY KEY(id))";
          
        $tablesql5 ="CREATE TABLE IF NOT EXISTS voting(
          id INT UNSIGNED AUTO_INCREMENT,
          cand_id INT,
          office_id INT,
          voter_id INT,
          dateTime DATETIME,
          PRIMARY KEY(id))";

          $tablesql6 ="CREATE TABLE IF NOT EXISTS voting2(
          id INT UNSIGNED AUTO_INCREMENT,
          cand_id INT,
          office_id INT,
          voter_id INT,
          dateTime DATETIME,
          PRIMARY KEY(id))";

        
        if(mysql_query($tablesql)&& mysql_query($tablesql2)&& mysql_query($tablesql3) && mysql_query($tablesql4)&& mysql_query($tablesql5)&& mysql_query($tablesql6)) {
          return true;
      }

   }
}


function auth()
{
  if(!isset($_SESSION['ADMIN'])) {
    header("Location:index.php");
  }
}



function getElection($id="")
{ 
  if($id =="")
  {
     
     return select("SELECT * FROM elections");
  }
 else
 {
   
   return select("SELECT * FROM elections WHERE elect_id = '{$id}'");
 }
}


function destroyElection()
{
  if(isset($_SESSION['ELECTID'])) {
     $electId = $_SESSION['ELECTID'];
     $db_name = "election".$_SESSION['ELECTID'];
     $query = "DROP DATABASE $db_name";

     if(mysql_query($query)) {
        //delete election records in the admin_db database
        mysql_query("DELETE FROM elections WHERE elect_id = $electId");
        unset($_SESSION['ELECTID']);
        echo "Election successfully destroyed!";
        
     } else {
       echo "Error destroying election";
     }
  } else {
      echo "No election selected!";
  }
}