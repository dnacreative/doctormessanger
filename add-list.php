<?php
if ($_FILES["flyer"]["size"] ==0)
{
	require('../dbcon2.php');
	try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $conn->prepare("UPDATE listings SET title = :title, address = :address, lot_size = :lot_size, zoning = :zoning, build_size = :build_size, sale_price = :sale_price, lease_price = :lease_price, comment = :comment, transaction = :transaction WHERE id = :id");
		$stmt->bindParam(':id', $_POST['id']);
		$stmt->bindParam(':title', $_POST['title']); 
		$stmt->bindParam(':address', $_POST['address']);
		$stmt->bindParam(':lot_size', $_POST['lot_size']);
		$stmt->bindParam(':zoning', $_POST['zoning']);
		$stmt->bindParam(':build_size', $_POST['build_size']);
		$stmt->bindParam(':sale_price', $_POST['sale_price']);
		$stmt->bindParam(':lease_price', $_POST['lease_price']);
		$stmt->bindParam(':comment', $_POST['comment']);
		$stmt->bindParam(':transaction', $_POST['transaction']);
	  $stmt->execute();
	   $response = array
			 ('state'  => 200, "success" => true, "id" => $_POST['id'], "titlea" => $_POST['title'], "addressa" => $_POST['address'], "lot_sizea" => $_POST['lot_size'], "zoninga" => $_POST['zoning'], "build_sizea" => $_POST['build_size'], "sale_pricea" => $_POST['sale_price'], "lease_pricea" => $_POST['lease_price'], "commenta" => $_POST['comment'], "transactiona" => $_POST['transaction'],  
		     );
	  echo json_encode($response);
	}
catch (Exception $e) {
			$data = array("success" => false, "sentence" => $sql, "error" => $e->getMessage());
			exit(json_encode($data));
					 }
}

else
{
		  $allowedExtsf = array("pdf");
		  $tempf = explode(".", $_FILES["flyer"]["name"]);
		  $extensionf = end($tempf);
		  if (($_FILES["flyer"]["type"] == "application/pdf") && ($_FILES["flyer"]["size"] < 524288000) && in_array($extensionf, $allowedExtsf)) 
		  {	  
		 	 if ($_FILES["flyer"]["error"] > 0) 
			 {
				 echo "Return Code: " . $_FILES["flyer"]["error"] . "<br>";
			 }   
				 else 
					 {
					if (file_exists("../flyers/" . $_FILES["flyer"]["name"])) 
						 {
							unlink("../flyers/" . $_FILES["flyer"]["name"]);
						 }
		  move_uploaded_file($_FILES["flyer"]["tmp_name"],"../flyers/" . $_FILES["flyer"]["name"]);				
		  $ad_link="http://www.mblistings.com/flyers/" . $_FILES["flyer"]["name"];
					 }
		  }
	require('../dbcon2.php');
	try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $conn->prepare("UPDATE listings SET title = :title, address = :address, lot_size = :lot_size, zoning = :zoning, build_size = :build_size, sale_price = :sale_price, lease_price = :lease_price, comment = :comment, transaction = :transaction, ad_link = :ad_link WHERE id = :id");
		$stmt->bindParam(':id', $_POST['id']);
		$stmt->bindParam(':title', $_POST['title']); 
		$stmt->bindParam(':address', $_POST['address']);
		$stmt->bindParam(':lot_size', $_POST['lot_size']);
		$stmt->bindParam(':zoning', $_POST['zoning']);
		$stmt->bindParam(':build_size', $_POST['build_size']);
		$stmt->bindParam(':sale_price', $_POST['sale_price']);
		$stmt->bindParam(':lease_price', $_POST['lease_price']);
		$stmt->bindParam(':comment', $_POST['comment']);
		$stmt->bindParam(':transaction', $_POST['transaction']);
		$stmt->bindParam(':ad_link', $ad_link);
	  $stmt->execute();
	   $response = array
			 ('state'  => 200, "success" => true, "id" => $_POST['id'], "titlea" => $_POST['title'], "addressa" => $_POST['address'], "lot_sizea" => $_POST['lot_size'], "zoninga" => $_POST['zoning'], "build_sizea" => $_POST['build_size'], "sale_pricea" => $_POST['sale_price'], "lease_pricea" => $_POST['lease_price'], "commenta" => $_POST['comment'], "transactiona" => $_POST['transaction'], "ad_linka" => $ad_link, 
		     );
	  echo json_encode($response);
	}
catch (Exception $e) {
			$data = array("success" => false, "sentence" => $sql, "error" => $e->getMessage());
			exit(json_encode($data));
					 }
}
?>