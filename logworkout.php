<!-- 22079916, Charles Buenaventura, 13:00 Thursday -->
<!-- MEMBER PAGE -->
<!-- to note: $errorMessage do not display for server-side validation, sorry i'm not sure how what the issue is -->

<!-- checker + server validation -->

<?php

	require_once("nocache.php");
	session_start();

	// if not logged in, logout user
	if (!$_SESSION['who']) {
		// logoff > index page
		header('Location: logoff.php');
	}
	
	// serverside php validation 

	$errorMessageValidation = '';
	$successMessageValidation = '';
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") { 
		require_once("dbconn.php");
		$user_id = $_SESSION['user_id'];
		
		// sanitise
		$date = htmlspecialchars($_POST['date']);
		$exercise = htmlspecialchars($_POST['exercise']);
		$duration = htmlspecialchars($_POST['duration']);
		$distance = htmlspecialchars($_POST['distance']);
		$notes = htmlspecialchars($_POST['notes']);

		if (empty($_POST['date']) || empty($_POST['exercise']) || empty($_POST['duration']) || empty($_POST['distance'])) {
			$errorMessageValidation = "Please fill out ALL required fields";
		} else {
			$exercise_id = translateExerciseID($exercise);
			
			// prepared sql statement
			$sql = "INSERT INTO workout (user_id, workout_date, exercise_id, duration, distance, notes) VALUES (?, ?, ?, ?, ?, ?)";
			$statement = $dbConn->prepare($sql);
			// int str int int int str
			$statement->bind_param("isiiis", $user_id, $date, $exercise_id, $duration, $distance, $notes);
			
			if ($statement->execute()) {
				$successMessageValidation = "Log Workout recorded Successfully!";
			} else {
				$errorMessageValidation = "ERROR inserting record" . $statement->error;
			}

			$statement->close();
		}

		$dbConn->close();
	}
	
	// translates form string value into no. for sql to work
	function translateExerciseID($exercise) {
		// array to change string to num
		$exerciseNumValue = ["Walking" => 1, "Running" => 2, "Cycling" => 3];
		return $exerciseNumValue[$exercise] ?? 0;
	}
	
	// all pages nav* display
	$username = $_SESSION['first_name'];
	$lastLogin = $_SESSION['last_login'];
	$currentDate = date('Y-m-d H:i:s');

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<script src="/twa/twa258/project/javascript/project_Script.js"></script>
		<title>Log Workout</title>
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
				<li><a href="statistics.php">Statistics</a></li>
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
	
	<!-- form -->
	<h1>Log Workout</h1>
	
	<form id="logWorkoutForm" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" onsubmit="return validateWorkoutForm(this)">
	<h2>Fill in Workout details below</h2>
		
        <label for="date">Date:*
		<span class="errorMessage" id="dateError">Select a date (Select a valid date)</span>
		</label>
        <input type="datetime-local" id="date" name="date"><br><br>
        
        <label for="exercise">Type of Exercise:*
		<span class="errorMessage" id="exerciseError">Select a type of Exercise</span>
		</label>
        <select id="exercise" name="exercise">
			<option value="">Select an option</option>
			<option value="Walking">Walking</option>
			<option value="Running">Running</option>
			<option value="Cycling">Cycling</option>
		</select>
		
		<br><br>
        
        <label for="duration">Duration (minutes):*
		<span class="errorMessage" id="durationError">Duration is required (Please use numbers only)</span>
		</label>
        <input type="text" id="duration" name="duration"><br><br>
        
        <label for="distance">Distance (km):*
		<span class="errorMessage" id="distanceError">Distance is required (Please use numbers only)</span>
		</label>
        <input type="text" id="distance" name="distance"><br><br>
        
        <label for="notes">Workout Notes:</label>
        <textarea id="notes" name="notes"></textarea><br><br>
       
        <input type="submit" value="Submit Workout" name="workoutSubmit"> <?php echo $successMessageValidation?>
		<?php echo $errorMessageValidation?>
    </form>
	
	<img src="../project/images/exerciseLogo.jpg" alt="Couple Exercising" style="width: 700px; height: auto;">
	
	</body>
</html>
