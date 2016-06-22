
<?php
 //insert function begins here
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


function createadmindb()
{
       //mysql_query("UPDATE settings SET counter = counter+1");
        $sql ="CREATE DATABASE IF NOT EXISTS admin ";
       if(mysql_query($sql)) {

        mysql_query("USE admin");
        $tablesql ="CREATE TABLE IF NOT EXISTS admin(
          id TINYINT UNSIGNED AUTO_INCREMENT,
          username VARCHAR(20),
          password VARCHAR(10),
          PRIMARY KEY(id))"; 

          $table2sql ="CREATE TABLE IF NOT EXISTS settings(
          id TINYINT UNSIGNED AUTO_INCREMENT,
          counter VARCHAR(20) DEFAULT'0',
          PRIMARY KEY(id))"; 

          $table3sql ="CREATE TABLE IF NOT EXISTS elections(
          id TINYINT UNSIGNED AUTO_INCREMENT,
          name VARCHAR(100) ,
          etime DATETIME,
          db_name VARCHAR(16),
          PRIMARY KEY(id))"; 

        if(mysql_query($tablesql)&&mysql_query($table2sql)&&mysql_query($table3sql)) {
          //echo "The database with all the tables has been created.";
          
          mysql_select_db("admin");
          $sql = "SELECT * FROM  admin";
          $result = mysql_query($sql);
          $numrow = mysql_num_rows($result);
          if ($numrow==0) {
            $adminsql ="INSERT INTO admin(username, password)
             VALUES('willisco', 'willi0010'),('admin1', '234546'),('admin2', '237283') ,
             ('admin3', '238798'),('admin4','235768')";
             mysql_query($adminsql);
          } else{
             echo "Could not establish admin credentials";
          }
           
        } else {
          echo "unable to create database";
        }
       
      }

}

function createdb()
{     
      mysql_select_db("admin");

      $num = select("SELECT * FROM elections");
      print_array($num); die();
      $dbname = "election".$num['counter'];


      $sql ="CREATE DATABASE IF NOT EXISTS $dbname ";
       if(mysql_query($sql)) {

        mysql_query("USE $dbname");
        $tablesql ="CREATE TABLE IF NOT EXISTS offices(
          id INT UNSIGNED AUTO_INCREMENT,
          office VARCHAR(40),
          PRIMARY KEY(id))";
      //mysql_query($tablesql);die("success");
        
        $tablesql2 ="CREATE TABLE IF NOT EXISTS candidates(
        id INT  UNSIGNED AUTO_INCREMENT,
        firstName VARCHAR(20),
        lastName VARCHAR(20),
        office_id INT,
        images VARCHAR(50),
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
        $tablesql4 ="CREATE TABLE IF NOT EXISTS voting(
          id INT UNSIGNED AUTO_INCREMENT,
          cand_id INT,
          office_id INT,
          voter_id INT,
          dateTime DATETIME,
          PRIMARY KEY(id))";
        $tablesql5 ="CREATE TABLE IF NOT EXISTS admin(
          id TINYINT UNSIGNED AUTO_INCREMENT,
          username VARCHAR(20),
          password VARCHAR(10),
          PRIMARY KEY(id))"; 
        if(mysql_query($tablesql)&& mysql_query($tablesql2)&& mysql_query($tablesql3) &&
          mysql_query($tablesql4)&& mysql_query($tablesql5)) 
        { 
           return true;
          //echo "The database with all the tables has been created.";
           
        } else {
          echo "unable to create database";
        }
       
      }
}

function createElection()
{   
   
    $name = $_POST['ename'];
    $time = $_POST['etime'];
    
    mysql_select_db("admin");
    if(insert('elections',
      [
               'name'=>$name,
               'etime'=>$time
      ])){
      echo "Election has been succefully created";
    }
}

function getElection($id="")
{ 
  if($id =="")
  {
     mysql_select_db("admin");
     return select("SELECT * FROM elections");
  }
 else
 {
   mysql_select_db("admin");
   return select("SELECT * FROM elections WHERE id = '$id'");
 }
}
?>
