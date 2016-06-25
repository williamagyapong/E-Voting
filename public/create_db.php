<?php
 
 
  $db=mysql_connect("localhost", "root", "");
 
        $sql ="CREATE DATABASE IF NOT EXISTS election ";
       if(mysql_query($sql)) {

        mysql_query("USE election");
       
        $elections = "CREATE TABLE IF NOT EXISTS elections(
         elect_id INT UNSIGNED AUTO_INCREMENT ,
         name VARCHAR(100),
         institute VARCHAR(100),
         date_created DATETIME,
         start_time DATETIME, 
         end_time DATETIME,
         PRIMARY KEY(elect_id)
        )"; 
       
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
          password VARCHAR(100),
          PRIMARY KEY(id))"; 
        if(mysql_query($tablesql)&& mysql_query($tablesql2)&& mysql_query($tablesql3) && mysql_query($elections)&&
          mysql_query($tablesql4)&& mysql_query($tablesql5)) {
          //echo "The database with all the tables has been created.";
          
           require'../core/init.php';
          $sql = "SELECT * FROM  admin";
          $result = mysql_query($sql);
          $numrow = mysql_num_rows($result);

          $pass1 = md5("willi0010");
          $pass2 = md5("234546");
          $pass3 = md5("237283");
          $pass4 = md5("238798");
          $pass5 = md5("235768");
          
          if ($numrow==0) {
            $adminsql ="INSERT INTO admin(username, password)
             VALUES('willisco', '{$pass1}'),('admin1', '{$pass2}'),('admin2', '{$pass3}') ,
             ('admin3', '{$pass4}'),('admin4','{$pass5}')";
             mysql_query($adminsql);
          } else{
              //echo "Could not establish admin credentials";
          }
           
        } else {
          echo "unable to create database";
        }
       
      }


 
?>