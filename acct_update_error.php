<?
require_once ('verify.php'); 
$page_title = 'acct_update_success.php';

// Start output buffering:
ob_start();

// Initialize a session:
session_start();


// Check for a $page_title value:
if (!isset($page_title)) {
	$page_title = 'User Registration';
}

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['email_address'])) {
	
	$url = BASE_URL . ''; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration || mblistings.com</title>
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen" />
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
      <li><a href="settings.php">Account Settings</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main">
    <div id="content_left">
      <h1 style="color: #670000;">Error</h1>
      <p>There was an error in changing your account information. Please go back and make any necessary corrections.<span style="color:#EB070A;"></span></p>
      <p></p>
    </div>
    <div id="content_right">
      <h4>&nbsp;</h4>
      <div class="item_box">
        <div align="center"><img src="../images/error.png" width="175" height="174" alt="Registration success"/><br />
        </div>
      </div>
    </div>
    <div class="spacer"></div>
  </div>
  <div id="footer"></div>
</div>
</body>
</html>
<?php // Flush the buffered output.
	ob_end_flush();
?>