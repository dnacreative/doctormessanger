<?php 
ob_start();
session_start();
require_once ('verify.php'); 
$page_title = 'delete_listings.php';


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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Delete Listings</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="../css/style_members_area.css" media="screen"/>
<script content-type="text/javascript" src="http://code.jquery.com/jquery-2.1.1.min.js"></script>
<script Content-Type: application/javascript>
$("document").ready(function() {
    $(".delform").submit(function() {
        data = $(this).serialize();
        if (confirm("Are you sure you want to delete this listing?")) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "delete_list.php",
                data: data,
                beforeSend: function() {
                    $("#rec" + data["id"]).animate({
                        'backgroundColor':'#fb6c6c'
                    }, 400);
                },
                success: function(response) {
                    if (response.success) {
                        $("#rec" + response.idc).slideUp(400, function() {
                            $("#rec" + response.idc).remove();
                        });
                    } else {
                        console.log("An error has ocurred: sentence: " + response.sentence + "error: " + response.error);
                    }
                },
                error: function() {
                    alert("An Error has ocurred contacting with the server. Sorry");
                }
            });
            return false;
        }
    });
});
</script>
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
      <li><strong><a href="delete_listings.php">Delete Listings</a></strong></li>
      <li><a href="../listings.php" target="_blank">View Listings (website)</a></li>
      <li><a href="settings.php">Account Settings</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main_listings" style="border:none;">
    <h1 align="left">ADMINISTRATORS PAGE</h1>
    <h2 align="left">Delete Listings</h2>
    <h4 align="left">Press the delete button for each listing you want to PERMANANTLY deleted.</h4><br>
    <div id="admin_listing_content" style="border:none;">
      <?php
   try {
	   		require('../dbcon2.php');
	       $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// Check connection
		if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
		}
		    $total = $conn->query('
        SELECT
            COUNT(*)
        FROM
            listings
    ')->fetchColumn();
    // How many items to list per page
    $limit = 10;
    // How many pages will there be
    $pages = ceil($total / $limit);
    // What page are we currently on?
    $page = min($pages, filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT, array(
        'options' => array(
            'default'   => 1,
            'min_range' => 1,
        ),
    )));
    // Calculate the offset for the query
    $offset = ($page - 1)  * $limit;
    // Some information to display to the user, start is the first record # on the page
    $start = $offset + 1;
	// end is the last record number on the page
    $end = min(($offset + $limit), $total);
   // The "back" link
    $prevlink = ($page > 1)?'<a href="?page=1" title="First page"><button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button></a> <a href="?page='.($page - 1).'"title="Previous page"><button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button></a>':'<span class="disabled"><button type="button" class="btn btn-default btn-lg disabled"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button></span> <span class="disabled"><button type="button" class="btn btn-default btn-lg disabled"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></button></span>';
    // The "forward" link
    $nextlink = ($page < $pages) ? '<a href="?page='.($page + 1).'"title="Next page"><button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button></a> <a href="?page='.$pages.'"title="Last page"><button type="button" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button></a>':'<span class="disabled"><button type="button" class="btn btn-default btn-lg disabled"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button></span> <span class="disabled"><button type="button" class="btn btn-default btn-lg disabled"><span class="glyphicon glyphicon-chevron-right"aria-hidden="true"></span><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button></span>';
    // Display the paging information
	 echo '<div id="paging">',$prevlink,' <button type="button" class="btn btn-default btn-lg" disabled>Page ',$page,' of ',$pages,' </button> ',$nextlink,'</div>';
    // Prepare the paged query
    $stmt = $conn->prepare('SELECT * FROM listings Order by id DESC LIMIT :limit OFFSET :offset ');

    // Bind the query params
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    // Do we have any results?
    if ($stmt->rowCount() > 0) {
        // Define how we want to fetch the results
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $iterator = new IteratorIterator($stmt);

        // Display the results
        foreach ($iterator as $row) {
			$transaction=$row['transaction'];
			if ($transaction=='3') {$transactionprint='NOT PUBLISHED';} else {$transactionprint='PUBLISHED';}
			if ($transaction=='0') {$typeprint='in LISTINGS';} 
			if ($transaction=='1') {$typeprint='in RECENT TRANSACTIONS';}
			if ($transaction=='2') {$typeprint='in LISTINGS and RECENT TRANSACTIONS';}
   echo '<div id="rec'.$row['id'].'" class="del_box">
      <div class="delete_frame">
        <div align="center"><img id="del_img" src="'.$row['listing_img'].'" width="200px" /> </div>
        <div class="pub-notice" style="padding-top:5px;">
          <div align="center">This listing is '.$transactionprint.'</div>
		  <div align="center">'.$typeprint.'</div>
        </div>
      </div>
      <div id="delete_frame">
        <ul>
          <li>
            <p><span class="collab">Title: </span><strong>'.$row['title'].'</strong></p>
          </li>
          <li style="color: #FF0004">
            <p><span class="collab" style="color: #FF4245">Comment: </span> '.$row['comment'].'</p>
          </li>
          <li>
            <p><span class="collab">Address: </span> '.$row['address'].'</p>
          </li>
          <li>
            <p><span class="collab">Sale Price: </span> '.$row['sale_price'].'</p>
          </li>
          <li>
            <p><span class="collab">Lease Price: </span> '.$row['lease_price'].'</p>
          </li>
          <li>
            <p><span class="collab">Lot Size: </span> '.$row['lot_size'].'</p>
          </li>
          <li>
            <p><span class="collab">Building Size: </span> '.$row['build_size'].'</p>
          </li>
          <li>
            <p><span class="collab">Zoning: </span> '.$row['zoning'].'</p>
          </li>
        </ul>
      </div>
	        <div style="float:left; margin-top: -200px; margin-left: 630px;">
        <div id="delete">
   <form method="post" class="delform">
    <input name="id" type="hidden" id="id" value="'.$row['id'].'" />
    <input name="ad_link" type="hidden" id="ad_link" value="'.$row['ad_link'].'" />
    <input name="listing_img" type="hidden" id="listing_img" value="'.$row['listing_img'].'" />
	<button id="bar" type="submit"><img width="50px;" src="../images/Button-Delete-icon.png" />
	        <span class="highlight"></span><br/>
        <span class="text">Delete</span>
		</button>
  </form>
      </div>
	  </div>
    </div>
    <div style="clear:both;"></div><br/>';
        }
 echo '<div id="paging">',$prevlink,' <button type="button" class="btn btn-default btn-lg" disabled>Page ',$page,' of ',$pages,' </button> ',$nextlink,'</div>';

    } else {
        echo '<p>No results could be displayed.</p>';
    }

} catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
}
?>
    </div>
  </div>
  <div class="spacer"></div>
</div>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>
<?php // Flush the buffered output.
	ob_end_flush();
?>