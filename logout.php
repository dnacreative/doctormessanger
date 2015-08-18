<?php 
require_once ('verify.php'); 
$page_title = 'logout.php';

// Start output buffering:
ob_start();

// Initialize a session:
session_start();
$first_name=$_SESSION['first_name'];
$last_name=$_SESSION['last_name'];

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
<title>Logout</title>
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen"/>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script><script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
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
      <li><strong><a href="logout.php">Log Out</a></strong></li>
      <li style="float:right; margin-right:5%;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main">
    <div id="content_left">
<?php
if(!isset($_REQUEST['logmeout'])){
	echo "<h2><center>Are you sure you want to logout?</center></h2><br />";
	echo "<h3><center><a href=logout.php?logmeout>Yes</a> | <a href=javascript:history.back()>No</a></h3>";
} else {
	session_unset();
	session_destroy();
	header('Location: logout_yes.php');	
}
?>
    </div>
    <div id="content_right">
      <div class="item_box">
        <div align="center"><img src="../images/attention.png" alt="mblistings dot com commercial real estate Robert Buzzeo Michael Braccia" width="175" height="175" /><br />
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