<?php 
ob_start();
session_start();
require_once ('verify.php'); 
$page_title = 'edit_listings.php';


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
<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<title>Edit Listings</title>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
<link href="../css/cropper.min.css" rel="stylesheet">
<link href="../css/crop-avatar.css" rel="stylesheet">
<link href="../css/style_members_area.css" rel="stylesheet" />
<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript">
	function countChars(countfrom,displayto) {
  		var len = document.getElementById(countfrom).value.length;
  			document.getElementById(displayto).innerHTML = len
			;}
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
      <li><strong><a href="edit_listings.php">Edit Listings</a></strong></li>
      <li><a href="delete_listings.php">Delete Listings</a></li>
      <li><a href="../listings.php" target="_blank">View Listings (website)</a></li>
      <li><a href="settings.php">Account Settings</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings home icon"/></a></li>
    </ul>
  </div>
  <div class="area"></div>
  <div id="main_listings" style="border:none;">
  <div id="loading-indicator" style="display:none"> </div>
    <h1 align="left">ADMINISTRATORS PAGE</h1>
    <h2 align="left">Edit Listings</h2>
    <h4 align="left">Browse to the correct listing and make any necessary changes. When your changes are complete click <em>submit changes</em>. Click on the image to edit the image for the listing.</h4>
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
    $limit = 1;
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
    //begin dropdown list
	 echo '<div class="dropdown" style="display:inline; margin-left:5%;">
  <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
    Browse by address
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">';
  //get all sql rows
    $stmtdd = $conn->prepare('SELECT * FROM listings Order by id DESC');
    $stmtdd->execute();
    $stmtdd->setFetchMode(PDO::FETCH_ASSOC);
    $iteratordd = new IteratorIterator($stmtdd);

foreach ($iteratordd as $rowIndex => $row) {
	$adrdd = $row['address'];

	//echo the address and link to the page
  echo '<li role="presentation"><a role="menuitem" tabindex="-1" href="?page='.($rowIndex + 1).'">'.$adrdd.'</a></li>';}
  echo '</ul>
</div>';
// Display the paging information
echo '<div id="paging" style="display:inline; margin-left:5%">',$prevlink,' <button type="button" class="btn btn-default btn-lg" disabled>Listing ',$page,' of ',$pages,' </button> ',$nextlink,'</div>';
    
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
			$file_string = $row['ad_link'];
			$name_file = substr($file_string,33);
			$chkvalue='checked';
			$transaction=$row['transaction'];
			if ($transaction=='3') {$transactionprint='NOT PUBLISHED';} else {$transactionprint='PUBLISHED';}
			if ($transaction=='0') {$typeprint='in LISTINGS';} 
			if ($transaction=='1') {$typeprint='in RECENT TRANSACTIONS';}
			if ($transaction=='2') {$typeprint='in LISTINGS and RECENT TRANSACTIONS';}
   echo '<div class="del_box" style="height:700px;">
   <div class="delete_frame" style="height:600px; width:250px; overflow:hidden; float:left;">
   <div class="container" id="crop-avatar">
   
   <div class="avatar-view" title="Change this image" style="width:200px; height:200px"><img src="' . $row['listing_img'] . '" alt="' . $row['title'] . '"></div>
        <div class="modal fade" id="avatar-modal" tabindex="-1" role="dialog" aria-labelledby="avatar-modal-label" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form class="avatar-form" method="post" action="edit-avatar.php" enctype="multipart/form-data">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title" id="avatar-modal-label">Listing Main Image</h4>
                </div>
                <div class="modal-body">
                  <div class="avatar-body"> 
                    <div class="avatar-upload">
                      <input class="avatar-src" name="avatar_src" type="hidden">
                      <input class="avatar-data" name="avatar_data" type="hidden">
                      <input name="avatar_id" type="hidden" value="' . $row['id'] . '">
                      <label for="avatarInput">Local upload</label>
                      <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                    </div>
                    <div class="row">
                      <div class="col-md-9">
                        <div class="avatar-wrapper"></div>
                      </div>
                      <div class="col-md-3">
                        <div class="avatar-preview preview-lg"></div>
                        <div class="avatar-preview preview-md"></div>
                        <div class="avatar-preview preview-sm"></div>
                      </div>
                    </div>
					<div id="loading" style="display:none"> </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-default" type="button" data-dismiss="modal">Close</button>
                  <button class="btn btn-primary avatar-save" type="submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="pub-notice" style="padding-top:10px; width:230px;">
          <div align="center">This listing is '.$transactionprint.'</div>
		  <div align="center">'.$typeprint.'</div>
		  </div>
<form name="edit_date" class="data-form" method="POST" id="edit_list_data" enctype="multipart/form-data">
	   <br>
	<div class="radio">
      <label><input type="radio" name="transaction" value="0" '; if($transaction == '0') {echo $chkvalue;} echo '>Listings</label>
    </div>
    <div class="radio">
      <label ><input type="radio" name="transaction" value="2" '; if($transaction == '2') {echo $chkvalue;} echo '>Both</label>
	</div>
     <div class="radio">
      <label><input type="radio" name="transaction" value="1" '; if($transaction == '1') {echo $chkvalue;} echo '>Recent Transactions</label>
    </div>
	 <div class="radio">
      <label><input type="radio" name="transaction" value="3"'; if ($transaction == '3') {echo $chkvalue;} echo '>Save, don\'t publish</label>
	  </div>   
      </div>
   <div id="delete_frame" style="margin-left:250px;">	    
 <div class="input-group">
  <span class="input-group-addon" id="sizing-addon1">Current flyer:</span>
  <input type="text" disabled class="form-control" value="'.$name_file.'" aria-describedby="sizing-addon1">
</div>
 <br>
 <input type="file" class="filestyle" name="flyer" data-buttonName="btn-primary"><br>
 <br>  
 <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Title</span>
  <input name="title" type="text" class="form-control"  aria-describedby="sizing-addon2" value="'.$row['title'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Address</span>
  <input name="address" type="text" class="form-control"  aria-describedby="sizing-addon2" value="'.$row['address'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Sale Price</span>
  <input name="sale_price" type="text" class="form-control" placeholder="n/a" aria-describedby="sizing-addon2" value="'.$row['sale_price'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Lease Price</span>
  <input name="lease_price" type="text" class="form-control" placeholder="n/a" aria-describedby="sizing-addon2" value="'.$row['lease_price'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Lot Size</span>
  <input name="lot_size" type="text" class="form-control" placeholder="n/a" aria-describedby="sizing-addon2" value="'.$row['lot_size'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Building Size</span>
  <input name="build_size" type="text" class="form-control" placeholder="n/a" aria-describedby="sizing-addon2" value="'.$row['build_size'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Zoning</span>
  <input name="zoning" type="text" class="form-control" placeholder="n/a" aria-describedby="sizing-addon2" value="'.$row['zoning'].'">
  </div>
  <div class="input-group">
  <span class="input-group-addon" id="sizing-addon2">Comment</span>
  <input name="comment" type="text" class="form-control" placeholder="blank" aria-describedby="sizing-addon2" value="'.$row['comment'].'">
  </div>
  <br>
        <input type="hidden" name="id" value="'.$row['id'].'" />
        <button type="submit" id="bar" style="margin-left:35%;" /><span class="highlight"></span>
        <span class="text">Submit changes</span>
		</button>

      </form>
	  </div>
  </div>
  <br>
  <br>

  ';
        }
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
<script>
$(document).ready(function(){
	$("#loading-indicator").hide();
	
    $(".data-form").submit(function() {
	var formData = new FormData($('.data-form')[0]);
        if (confirm("Are you ready to sumbmit these changes?"))       {
			$("#loading-indicator").show();
			console.log();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "add-list.php",
                data: formData,
				success: function(response) {
				if (response.success) {
					$("#loading-indicator").hide();
					location.reload(true);
							
						  }
				else {
				console.log("An error has ocurred: sentence: " + response.sentence + "error: " + response.error);
			}
		},
				contentType: false, 
				processData: false,
					  error: function() {
						  alert("An Error has ocurred contacting the server. Please contact your system administrator");
					  }
                  });
        	}
		return false;
    });
	});
</script> 
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script> 
<script src="../js/cropper.min.js"></script> 
<script src="../js/edit-crop-image.js"></script> 
<script type="text/javascript" src="../js/bootstrap-filestyle.min.js"> </script>
</body>
</html>
<?php // Flush the buffered output.
	ob_end_flush();
?>
