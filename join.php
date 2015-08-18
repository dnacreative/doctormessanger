<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Become Member. Admin Area mblistings.com</title>
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen" />
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
</head>

<body>
<div id="container">
  <div id="head">
    <div id="logo">
      <div><img src="../images/logo.png" alt="mblistings logo"/></div>
    </div>
    <ul id="menu">
      <li><a href="login.php" title="">Sign In</a></li>
      <li><a href="join.php" title=""><strong>Register</strong></a></li>
      <li style="float:right; margin-right:10%;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main">
    <div id="content_left">
      <h1>Register</h1>
      <form name="registration form" method="post" action="register.php">
        <table style="margin-left:20px;" border="0" cellpadding="4" cellspacing="0" align="left">
          <tr>
            <td align="left" valign="top">First Name</td>
            <td><input name="first_name" type="text" id="first_name2" ></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">Last Name</td>
            <td><input name="last_name" type="text" id="last_name" ></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">Email Address</td>
            <td><input name="email_address" type="text" id="email_address" ></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">Password</td>
            <td><input name="psswrd1" type="text" id="txtNewPassword" ></td>
            <td rowspan="2"><div class="registrationFormAlert" id="divCheckPasswordMatch"></td>
          </tr>
          <tr>
            <td align="left" valign="top">Re-enter Password</td>
            <td><input name="psswrd2" type="text" id="txtConfirmPassword" onChange="checkPasswordMatch()" ></td>
          </tr>
          <tr>
            <td align="left" valign="top">Authorization code</td>
            <td><input name="authcode" type="text" id="authcode" ></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top">&nbsp;</td>
                        <td><button id="bar" type="submit" style="margin-left:25px;"> <span class="highlight"></span> <span class="text">Submit Registration</span> </button></td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </form>
      <script>function checkPasswordMatch() {
    var password = $("#txtNewPassword").val();
    var confirmPassword = $("#txtConfirmPassword").val();

    if (password != confirmPassword)
        $("#divCheckPasswordMatch").html("Passwords do not match!");
    else
        $("#divCheckPasswordMatch").html("Passwords match.");
}

$(document).ready(function () {
   $("#txtConfirmPassword").keyup(checkPasswordMatch);
});</script> 
    </div>
    <div id="content_right">
      <h4>&nbsp;</h4>
      <div class="item_box">
        <div align="center"><img src="../images/register.jpg" alt="mblistings dot com commercial real estate Robert Buzzeo Michael Braccia" width="175" height="168" /><br />
        </div>
      </div>
    </div>
    <div class="spacer"></div>
  </div>
</div>
</body>
</html>
