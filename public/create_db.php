<?php
 
 
  @mysql_connect("localhost", "root", "") or die("db server not found");
 
        $sql ="CREATE DATABASE IF NOT EXISTS admin_db ";
       if(mysql_query($sql)) {

        mysql_query("USE admin_db");
       
        $elections = "CREATE TABLE IF NOT EXISTS elections(
         elect_id INT UNSIGNED AUTO_INCREMENT ,
         name VARCHAR(100),
         institute VARCHAR(100),
         date_created DATETIME,
         start_time DATETIME, 
         end_time DATETIME,
         PRIMARY KEY(elect_id)
        )"; 
       
        

        $admin ="CREATE TABLE IF NOT EXISTS admin(
          id TINYINT UNSIGNED AUTO_INCREMENT,
          username VARCHAR(20),
          password VARCHAR(100),
          PRIMARY KEY(id))"; 
        if(mysql_query($elections)&& mysql_query($admin)) {
          //echo "The database with all the tables has been created.";
          
           @mysql_select_db("admin_db")or die("attempting to select non existing database");
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