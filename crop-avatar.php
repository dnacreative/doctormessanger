<?php
  class CropAvatar {
	  public $id;
	  public $currdate;
	  public $src;
	  public $data;
	  public $file;
	  public $dst;
	  public $type;
	  public $extension;
//original image
	  public $srcDir = '../images/listimg/orig';
//cropped image
	  public $dstDir = '../images/listimg/mod';
	  public $msg;
  public function __construct($src, $data, $file) {
	  $this -> setSrc($src);
	  $this -> setData($data);
	  $this -> setFile($file);
	  $this -> crop($this -> src, $this -> dst, $this -> data);
  } 

		  public function setSrc($src) 
		  {
			  if (!empty($src)) 
			  {
				  $type = exif_imagetype($src);
				  if ($type) 
				  {
					  $this -> src = $src;
					  $this -> type = $type;
					  $this -> extension = image_type_to_extension($type);
					  $this -> setDst();
					  $this -> currdate = uniqid();
				  }
			  }
		  }
		  public function setData($data) 
		  {
			  if (!empty($data)) 
			  {
				  $this -> data = json_decode(stripslashes($data));
			  }
		  }
		  public function setFile($file) 
		  {
			  $errorCode = $file['error'];
			  if ($errorCode === UPLOAD_ERR_OK) 
			  {
				  $type = exif_imagetype($file['tmp_name']);
				  if ($type) 
				  {
					 
					  $dir = $this -> srcDir;
					  if (!file_exists($dir)) 
					  {
						  mkdir($dir, 0777);
					  }
					  $currdate = uniqid();
					  $extension = image_type_to_extension($type);
					  $src = $dir . '/' . $currdate . $extension;
					  if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
						  if (file_exists($src)) 
						  {
							  unlink($src);
						  }
					  $result = move_uploaded_file($file['tmp_name'], $src);
					  $listing_img="http://www.mblistings.com/images/listimg/mod/" . $currdate . $extension;
								require('../dbcon2.php');
								  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
								  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								  $stmt = $conn->prepare("INSERT into listings (listing_img, date_added) VALUES (:listing_img, now())");
								  $stmt->bindParam(':listing_img', $listing_img);
								  $stmt->execute();
								  $this -> id = $conn->lastInsertId();
								  $conn = null;
				  if ($result)
				   {
					  $this -> src = $src;
					  $this -> type = $type;
					  $this -> extension = $extension;
					  $this -> currdate = $currdate;
					  $this -> setDst();
				  } else {
					   $this -> msg = 'Failed to save image file';
				  }
			  } else {
				  $this -> msg = 'Please upload image with the following types only: JPG, PNG, GIF';
			  }
		  } else {
			  $this -> msg = 'Please upload image file';
		  }
	  } else {
		  $this -> msg = $this -> codeToMessage($errorCode);
	  }
  }
  public function setDst() {
	  $dir = $this -> dstDir;
	  if (!file_exists($dir)) {
		  mkdir($dir, 0777);
	  }
	  $this -> dst = $dir . '/' . $this -> currdate . $this -> extension;
  }
  public function crop($src, $dst, $data) {
	  if (!empty($src) && !empty($dst) && !empty($data)) {
		  switch ($this -> type) {
			  case IMAGETYPE_GIF:
				  $src_img = imagecreatefromgif($src);
				  break;
			  case IMAGETYPE_JPEG:
				  $src_img = imagecreatefromjpeg($src);
				  break;
			  case IMAGETYPE_PNG:
				  $src_img = imagecreatefrompng($src);
				  break;
		  }
		  if (!$src_img) {
			  $this -> msg = "Failed to read the image file";
			  return;
		  }
		  $dst_img = imagecreatetruecolor(220, 220);
		  $result = imagecopyresampled($dst_img, $src_img, 0, 0, $data -> x, $data -> y, 220, 220, $data -> width, $data -> height);
		  if ($result) {
			  switch ($this -> type) {
				  case IMAGETYPE_GIF:
					  $result = imagegif($dst_img, $dst);
					  break;
				  case IMAGETYPE_JPEG:
					  $result = imagejpeg($dst_img, $dst);
					  break;
				  case IMAGETYPE_PNG:
					  $result = imagepng($dst_img, $dst);
					  break;
			  }
			  
			  if (!$result) {
				  $this -> msg = "Failed to save the cropped image file";
			  }
		  } else {
			  $this -> msg = "Failed to crop the image file";
		  }
		  imagedestroy($src_img);
		  imagedestroy($dst_img);
	  }
  }
		  
		    	  public function getResult() {
			  return !empty($this -> data) ? $this -> dst : $this -> src;
		  }
				  public function getMsg() {
			  return $this -> msg;
		  }
		  		  public function getId() {
			  return $this->id;
		  }		  
	  }
 			 $crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file'], $id);
	  		 $response = array
			 (
				  'state'  => 200,
				  'message' => $crop -> getMsg(),
				  'result' => $crop -> getResult(),
				  'id' => $crop -> getId() 
		     );
	  echo json_encode($response);
?>