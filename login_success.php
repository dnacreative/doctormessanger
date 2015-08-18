<?php 
require_once ('verify.php'); 
$page_title = 'login_success.php';

// Start output buffering:
ob_start();

// Initialize a session:
session_start();

// Check for a $page_title value:
if (!isset($page_title)) {
	$page_title = 'User Registration';
}

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['userid'])) {
	
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Area mblistings.com</title>
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
</head>

<body>
<div id="container">
<div id="head">
    
</div>
<ul id="menu">
	<li><strong><a href="logout.php">Log Out</a></strong></li>
    <li><strong><a href="../listings.php" target="_blank">View Current Listings</a></strong></li>
     </ul>
<div id="area"></div>
    <div id="main">
      <div id="content_left">
      <h3>Welcome to the Admin Area for mblistings.com</h3>


      <form name="form2" method="post" action="list.php">
  <table width="400" border="1" cellpadding="4" cellspacing="0">

    <tr> 
      <td align="left" valign="top">Title</td>
      <td><input name="title" type="text" id="title" value="<? echo $title; ?>"></td>
    </tr>
    
    <tr> 
      <td align="left" valign="top">Price</td>
      <td><input name="price" type="text" id="price" value="<? echo $price; ?>"></td>
    </tr>
    
        <tr> 
      <td align="left" valign="top">Address</td>
      <td><input name="address" type="text" id="address" value="<? echo $address; ?>"></td>
    </tr>
    
    <tr> 
      <td align="left" valign="top">Description</td>
      <td><textarea name="description" id="description"><? echo $description; ?></textarea></td>
    </tr>

    <tr> 
      <td align="left" valign="top">&nbsp;</td>
      <td><input type="submit" name="Submit" value="Submit Form Data"></td>
    </tr>
  </table>
</form>
      </p></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>

</div> 
      <div id="content_right">
      <h4>&nbsp;</h4>
      <div class="item_box">
        <div align="center"><img src="images/members.png" alt="mblistings dot com commercial real estate Robert Buzzeo Michael Braccia" width="175" height="165" /><br />
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