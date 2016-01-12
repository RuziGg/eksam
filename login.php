<?php

	// LOGIN.PHP
	
	require_once("functions.php");
	
	if(isset($_SESSION["logged_in_user_id"])){
		header("Location: data.php");
	}

	$email_error = "";
	$password_error = "";
	$login_email = "";
	$login_password = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		
		if(isset($_POST["login"])){ 
			
			echo "vajutas login nuppu!";

			if ( empty($_POST["email1"]) ) {
				$email_error = "See väli on kohustuslik";
			}else{
				$login_email = test_input($_POST["email1"]);
			}
			
			if ( empty($_POST["password1"]) ) {
				$password_error = "See väli on kohustuslik";
			}else{
				
				if(strlen($_POST["password1"]) < 8) { 
				
					$password_error = "Peab olema vähemalt 8 tähemärki pikk!";
					
				}else{
					$login_password = test_input($_POST["password1"]);
				}
				
			}
			
			if($email_error == "" && $password_error ==""){
				
				echo "kontrollin sisselogimist ".$login_email." ja parool ";
			}
		
		
			if($password_error == "" && $email_error == ""){
				echo "Võib sisse logida! Kasutajanimi on ".$login_email." ja parool on ".$login_password;
				
				loginUser($login_email, $login_password);
			}
		}
		
		
		
	}
	// eemaldab tahapahtlikud osad
	function test_input($data) {
		 $data = trim($data);
		 $data = stripslashes($data);
		 $data = htmlspecialchars($data);
		 return $data;
	}
	
?>
<html>
<head>
	<title>Login page</title>
</head>
<body>
	<h2>Log in</h2>
	
		<form action="login.php" method="post" >
			<input name="email1" type="email" placeholder="Email"> <?php echo $email_error; ?><br><br>
			<input name="password1" type="password" placeholder="Password"> <?php echo $password_error; ?><br><br>
			<input name="login" type="submit" value="Log in">
		</form>
</body>
</html>