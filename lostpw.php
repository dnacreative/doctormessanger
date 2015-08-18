<?
include 'dbconuser.php';

switch($_POST['recover']){
	default:
	include 'lost_pw.html';
	break;
	
	case "recover":
	recover_pw($_POST['email_address']);
	break;
	
}
function recover_pw($email_address){
	if(!$email_address){
		include 'lost_pw.php';
		echo "You forgot to enter your Email address <strong>Knucklehead</strong><br />";
		exit();
	}
	// quick check to see if record exists	
	$sql_check = mysql_query("SELECT * FROM users WHERE email_address='$email_address'");
	$sql_check_num = mysql_num_rows($sql_check);
	if($sql_check_num == 0){
		include 'lost_pw.php';
		echo "No records found matching your email address<br />";
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
	
	$sql = mysql_query("UPDATE users SET password='$db_password' WHERE email_address='$email_address'");
	
	$subject = "Password reset for mblistings.com";
	$message = "A new password has been assigned to you at mblistings.com:
	
	New Password: $random_password
	
	http://www.mblistings.com/members_area/login.php
	
	Once you are logged in you may customize your password in 'Account Settings.'
	
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: mblistings.com<admin@mblistings.com>\nX-Mailer: PHP/" . phpversion());
	include 'password_sent.htm'; 
 	exit(); 
}
?>