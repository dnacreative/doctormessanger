<?
include 'dbconuser.php';

$email_address = mysqli_real_escape_string($con, $_POST['email_address']);

	if(!$email_address){
		echo '<script language="javascript">';
		echo 'alert("You forgot to enter your email address")';
		echo '</script>';
		include 'lost_pw.htm';
		exit();
	}
	//check to see if record exists	
	$sql_check = mysqli_query($con,"SELECT * FROM users WHERE email_address='$email_address'");
	$sql_check_num = mysqli_num_rows($sql_check);
	if($sql_check_num == 0){
		echo '<script language="javascript">';
		echo 'alert("There are no records matching that email address. Please try again")';
		echo '</script>';
		include 'lost_pw.htm';
		exit();
	}
	// Everything looks ok, generate password, update it and send it!
	
	function makeRandomPassword() {
  		$salt = "abchefghjkmnpqrstuvwxyz0123456789";
  		srand((double)microtime()*1000000); 
	  	$i = 0;
	  	while ($i <= 7) {
	    		$num = rand() % 33;
	    		$tmp = substr($salt, $num, 1);
	    		$pass = $pass . $tmp;
	    		$i++;
	  	}
	  	return $pass;
	}

	$random_password = makeRandomPassword();

	$db_password = md5($random_password);
	
	mysqli_query($con,"UPDATE users SET password='$db_password' WHERE email_address='$email_address'");
	
	$subject = "Password reset for mblistings.com";
	$message = "A new password has been assigned to you at mblistings.com:
	
	New Password: $random_password
	
	http://www.mblistings.com/members_area/login.php
	
	Please use the provided randomly generated password to log in. Once you are logged in you may customize your password in 'Account Settings.'
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: mblistings.com<admin@mblistings.com>\nX-Mailer: PHP/" . phpversion());
	header ('Location: password_sent.htm'); 
 	exit(); 

?>