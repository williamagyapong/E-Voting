<?php
session_start();
if (isset($_GET['exit'])) {

	unset($_SESSION['ID']);
	unset($_SESSION['user-id']);
//require("config.php");
	
header("Location: login.php" );

	
}
?>