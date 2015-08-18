<?php
include '../dbcon.php';

$userid = mysqli_real_escape_string($con, $_POST['userid']);
$first_name = mysqli_real_escape_string($con, $_POST['first_name']);
$last_name = mysqli_real_escape_string($con, $_POST['last_name']);
$email_address = mysqli_real_escape_string($con, $_POST['email_address']);


	if (!filter_var($email_address, FILTER_VALIDATE_EMAIL)) {
	include 'acct_update_error.php';
	echo '<strong>You have entered an invalid email address!</strong> <br />';
	exit();
	}

mysqli_query($con,"UPDATE users SET first_name='$first_name', last_name='$last_name', email_address='$email_address' WHERE userid='$userid'") or die (mysqli_error());
session_unset();
session_start();
mysqli_query($con,"Select * FROM users WHERE userid='$userid'") or die (mysqli_error());

$_SESSION["first_name"] =$first_name;
$_SESSION["last_name"]=$last_name;
$_SESSION["email_address"]=$email_address;

	$subject = "Updated information at www.mblistings.com";
	$message = "Dear $first_name $last_name,
	This message is to advise you that you recently updated your account information at mblistings.com. If you did not recently update your account information please contact your system administrator.
	
	First Name: $first_name
	Last Name: $last_name
	Registered email address: $email_address
 
	
	Thank you!
	
	This is an automated response, please do not reply!";
	
	mail($email_address, $subject, $message, "From: mblistings.com<admin@mblistings.com>\nX-Mailer: PHP/" . phpversion());
	include 'acct_update_success.php'; 
 	exit(); 

?>
