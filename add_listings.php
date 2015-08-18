<?php 
ob_start();
session_start();
require_once ('verify.php'); 
$page_title = 'add_listings.php';

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
if (!isset($page_title)) 
	{
	$page_title = 'User Registration';
	}

// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['email_address'])) 
	{
	$url = BASE_URL . ''; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header("Location: $url");
	exit(); // Quit the script.	
	}
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<link rel="icon" type="image/ico" href="http://www.mblistings.com/favicon.ico"/>
<title>Add Listing</title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
<link href="../css/cropper.min.css" rel="stylesheet">
<link href="../css/crop-avatar.css" rel="stylesheet">
<link href="../css/style_members_area.css" rel="stylesheet" />
</head>
<body>
<div id="container">
  <div id="head">
    <div id="logo">
      <div><img src="../images/logo.png" alt="mblistings.com logo"/></div>
    </div>
    <ul id="menu">
      <li><a href="add_listings.php"><strong>Add listings</strong></a></li>
      <li><a href="edit_listings.php">Edit Listings</a></li>
      <li><a href="delete_listings.php">Delete Listings</a></li>
      <li><a href="../listings.php" target="_blank">View Listings (website)</a></li>
      <li><a href="settings.php">Account Settings</a></li>
      <li><a href="logout.php">Log Out</a></li>
      <li style="float:right;"><a href="../index.php"><img src="../images/home-icon.png"  height="22" alt="mblistings.com home icon"/></a></li>
    </ul>
  </div>
  <div id="area"></div>
  <div id="main_listings" style="border:none;">
    <div id="loading-indicator" style="display:none"> </div>
    <h1 align="left">ADMINISTRATORS PAGE</h1>
    <h2 align="left">Add Listings</h2>
    <h4 class="instruction" align="left">Click the image below to add a new listing:</h4>
    <div class="admin_listing_content">
      <div id="crop-avatar" class="container">
        <div class="avatar-view" title="Add a new listing" style="float:none;"> <img src="../images/imageone.jpg" alt="Avatar"> </div>
        <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" data-backdrop="static">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <form class="avatar-form" action="crop-avatar.php" enctype="multipart/form-data" method="post">
                <div class="modal-header">
                  <button class="close" id="refresh1" data-dismiss="modal" type="button">&times;</button>
                  <h1 class="modal-title" id="avatar-modal-label" style="border:none;">Add new listing: Image
                    <h6>Required</h6>
                  </h1>
                </div>
                <div class="modal-body">
                  <div class="avatar-body">
                    <div class="avatar-upload">
                      <input class="avatar-src" name="avatar_src" type="hidden">
                      <input class="avatar-data" name="avatar_data" type="hidden">
                      <!--IMPORTANT-->
                      <label for="avatarInput">Upload image from computer</label>
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
                  </div>
                </div>
                <div class="modal-footer">
                  <button id="dformclose" class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                  <button id="nxtbutton" class="btn btn-primary avatar-save" type="submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
        <div id="modal1-container" class="m1container">
          <div class="modal fade" id="modal1" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <form name="data-form" class="data-form" method="POST" enctype="multipart/form-data">
                  <div class="modal-header">
                    <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
                    <h1 class="modal-title" id="avatar-modal-label" style="border:none;">Add new listing: File and Data</h1>
                  </div>
                  <div class="modal-body">
                    <fieldset >
                      <legend style="display: inline;">
                      PDF File Upload
                      <h6 style="display: inline;">Required</h6>
                      </legend>
                      <label style="margin-left:30px;" for="fileUpload">Select pdf file from computer</label>
                      <input style="display: inline; margin-left:10px;" class="fileUpload" name="flyer" type="file"  />
                    </fieldset>
                    <br />
                    <fieldset>
                      <legend style="display: inline;">
                      Designation
                      <h6 style="display: inline;"><strong>Required</strong> - Defaults to "Listings"</h6>
                      </legend>
                      <p style="padding-left:30%;">
                        <input name="transaction" type="radio" value="0" checked="checked"/>
                        <label>Listings</label>
                        <input style="margin-left:100px;" name="transaction" type="radio" value="1"/>
                        <label>Recent Transactions</label>
                      </p>
                      <p style="padding-left:30%;">
                        <input name="transaction" type="radio"  value="2"/>
                        <label>Both</label>
                        <input style="margin-left:120px;"  name="transaction" type="radio" value="3"/>
                        <label>Save, don't publish</label>
                      </p>
                    </fieldset>
                    <legend>Listing Data</legend>
                    <fieldset style="margin-left:30px;">
                      <P class="h4" style="display: inline;">Title</P>
                      <h6 style="display: inline;"><strong>Required</strong> - Maximum 57 Characters</h6>
                      <br />
                      <textarea name="title" cols="60" rows="1" required id="title" placeholder="Required (Max 57)" style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Address</P>
                      <h6 style="display: inline;">Maximum 50 Characters</h6>
                      <br />
                      <textarea name="address" cols="60" rows="1" id="address" placeholder="Maximum 50 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Lease Price</P>
                      <h6 style="display: inline;">Maximum 40 Characters</h6>
                      <br />
                      <textarea name="lease_price" cols="60" rows="1" id="lease_price" placeholder="Maximum 40 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Sale Price</P>
                      <h6 style="display: inline;">Maximum 30 Characters</h6>
                      <br />
                      <textarea name="sale_price" cols="60" rows="1" id="sale_price" placeholder="Maximum 30 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Lot Size</P>
                      <h6 style="display: inline;">Maximum 30 Characters</h6>
                      <br />
                      <textarea name="lot_size" cols="60" rows="1" id="lot_size" placeholder="Maximum 30 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Building Size</P>
                      <h6 style="display: inline;">Maximum 30 Characters</h6>
                      <br />
                      <textarea name="build_size" cols="60" rows="1" id="build_size" placeholder="Maximum 30 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Zoning</P>
                      <h6 style="display: inline;">Maximum 30 Characters</h6>
                      <br />
                      <textarea name="zoning" cols="60" rows="1" id="zoning" placeholder="Maximum 30 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                      <P class="h4" style="display: inline;">Comment</P>
                      <h6 style="display: inline;">Maximum 30 Characters</h6>
                      <br />
                      <textarea name="comment" cols="60" rows="1" id="comment" placeholder="Maximum 30 Characters. Defaults to n/a." style="vertical-align:middle"></textarea>
                      <br />
                    </fieldset>
                  </div>
                  <div class="modal-footer">
                    <input class="avatar-src" name="avatar_src" type="hidden">
                    <div class="id-wrapper"></div>
                    <input class="avatar-id" id="avatar-id" name="id" value="" type="hidden">
                    <button id="cformclose" class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
                    <button id="nxtbutttwo" class="btn btn-primary avatar-save" type="submit">Save Listing</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="added-wrapper">
          <div style="margin-left:145px; font-size:22px;" class="atitle"></div>
          <div style="margin-left:155px; font-size:16px; color:#FF0004; font-weight:bold;"class="acomment"></div>
          <div class="inner-wrapper">
            <div class="bigpicture"><img src=""/></div>
            <div style="display:inline; float:right; margin-right:20px; margin-top:60px;">
              <ul class="nav nav-pills nav-stacked" id="newbutt">
                <li role="presentation" class="active"><a href="#">Add another listing</a></li>
                <li role="presentation" class="active"><a href="edit_listings.php">Edit this listing</a></li>
              </ul>
            </div>
            <div id="add_frame" style="margin-left:260px; margin-top:20px;">
              <ul>
                <li>
                  <p style="display:inline;">Address:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="aaddress"></div>
                  </p>
                </li>
                <li>
                  <p style="display:inline;">Sale Price:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="asale-price"></div>
                  </p>
                </li>
                <li>
                  <p style="display:inline;">Lease Price:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="alease-price"></div>
                  </p>
                </li>
                <li>
                  <p style="display:inline;">Lot Size:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="alot-size"></div>
                  </p>
                </li>
                <li>
                  <p style="display:inline;">Building Size:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="abuilding-size"></div>
                  </p>
                </li>
                <li>
                  <p style="display:inline;">Zoning:
                  <div style="font-weight:bold; display:inline; margin-left:15px;" class="azoning"></div>
                  </p>
                </li>
              </ul>
            </div>
            <br>
            <div class="pub-notice" style="width: 260px; margin-top: 50px; text-align: center;">
              <div class="transpanel">This listing is
                <div class="atrans"></div>
              </div>
              <div class="atransaction"></div>
            </div>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="spacer"></div>
</div>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.1.min.js"></script> 
<script type="text/javascript" src="../scripts/charCount.js"></script> 
<script type="text/javascript">
	$(document).ready(function(){	
				$("#title").charCount({
			allowed: 57,		
			warning: 25,
		});
				$("#address").charCount({
			allowed: 50,		
			warning: 20,	
		});
				$("#lease_price").charCount({
			allowed: 40,		
			warning: 15,
		});
				$("#sale_price").charCount({
		});
				$("#lot_size").charCount({	
		});
				$("#build_size").charCount({
		});
				$("#zoning").charCount({
		});
				$("#comment").charCount({
		});
	});
</script> 
<script type="text/javascript">
$(document).ready(function(){
	$("#add_frame").hide();
	$(".bigpicture").hide();
	$("#newbutt").hide();
	$(".transpanel").hide();
});

$("#refresh1").click(function() {
    location.reload(true);
	});
$("#refresh2").click(function() {
    location.reload(true);
	});
$("#close").click(function() {
    location.reload(true);
	});
	$(".active").click(function() {
    location.reload(true);
	});
$("#dformclose").click(function() {
    if (confirm("\t\t Are you sure you want to cancel this?\nYour image and any information in this form will be deleted!")) {
		var idValue = $('#avatar-id').val();
		  $.ajax({
			  type: "POST",
			  dataType:"html",
			  url: "delete_list.php",
			  data: {id: idValue},
			  success: function(response) {
				location.reload(true);
			  }
		  });
        }
			 else 
		  { 
		return false;
	 }
});

$("#cformclose").click(function() {
    if (confirm("\t\t Are you sure you want to cancel this?\nYour image and any information in this form will be deleted!")) {
		var idValue = $('#avatar-id').val();
		  $.ajax({
			  type: "POST",
			  dataType:"html",
			  url: "delete_list.php",
			  data: {id: idValue},
			  success: function(response) {
				location.reload(true);
			  }
		  });
        }
			 else 
		  { 
		return false;
	 }
});

$("document").ready(function() {
    $(".data-form").submit(function() {
	var formData = new FormData($('.data-form')[0]);
        if (confirm("\t\t\tAre you ready to sumbmit this listing?\nYou can always edit the listing after going to the menu tab - edit listing."))       {
			console.log();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "add-list.php",
                data: formData,
				 success: function(response) {
						  if (response.success) {
							  $("#modal1").modal('hide');
							$("#add_frame").show();
							$(".transpanel").show();
							$("#newbutt").show();
							$(".atitle").html('<a href="' + response.ad_linka + '" target="_blank">' + response.titlea + '</a>');
							$(".acomment").html(response.commenta);
							$(".aaddress").html(response.addressa);
							$(".asale-price").html(response.sale_pricea);
							$(".alease-price").html(response.lease_pricea);
							$(".alot-size").html(response.lot_sizea);
							$(".abuilding-size").html(response.build_sizea);
							$(".azoning").html(response.zoninga);
							var transdec = response.transactiona;
							if (transdec==3) {$(".atrans").html("NOT PUBLISHED");} else {$(".atrans").html("PUBLISHED");}							
							if (transdec==0) {$(".atransaction").html("in LISTINGS.");} 
							if (transdec==1) {$(".atransaction").html("in RECENT TRANSACTIONS");}
							if (transdec==2) {$(".atransaction").html("in LISTINGS and RECENT TRANSACTIONS");}
							
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
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="../js/cropper.min.js" async></script> 
<script type="text/javascript" src="../js/crop-avatar.js" async></script>
</body>
</html>
