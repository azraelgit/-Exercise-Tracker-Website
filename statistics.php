<!-- 22079916, Charles Buenaventura, 13:00 Thursday -->
<!-- MEMBER PAGE -->

<?php
	require_once("nocache.php");
	session_start();
	
	// all pages nav* display
	$username = $_SESSION['first_name'];
	$lastLogin = $_SESSION['last_login'];
	$currentDate = date('Y-m-d H:i:s');
	
	// if not logged in, logout user
	if (!isset($_SESSION['who'])) {
		// logoff > index page
		header('Location: logoff.php');
	}

	$user_id = $_SESSION['user_id']; 
	
	
	require_once('dbconn.php');
	
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<title>Statistics</title>
	</head>
	
	<body>
	
	<header>
		<nav>
			<img src="../project/images/exercisevector.png" alt="Exercise Logo">
			<strong>Exercise Tracker</strong>
			<ul>
				<li><a href="index.html">Index</a></li>
				<li><a href="userregistration.php">User Registration</a></li>
				<li><a href="logworkout.php">Log Workout</a></li>
				<li><a href="workouthistory.php">Workout History</a></li>
				<li><a href="login.php">Login</a></li>
				<li><a href="logoff.php">Log Off</a></li>
			</ul>
		</nav>
	</header>
	
	<h1>Workout Statistics</h1>
	
	<h2> Total Statistics</h2>
	<table>
		<tr>
			<th>Exercise Type</th>
			<th>Average Duration (minutes)</th>
			<th>Average Distance (km)</th>
		</tr>
	</table>
	
	</body>
</html>