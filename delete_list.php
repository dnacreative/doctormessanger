		<?php
			$idc = $_POST["id"];		
		try {
			// cridentials
			require('../dbcon2.php');
			// connect to mysqli
			$conn = mysqli_connect($servername, $username, $password, $dbname);
			
			// statement to Retreive variables & execute
			//$sqldf = "SELECT ad_link, listing_img FROM listings WHERE id=$idc";
			//$result = mysqli_query($conn, $sqldf);
			//$sdata = mysqli_fetch_assoc($result);
			//$ad_link = $sdata["ad_link"];
			//$img_link = $sdata["listing_img"]; 
		  // 1. delete pdf file
			// get file name
			//$file_link = basename($ad_link);
			// define file location
			//$file_loc = '../flyers/'.$file_link;
			// define location to move file to
			//$file_cop_loc = '../flyers/archive/'.$file_link;
			// relocate file
			//rename($file_loc, $file_cop_loc);

		  // 2.delete image file
			// get image file name
			//$pic_link = basename($img_link);
			// define current location as a relative reference
			//$pic_loc = '../images/mod/'.$pic_link;
			// remove image file
			//unlink($pic_loc);
			
			// command to delete sql row
			$sqlda = "DELETE FROM listings WHERE id = $idc";
			
			//run 2nd query to delete sql row	
			mysqli_query($conn, $sqlda);
			
			// create a asociative array for a better control
			$data = array("success" => true, "idc" => $idc);
			
			// and you have to encode the data and also exit the code.
			exit(json_encode($data));
		} catch (Exception $e) {
			// create a asociative array
			$data = array("success" => false, "sentence" => $sql, "error" => $e.getMessage());
			// encode data and exit.
			exit(json_encode($data));
		}	
		?>

