<!-- 22079916, Charles Buenaventura, 13:00 Thursday -->
<!-- ADMIN PAGE -->
<!-- NOTE: unqiue email checker does not work -->

<?php
	require_once("nocache.php");
	session_start();
	
	$errorMessage = '';
	$successMessage = '';
	
	// all pages nav* display
	$username = $_SESSION['first_name'];
	$lastLogin = $_SESSION['last_login'];
	$currentDate = date('Y-m-d H:i:s');

	// if not logged in, logout user
	if (!isset($_SESSION['who'])) {
		// logoff > index page
		header('Location: logoff.php');
	}
	
	// if NOT admin then redirect
	if ($_SESSION['privilege'] != 1) { 
		header('Location: index.html'); 
	} 
	
	require_once('dbconn.php');
	
	if (isset($_POST["submit"])) {
	
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// sanitise 
			$firstname  = htmlspecialchars($_POST['firstname']);
			$lastname = htmlspecialchars($_POST['lastname']);
			$email = htmlspecialchars($_POST['email']);
			$mobile = htmlspecialchars($_POST['mobile']);
			$password = htmlspecialchars($_POST['password']);
			
			if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($mobile)) {
				$errorMessage = "<span>Please fill ALL Mandatory Fields</span>";
			} else {
				// check if email is unique
				$sql = "SELECT user_id FROM users WHERE email = ?";
				$statement = $dbConn->prepare($sql);
				$statement->bind_param("s", $email);
				$statement->execute();
				$statement->store_result();

				if ($statement->num_rows > 0) {
					$errorMessageEmail = "<span>Email invalid, already registered</span>";
				} else {
					$hashedPassword = hash('sha256', $password);

					// insert into user db WITH is_admin set to 1
					$sql = "INSERT INTO users (first_name, last_name, email, mobile, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)";
					$statement = $dbConn->prepare($sql);
					$isAdmin = 1; // Set is_admin to 1 for admin users
					$statement->bind_param("sssssi", $firstname, $lastname, $email, $mobile, $hashedPassword, $isAdmin);

					// dispaly message if error or sucess to user
					if ($statement->execute()) {
						$successMessage = "<span>Administrator account created successfully!</span>";
					} else {
						$errorMessage = "<span>Database error, please try again.</span>";
					}
				}
				$statement->close();
			}
				
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<script src="/twa/twa258/project/javascript/project_Script.js"></script>
		<title>Manage Admin</title>
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
	
	<h1>Create Admin Account</h1>
	
	<form id="manageAdminForm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" onsubmit="return validateFormAdminAndUser(this)">
	<h2>Enter Details</h2>
	
		<label for="firstname">First Name:*
		<span class="errorMessage" id="firstnameError">First Name is Required (Letters only)</span>
		</label>
		<input type="text" id="firstname" name="firstname"><br><br>
		
		<label for="lastname">Last Name:*
		<span class="errorMessage" id="lastnameError">Last Name is Required (Letters only)</span>
		</label>
		<input type="text" id="lastname" name="lastname"><br><br>
		
		<label for="email">Email*
		<span class="errorMessage" id="emailError">Email is Required (Must be unique)</span> 
		</label>
		<input type="text" id="email" name="email"><br><br>
		
		<label for="mobile">Mobile Number:*
		<span class="errorMessage" id="mobileError">Mobile Number is Required (10 digit number only)</span>
		</label>
		<input type="text" id="mobile" name="mobile"><br><br>
		
		<label for="password">Password:*
		<span class="errorMessage" id="passwordError">Password is Required</span>
		</label>
		<input type="text" id="password" name="password"><br><br>
		
		<input type="hidden" name="is_admin" value="1"> <!-- makes the user admin -->
		
		<input type="submit" value="Create" name="submit">
		
		<?php echo $successMessage; ?> 
		<?php echo $errorMessage; ?>
	
	</form>
	
	</body>
</html>