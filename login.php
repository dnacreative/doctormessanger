<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Log In || Admin Area mblistings.com</title>
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen" />
</head>
<body>
<div id="container">
  <div id="head">
    <div id="logo">
      <div><img src="../images/logo.png" alt="mblistings logo"/></div>
    </div>
    <ul id="menu">
      <li><strong><a href="login.php" title="">Sign In</a></strong></li>
      <li><a href="join.php" title="">Register</a></li>
      <li style="float:right; margin-right:10%;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main">
    <div id="content_left">
      <h1>Please Login </h1>
      <h2></h2>
      <form name="login" method="post" action="checkuser.php">
        <table width="70%" border="0" align="center" cellpadding="4" cellspacing="0">
          <tr>
            <td width="35%">Registered Email</td>
            <td width="65%"><input name="email_address" autofocus type="email" id="email_address"/></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input name="password" type="password" id="password"/></td>
          </tr>
          <tr>
            <td></td>
            <td><button id="bar" type="submit" style="margin-left:25px;"> <span class="highlight"></span> <span class="text">login</span> </button></td>
          </tr>
          <tr>
            <td class="auto-style1" colspan="2"><a href="lost_pw.htm">Reset Password</a></td>
          </tr>
        </table>
      </form>
    </div>
    <div id="content_right">
      <div class="item_box">
        <div align="center"><img src="../images/login.png" alt="mblistings dot com commercial real estate Robert Buzzeo Michael Braccia" width="176" height="176" /><br />
        </div>
      </div>
    </div>
    <div class="spacer"></div>
  </div>
  <div id="footer"></div>
</div>
</body>
</html>
