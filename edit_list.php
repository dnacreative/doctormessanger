<?php
	require('../dbcon2.php');
	try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $conn->prepare("UPDATE listings SET title = :title, address = :address, lot_size = :lot_size, zoning = :zoning, build_size = :build_size, sale_price = :sale_price, lease_price = :lease_price, comment = :comment, transaction = :transaction WHERE id = :id");	  			
//Bind
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
	
	}
	catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
     $conn = null;
?>