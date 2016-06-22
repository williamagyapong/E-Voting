<?php
  /*session_start();
  if(isset($_SESSION['E_ID']))
  {
  	require_once 'helper.php';
	$e_data = getElection($_SESSION['E_ID'])[0];*/
	$mysql_host = '127.0.0.1';
	$mysql_name = 'root';
	$mysql_pass = '';
	$mysql_db_name = 'election';
	//$mysql_db_name = $e_data['dbname'];

	@mysql_connect($mysql_host,$mysql_name,$mysql_pass) || die("Could not 
		connect to server. Please check the mysql server connection");
	mysql_select_db($mysql_db_name) || die("database not found");
  //}
	
?>
