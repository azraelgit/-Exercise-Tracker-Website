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

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<title>Workout Hisory</title>
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
			
			<div style="float: left;">
				<p>Welcome <?php echo $username; ?>!</p>
				<p>Current Date: <?php echo $currentDate; ?></p>
				<p>Last Login: <?php echo $lastLogin; ?></p>
			</div>
		</nav>
	</header>
	
	<h1>Workout History</h1>
	
	<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<h2>Filter Results</h2>
	
		<label for="filterWorkoutDate">Filter by Date:</label>
		<input type="date" id="filterWorkoutDate" name="filterWorkoutDate">
		
		<br><br>
		
		<label for="filterExercise">Filter by Exercise:</label>
		<select id="filterExercise" name="filterExercise">
			<option value="">All Exercises</option>
			<option value="1">Walking</option>
			<option value="2">Running</option>
			<option value="3">Cycling</option>
		</select>
		
		<br><br>
		
		<label for="sortBy">Sort by:</label>
		<select id="sortBy" name="sortBy">
			<option value="workout_date">Date</option>
			<option value="exercise_id">Exercise ID</option>
			<option value="duration">Duration</option>
			<option value="distance">Distance</option>
		</select>
		
		<br><br>
		
		<input type="radio" id="sortAsc" name="sortOrder" value="ASC" checked>
		<label for="sortAsc">Ascending</label>
		
		<br><br>
		
		<input type="radio" id="sortDesc" name="sortOrder" value="DESC">
		<label for="sortDesc">Descending</label>
		
		<br><br>
		
		<input type="submit" value="Apply Filters">
	</form>
	
	<br><br>
	
	</body>
</html>

<?php

	// FILTERS and SORTING
	// initialise empty string
	$filterWorkoutDate = '';
	$filterExercise = '';
	$sortBy = '';
	$sortOrder = '';
	$filterSQLWhere = ''; 

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		require_once("dbconn.php");
		
		// retrieve
		$filterWorkoutDate = $_POST['filterWorkoutDate']; 
		$filterExercise = $_POST['filterExercise'];
		$sortBy = $_POST['sortBy'];
		$sortOrder = $_POST['sortOrder'];
		
		// SQL WHERE filter to dynamically change
		if (!empty($filterWorkoutDate)) {
			$filterSQLWhere .= " AND workout_date = '$filterWorkoutDate'";
		}
		if (!empty($filterExercise)) {
			$filterSQLWhere .= " AND exercise_id = '$filterExercise'";
		}
	}

	// dynamic query
	$sql = "SELECT workout_date, exercise_id, duration, distance, notes
			FROM workout
			WHERE user_id = $user_id $filterSQLWhere
			ORDER BY $sortBy $sortOrder"; 

	$result = $dbConn->query($sql);

	// workout history table (head)
	if ($result->num_rows > 0) {
		echo "<div class='tableStyle'><table border='2'>
				<tr>
					<th>Date</th>
					<th>Exercise ID</th>
					<th>Duration</th>
					<th>Distance</th>
					<th>Notes</th>
				</tr>";
				
		// workout history cells (data records)
		while ($row = $result->fetch_assoc()) {
			echo "<tr>
					<td>{$row['workout_date']}</td>
					<td>{$row['exercise_id']}</td>
					<td>{$row['duration']}</td>
					<td>{$row['distance']}</td>
					<td>{$row['notes']}</td>
				  </tr>";
		}

		echo "</table></div>";
	} else {
		
		// if num_rows > 0 show no workout history
		echo "No workout history available.";
	}

	$dbConn->close();
	
?>