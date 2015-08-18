<?php 
ob_start();
session_start();
require_once ('verify.php'); 
$page_title = 'settings.php';


$sid = session_id();
$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];
$email_address=$_SESSION['email_address'];


		include ("../dbcon.php");
		$query="SELECT * FROM users WHERE email_address='$email_address'";
		$result=mysqli_query($con,$query);
		$data=mysqli_fetch_assoc($result);
	 		$userid = $data['userid'];
			$password = $data['password'];
			$signup_date = $data['signup_date'];
			$last_login = $data['last_login'];

// Check for a $page_title value:
if (!isset($page_title)) {
	$page_title = 'User Registration';
}

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['email_address'])) {
	
	$url = BASE_URL . ''; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.
	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Settings</title>
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen"/>
<script src="../js/jquery.js"></script>
<script type="text/javascript" src="../js/charCount.js"></script>
        <script>function checkPasswordMatch() {
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Doesn't Match!");
    else
        $("#divCheckPasswordMatch").html("<u style='color:#229615;'>Match!</u>");
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
});</script>
</head>
<body>
<div id="container">
  <div id="head">
    <div id="logo">
      <div><img src="../images/logo.png" alt="mblistings logo"/></div>
    </div>
    <ul id="menu">
      <li><a href="add_listings.php">Add listings</a></li>
      <li><a href="edit_listings.php">Edit Listings</a></li>
      <li><a href="delete_listings.php">Delete Listings</a></li>
      <li><a href="../listings.php" target="_blank">View Listings (website)</a></li>
      <li><strong><a href="settings.php">Account Settings</a></strong></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main">
    <div id="content_left">
      <h1>Account Settings</h1>
      <h2>Hello <em><?php echo $first_name ?></em>, you may edit the  information in your account at any time.</h2>

      <div style="float:left;">
        <form name="Account update" method="post" action="updateacct.php" >
          <table border="0" cellpadding="4" cellspacing="0" align="left">
            <tr>
              <td colspan="2" align="left" valign="top"><div align="center">
                <h4>Change personal information</h4>
              </div></td>
            </tr>
            <tr>
              <td align="left" valign="top">First Name</td>
              <td><input name="first_name" placeholder="Required" type="text" required="required" id="first_name" value="<?php echo $first_name ?>"></td>
            </tr>
            <tr>
              <td align="left" valign="top">Last Name</td>
              <td><input name="last_name" placeholder="Required" type="text" required="required" id="last_name" value="<?php echo $last_name ?>"></td>
            </tr>
            <tr>
              <td align="left" valign="top">Email Address</td>
              <td><input name="email_address" placeholder="Required" type="text" required="required" id="email_address" value="<?php echo $email_address ?>"></td>
            </tr>
            <tr>
              <td align="left" valign="top"><input type="hidden" name="userid" value="<?php echo $userid ?>" /></td>
              <td><input type="submit" name="Submit" value="Submit Changes" ></td>
            </tr>
          </table>
        </form>
      </div>
      <div style="float:right;">
        <form name="updatepass" method="post" action="change_psswrd.php">
          <table border="0" cellpadding="4" cellspacing="0" align="left">
            <tr>
              <td colspan="2" align="left" valign="top"><div align="center">
                <h4>Password Reset</h4>
              </div></td>
            </tr>
            <tr>
              <td align="left" valign="top">Old password</td>
              <td><input name="oldpw" placeholder="Required" type="text" required="required" id="oldpw" ></td>
            </tr>
            <tr>
              <td align="left" valign="top">New Password</td>
              <td><input name="psswrd1" placeholder="Required" type="text" required="required" id="txtNewPassword" ></td>
              <td></td>
            </tr>
            <tr>
              <td align="left" valign="top">Re-enter Password</td>
              <td><input name="psswrd2" placeholder="Required" type="text" required="required" id="txtConfirmPassword" onChange="checkPasswordMatch()" ></td>
            </tr>
            <tr>
              <td align="left" valign="top">&nbsp;</td>
              <input name="email_address" type="hidden" id="email_address" value="<?php echo $email_address ?>" >
              <td><input type="submit" name="Submit" value="Change Password" ></td>
            </tr>
            <tr>
              <td style="padding-right:40px;" colspan="2" align="right" valign="top"><div class="registrationFormAlert" id="divCheckPasswordMatch">
                
              </div></td>
            </tr>
          </table>
        </form>


 <p></p>

      </div>
    </div>
    <div id="content_right">

      <div class="item_box">
        <div align="center"><img src="../images/register.jpg" alt="mblistings dot com commercial real estate Robert Buzzeo Michael Braccia" width="175" height="168" /><br />   
        </div>
</div>      <h3 align="center">You registed with us on<br/>
      <em><?php echo $signup_date ?></em> <br/>
      <br/>
      You last logged on to this site on <br/>
      <em><?php echo $last_login ?></em>.</h3>
    </div>
    <div class="spacer"></div>
  </div>
</div>
</body>
</html>
<?php // Flush the buffered output.
	ob_end_flush();
?>