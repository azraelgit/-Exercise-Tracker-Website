<!-- 22079916, Charles Buenaventura, 13:00 Thursday -->
<!-- ANY PAGE -->
<!-- to note: $errorMessage and $errorMessageEmail do not display for server-side validation, sorry i'm not sure how what the issue is -->

<?php
	require_once("nocache.php");
	$errorMessage = '';
	$errorMessageEmail = '';
	
	if (isset($_POST['submit'])) {
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			require_once('dbconn.php');
			
			// sanitise 
			$firstname  = htmlspecialchars($_POST['firstname']);
			$lastname = htmlspecialchars($_POST['lastname']);
			$email = htmlspecialchars($_POST['email']);
			$mobile = htmlspecialchars($_POST['mobile']);
			$password = htmlspecialchars($_POST['password']);
			
			// not required
			$age = htmlspecialchars($_POST['age']);
			$weight = htmlspecialchars($_POST['weight']);
			$height = htmlspecialchars($_POST['height']);
			
			if (empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
				$errorMessage = "<span>Please fill ALL Mandatory Fields</span>";
			} else {
				// check email is unique
				$sql = "SELECT user_id FROM users WHERE email = ?";
				$statement = $dbConn->prepare($sql);
				$statement->bind_param("s", $email);
				$statement->execute();
				$statement->store_result();
				
				// check email is unique
				if ($statement->num_rows > 0) {
					$errorMessageEmail = "<span>Email invalid, already registered</span>";
				} else {
					$hashedPassword = hash('sha256', $password);
					// insert into user db
					$sql = "INSERT INTO users (first_name, last_name, email, mobile, password, age, height, weight, is_admin, date_registered) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, NOW())";
					$statement = $dbConn->prepare($sql);
					$statement = $dbConn->prepare($sql);
					// str str... double for weight because "float" type in database
					$statement->bind_param("sssssiid", $firstname, $lastname, $email, $mobile, $hashedPassword, $age, $height, $weight);

					if ($statement->execute()) {
						// redirect to the login page if successful
						header('Location: login.php');
					} else {
						//$errorMessage = "<span>Please fill ALL Mandatory Fields</span>";
					}
				}
				$statement->close();
			}
			$dbConn->close();
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<script src="/twa/twa258/project/javascript/project_Script.js"></script>
		<title>Title</title>
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
	
	<h1>User Registration</h1>
	
	<form id="userRegistrationForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateFormAdminAndUser(this)">
	<h2>Registration Form</h2>
	
		<label for="firstname">First Name:*
		<span class="errorMessage" id="firstnameError">First Name is Required (Letters only)</span>
		</label>
		<input type="text" id="firstname" name="firstname"><br><br>
		
		<label for="lastname">Last Name:*
		<span class="errorMessage" id="lastnameError">Last Name is Required (Letters only)</span>
		</label>
		<input type="text" id="lastname" name="lastname"><br><br>
		
		<label for="password">Password:*
		<span class="errorMessage" id="passwordError">Password is Required</span>
		</label>
		<input type="text" id="password" name="password"><br><br>
		
		<label for="email">Email*
		<span class="errorMessage" id="emailError">Email is Required (Must be unique)</span> 
		<!-- display email not unique msg -->
		<?php echo $errorMessageEmail; ?>
		</label>
		<input type="text" id="email" name="email"><br><br>
		
		<label for="mobile">Mobile Number:*
		<span class="errorMessage" id="mobileError">Mobile Number is Required (10 digit number only)</span>
		</label>
		<input type="text" id="mobile" name="mobile"><br><br>
		
		<!-- not required -->
		
		<label for="age">Age:</label>
		<input type="text" id="age" name="age"><br><br>
		
		<label for="weight">Weight:</label>
		<input type="text" id="weight" name="weight"><br><br>
		
		<label for="height">Height:</label>
		<input type="text" id="height" name="height"><br><br>
	
		<input type="submit" value="Register" name="submit">
		
		<?php echo $errorMessage; ?>
	
	</form>
	</body>
</html>