<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration Code</title>

<?php		
		session_start();
		$x = rand(1,10);
		$y = rand(1,30);
		/* You can replace 'color:#D24E4E;' with the color of your choice. */ $question = "<span style='color:#D24E4E;'>CHECK: </span>The sum of $x and $y is: ";
		$_SESSION['answer'] = $x + $y;
?>

</head>

<body>
								
								
								<form action='register.php' method='POST'>
								
								<h3>Username:  <input type='text' name='username' value='' size='55'></h3>
								<small><i>Must be alphanumeric.</i></small>
								
								<h3>Email:  <input type='text' name='email' size='55'></h3>
								<small><i>Must be a real email. Used for support and activation.</i></small>
								
								<h3>Password:  <input type='password' name='password' size='50'></h3>
								<small><i>Make sure that your password is <a href='https://howsecureismypassword.net/' target='_blank'>secure</a>.</i></small>
								
								<h3>Password Again:  <input type='password' name='passwordconfirm' size='55'></h3>
								<small><i>Please confirm your password.</i></small>
								
								<!-- This was a custom field for another website. You may change this as you wish. -->
								<h3>Gamertag:  <input type='text' name='gamertag' size='55'></h3>
								<small><i>What's your gamertag (PSN, Xbox...)? Users cannot have the same gamertag.</i></small>
								
								<h3><?php echo $question; ?><input type='text' name='answer' size='2'><input type='submit' name='submit' value='Register'></h3>
								
								</form>

				
</body>
</html>
