<?php
//@mysql_connect("localhost", "root", "") or die("db server not found");
 //@mysql_select_db("admin_db")or die("attempting to select non existing database");
#using PDO 
$host = '127.0.0.1';
  $db = 'admin_db';
  $user = 'root';
  $password = '';

  try{
          $con = new PDO('mysql:host='.$host.';dbname='.$db, $user, $password);
            //$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
       } catch(PDOException $e) {
           //die($e->getMessage());
           exit();
           //Redirect::to(401);//pass a system failure message
       }

 // functions
function print_array($array)
{
  echo '<pre>',print_r($array, true),'</pre>';die();
}


 function insert($table, array $data, $con)
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
    $query_run = $con->query($sql);

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

 function select($sql,$con)
 {
    $results = [];

    if($queryrun = $con->query($sql))
    {
      return $queryrun->fetchAll();
      /*while($sqlresult = $queryrun->fetchAll())
      {

        $results[] = $sqlresult;
      }*/

    }
    else{
      return "Please make sure to enter the right query statement";
    }
    return $results;
 }



function update( $table, $id, array $data, $con)
 {
    $fieldsValues ="";
    foreach($data as $field =>$value)
    {
       $fieldsValues .= '`'.$field.'`='."'$value',";
    }

    $fieldsValues = rtrim($fieldsValues,",");

    $sql = "UPDATE ". '`'.$table.'` '. "SET ".$fieldsValues." WHERE `elect_id`=".$id;

    if($con->query($sql))
    {
      return true;
    }
 }

 function createElection($con)
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
      ], $con)){

      	//returns the last inserted table id
        return $con->lastInsertId();
    }
}


function createdb($electId,$con)
{     
 
        $electionName = 'election'.$electId;
        $sql ="CREATE DATABASE IF NOT EXISTS $electionName";
       if($con->query($sql)) {

        $con->query("USE $electionName");
       
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

        
        if($con->query($tablesql)&& $con->query($tablesql2)&& $con->query($tablesql3) && $con->query($tablesql4)&& $con->query($tablesql5)&& $con->query($tablesql6)) {
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



function getElection($id="", $con)
{ 
  if($id =="")
  {
     
     return select("SELECT * FROM elections",$con);
  }
 else
 {
   
   return select("SELECT * FROM elections WHERE elect_id = '{$id}'", $con);
 }
}


function destroyElection($con)
{
  if(isset($_SESSION['ELECTID'])) {
     $electId = $_SESSION['ELECTID'];
     $db_name = "election".$_SESSION['ELECTID'];
     $query = "DROP DATABASE $db_name";

     if($con->query($query)) {
        //delete election records in the admin_db database
        $con->query("DELETE FROM elections WHERE elect_id = $electId");
        unset($_SESSION['ELECTID']);
        echo "Election successfully destroyed!";
        
     } else {
       echo "Error destroying election";
     }
  } else {
      echo "No election selected!";
  }
}