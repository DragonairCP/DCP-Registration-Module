<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration Code</title>

</head>

<body>

<?php   ////////////////////////////
    		//		  Registration      //
    		////////////////////////////
    
    	
    		// Functions //
    	
    		if (isset($_POST['submit'])) { 
    		session_start();
    		
    		// Loading assets...
    		$connectHost = "127.0.0.1"; //MySQL Host. Leave this as 127.0.0.1. If this doesn't work, use the given IP of your webserver.
    		$connectUser = "root"; //MySQL User
    		$connectPass = ""; //MySQL User Password
    		$connectDatabase = "database"; //Name of Database
    		$connectUserTable = "users"; //Name of Table
    		
    		$con = new mysqli($connectHost,$connectUser,$connectPass,$connectDatabase);
    		
    		if (mysqli_connect_errno()) {
    			echo "<center><h2>Register Not Available</h2><h3>The website cannot communicate with the server. Please check back - sorry!</h3></center>";
    		}		
    		// And the loading has finished.
    		
    		// Loading messages...
    		$promptAlreadyExistsUser = "<strong>Error</strong>: This user already exists or is banned!";
    		$promptInvalidPass = "<strong>Error</strong>: Your passwords do not match.";
    		$promptFieldEmpty = "<strong>Error</strong>: Please enter all fields.";
    		$promptAlreadyExistsEmail = "<strong>Error</strong>: This email already belongs to a registered user.";
    		/* Custom website prompt. */ $promptAlreadyExistsGT = "<strong>Error</strong>: This gamertag already belongs to a registered user.";
    		$promptNoUser = "<strong>Error</strong>: Your username is invalid. It can only have letters and numbers.";
    		$promptIPBAN = "<strong>Error</strong>: Your IP has already been registered. If you believe this was a mistake, please contact the staff.";
    		$promptSuccess = "Success! You can now use our website!";
    		$promptBacklink = "<a href='javascript:history.go(-1)'>Return to previous page...</a>";
    		/* $promptPlaylink = "<a href=''>Click here to play!</a>"; */
    		$promptIncorrectCA = "<strong>Error</strong>: You provided the wrong answer to the CAPTCHA. The <b>sum</b> is the result of adding two numbers.";
    		// Done!
    		
    		// Protection
    		
    		$_POST['username'] =  mysqli_real_escape_string($con, $_POST['username']);
    		$_POST['email'] =  mysqli_real_escape_string($con, $_POST['email']);
    		$_POST['password'] =  mysqli_real_escape_string($con, $_POST['password']);
    		$_POST['passwordconfirm'] =  mysqli_real_escape_string($con, $_POST['passwordconfirm']);
    		$_POST['gamertag'] =  mysqli_real_escape_string($con, $_POST['gamertag']);
    	
    		// Form Classes
    		$registerUser = $_POST['username'];
    		$registerEmail = $_POST['email'];
    		$registerPass = $_POST['password'];
    		$registerPassConfirm = $_POST['passwordconfirm'];
    		$registerGT = $_POST['gamertag'];
    		
    		$registerPassMD5 = md5($registerPass);
    
    		
    		// We begin ~ :)
    		
    		// Create Error Possibilities: Username + Password Inconsistencies
    		if ($registerPass != $registerPassConfirm){
    			echo "<center>$promptInvalidPass</center>";
    		}
    		if (!ctype_alnum($registerUser)){
    			echo "<center>$promptNoUser</center>";
    		}
    		
    		// Create Error Possibilities: Already Exists - Username and Email
    		$doesExistCheckUser = $con->query("SELECT username FROM $connectUserTable WHERE username='$registerUser'");
    		$doesExistCheckEmail = $con->query("SELECT email FROM $connectUserTable WHERE email='$registerEmail'");
    		/* Custom entry. */ $doesExistCheckGT = $con->query("SELECT gamertag FROM $connectUserTable WHERE gamertag='$registerGT'");
    		$doesExistUser = mysqli_num_rows ($doesExistCheckUser);
    		$doesExistEmail = mysqli_num_rows ($doesExistCheckEmail);
    		$doesExistGT = mysqli_num_rows ($doesExistCheckGT);
    		
    		if ($doesExistUser != 0){
    			echo "<center>$promptAlreadyExistsUser</center>";
    		}
    		if ($doesExistEmail != 0){
    			echo "<center>$promptAlreadyExistsEmail</center>";
    		}
    		if ($doesExistGT != 0){
    			echo "<center>$promptAlreadyExistsGT</center>";
    		}
    		
    		// If user forgets to fill out forms - baka.
    		if ($registerUser == "" || $registerEmail == "" || $registerPass == "" || $registerPassConfirm == "" || $registerGT == ""){
    			echo "<center>$promptFieldEmpty</center>";
    		}
    		
    		// Get user IP (for IP bans...)
    		$ip = $_SERVER['REMOTE_ADDR'];
    		$doesExistIP1 = $con->query("SELECT ip FROM $connectUserTable WHERE ip = '$ip'");
    		$doesExistIPBan = mysqli_num_rows($doesExistIP1);
    		
    		if ($doesExistIPBan != 0){
    			echo "<center>$promptIPBAN</center>";
    		}
    		
    		// Check CAPTCHA
    		if ($_SESSION['answer'] == $_POST['answer']){
    			$hackcheck = "1";
    		}
    		if ($_SESSION['answer'] != $_POST['answer']){
    			$hackcheck = "0";
    			echo "<center>$promptIncorrectCA</center>";
    		}
    		
    		// Insert user data if everything is correct!
    		
    		if ($registerPass == $registerPassConfirm && ctype_alnum($registerUser) && $doesExistUser == 0 && $doesExistEmail == 0 && $doesExistGT == 0 && $registerUser != "" && $registerEmail != "" && $registerPass != "" && $registerPassConfirm != "" && $registerGT != "" && $hackcheck == "1" && $doesExistIPBan == 0) {
    		mysqli_query($con, "INSERT INTO $connectUserTable (`id`, `username`, `email`, `password`, `gamertag`, `ip`) VALUES ('NULL', '$registerUser', '$registerEmail', '$registerPassMD5', '$registerGT', '$ip')")
    		or trigger_error("MySQLi Query Failed!<br>".mysqli_error(), E_USER_ERROR);
    	
    		print(" 
    
    								<h2>Registration Successful!</h2>
    								<p>$promptSuccess</p>
    								<p>This is your recovery info - please keep it safe!</p>
    								<br>
    								Name: $registerUser
    								<br>
    								Email: $registerEmail
    								<br>
    								Password: $registerPassConfirm
    								<br>
    								<p>Thank you!</p>		
    						
    		");
    		mysqli_close($con);
    		}
    		}


?>
	
</body>
</html>
