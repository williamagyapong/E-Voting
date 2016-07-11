<?php
session_start();
  /*
  if(isset($_SESSION['E_ID']))
  {
  	require_once 'helper.php';
	$e_data = getElection($_SESSION['E_ID'])[0];*/
	$mysql_host = '127.0.0.1';
	$mysql_name = 'root';
	$mysql_pass = '';

	@mysql_connect($mysql_host,$mysql_name,$mysql_pass) || die("Could not 
		connect to server. Please check the mysql server connection");
	
	//connects to the selected database
	if(isset($_SESSION['ELECTID'])) {
        
		$mysql_db_name = 'election'.$_SESSION['ELECTID'];
		mysql_select_db($mysql_db_name) || die("database not found");
	}
	

	
	
  //}
	
?>
