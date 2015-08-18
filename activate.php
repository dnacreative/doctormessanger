<?
include 'dbconuser.php';

// Create variables from URL.

$code = $_REQUEST['code'];

$sql = mysqli_query($con,"UPDATE users SET activated='1' WHERE code='$code'");

$sql_doublecheck = mysqli_query($con,"SELECT * FROM users WHERE code='$code' AND activated='1'");
$doublecheck = mysqli_num_rows($sql_doublecheck);

if($doublecheck == 0){
	echo "<strong><font color=red>Your account could not be activated!</font></strong>";
} else if ($doublecheck > 0) {
	header ('Location: login_activated.htm'); 
}

?>