<!-- 22079916, Charles Buenaventura, 13:00 Thursday -->
<!-- ANY USER PAGE -->

<!-- 
the following PHP code segment was modified from "login.php (Lecture 10 - Example Files)" 
Filename and location: "week10-examples.zip > authentication > login.php"
File download: https://vuws.westernsydney.edu.au/bbcswebdav/pid-10092308-dt-content-rid-67965926_1/xid-67965926_1
Website: https://vuws.westernsydney.edu.au/webapps/blackboard/content/listContent.jsp?course_id=_49327_1&content_id=_10092220_1
-->
<?php

require_once("nocache.php");
session_start();
$errorMessage= '';

if (isset($_POST['submit'])) {
	
	if (empty($_POST['username']) || empty($_POST['password'])) {
		$errorMessage = "Please enter both Username and Password";
    } else {
			
		require_once('dbconn.php');

		// clean and prevent injection atk
		$username = $dbConn->escape_string($_POST['username']);
		$password = $dbConn->escape_string($_POST['password']);
		$hashedPassword = hash('sha256', $password);
		
		// from users table, query db
		$sql = "SELECT user_id, first_name, email, last_login, is_admin 
				FROM users
				WHERE email = '$username' and password = '$hashedPassword'";
        $rs = $dbConn->query($sql);
		
		if ($rs->num_rows) {
			
			// store in session
			$user = $rs->fetch_assoc();
            $_SESSION['who'] = $user['email'];
			$_SESSION['privilege'] = $user['is_admin'];
			$_SESSION['user_id'] = $user['user_id']; // save user_id to session
			
			// for nav display
			$_SESSION['first_name'] = $user['first_name'];
			$_SESSION['last_login'] = $user['last_login'];
			
			// USERS redirect to log workout and ADMIN redirect to manage admin
            if ($user['is_admin']) {
                header('Location: manageadmin.php');
            } else {
                header('Location: logworkout.php');
            }
			
		} else {
			$errorMessage = "Invalid Username or Password";
		}
	}
	
	$dbConn->close();
}
?>

<!-- end of code segment from "login.php (Lecture 10 - Example Files)" 
Filename and location: "week10-examples.zip > authentication > login.php"
File download: https://vuws.westernsydney.edu.au/bbcswebdav/pid-10092308-dt-content-rid-67965926_1/xid-67965926_1
Website: https://vuws.westernsydney.edu.au/webapps/blackboard/content/listContent.jsp?course_id=_49327_1&content_id=_10092220_1
-->

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../project/css/project_Master.css">
		<script src="/twa/twa258/project/javascript/project_Script.js"></script>
		<title>Login</title>
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
	
	<h1>Login</h1>
	
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return validateLogin(this);">
	<h2>Please login by entering your Username and Password</h2>
	
        <label for="username">Username:
		<span class="errorMessage" id="usernameError">Username is Required</span>
		</label>
        <input type="text" id="username" name="username"><br><br>
		
        <label for="password">Password:
		<span class="errorMessage" id="passwordError">Password is Required</span>
		</label>
        <input type="password" id="password" name="password"><br><br>
		
        <input type="submit" value="Login" name="submit">
		
		<!-- display error msg when wrong/empty login credentials-->
		<p><?php echo $errorMessage;?></p>
    </form>
	
	<img src="../project/images/login.jpg" alt="Login Vector" style="width: 700px; height: auto;">
	
	</body>
</html>