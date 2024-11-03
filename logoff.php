<?php
   require_once("nocache.php");
   session_start();
   
   // check if user logged in
   if (isset($_SESSION['user_id'])) {
	   require_once('dbconn.php');
	   $user_id = $_SESSION['user_id'];
	   
	   $currentDate = date('Y-m-d H:i:s');
	   
	   // save last_login to database
	   $sql = "UPDATE users SET last_login = ? WHERE user_id = ?";
	   $statement = $dbConn->prepare($sql);
	   $statement->bind_param("si", $currentDate, $user_id);
	   $statement->execute();
	   $statement->close();
	   
	   $dbConn->close();
   }
   
   session_destroy();
   header("location: index.html");
?>