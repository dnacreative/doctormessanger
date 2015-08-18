<?php
session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);
include '../dbcon.php';
$email_address = isset($_POST['email_address']) ? $_POST['email_address'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
if((!$email_address) || (!$password))
{
include 'login.php';
		echo '<script language="javascript">';
		echo 'alert("Please enter both an email address and your password.")';
		echo '</script>';
exit();
}
  $passwordmd5 = md5($password);
  $result = mysqli_query($con, "SELECT * FROM users WHERE email_address='$email_address' AND password='$passwordmd5' AND activated='1'");
  $login_check = mysqli_num_rows($result);
  if($login_check > 0){
  while($row = mysqli_fetch_array($result)){
  foreach( $row AS $key => $val ){
		$$key = stripslashes( $val );
	}
		  $_SESSION['first_name'] = $first_name;
		  $_SESSION['last_name'] = $last_name;
		  $_SESSION['email_address'] = $email_address;	 
		  $_SESSION['userid'] = $userid; 
  mysqli_query($con,"UPDATE users SET last_login=now() WHERE email_address='$email_address'");		
  header("Location: add_listings.php");
	}
  }
else 
{
include 'login.php';
		echo '<script language="javascript">';
		echo 'alert("You are not able to be logged in. Please check your email address and password and try again.")';
		echo '</script>';
}	
?>