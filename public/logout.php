<?php
session_start();
if (isset($_GET['exit'])) {

	unset($_SESSION['ID']);
	unset($_SESSION['user-id']);

	if(isset($_SESSION['USERNAME'])) {
		
		unset($_SESSION['USERNAME']);
	}
//require("config.php");
	
header("Location: login.php" );

	
} elseif(isset($_GET['close'])) {
	unset($_SESSION['ELECTID']);

	header("Location: dashboard.php");
}

?>