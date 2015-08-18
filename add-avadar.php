<?php
//process pdf file upload
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
//if file exists, delete the file on the server
							unlink("../flyers/" . $_FILES["flyer"]["name"]);
						 }
//move currrent pdf to the flyers folder
		  move_uploaded_file($_FILES["flyer"]["tmp_name"],"../flyers/" . $_FILES["flyer"]["name"]);
//Make url of pdf file					
		  $ad_link="http://www.mblistings.com/flyers/" . $_FILES["flyer"]["name"];
					 }
 //SQL statement 1, insert all form fields, file url and current date time
		}
	require('../dbcon2.php');
//Connection 1
	try {
	  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	  $stmt = $conn->prepare("INSERT INTO listings (title, address, lot_size, zoning, build_size, sale_price, lease_price, comment, transaction, ad_link, date_added) VALUES (:title, :address, :lot_size, :zoning, :build_size, :sale_price, :lease_price, :comment, :transaction, :ad_link, now())");
//Bind
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
	  $last_id = $conn->lastInsertId();

//Create class
	class CropAvatar {
		private $src;
		private $id;
		private $data;
		private $file;
		private $dst;
		private $type;
		private $extension;
//location to save original image
		private $srcDir = '../images/listimg/orig';
//location to save cropped image
		private $dstDir = '../images/listimg/mod';
		private $msg;
//construct
    function __construct($src, $data, $file, $last_id) {
        $this -> setSrc($src);
        $this -> setId($last_id);
        $this -> setData($data);
        $this -> setFile($file);
        $this -> crop($this -> src, $this -> dst, $this -> data, $this -> lastid);
    }
            private $last_id;
            public function setId($last_id) {
                     $this->id = $last_id;
    }

            private function setSrc($src) 
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
                    }
                }
            }
            private function setData($data) 
			{
                if (!empty($data)) 
				{
                    $this -> data = json_decode(stripslashes($data));
                }
            }
            private function setFile($file) 
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
    					$currdate=date('YmdHis');
                        $extension = image_type_to_extension($type);
                        $src = $dir . '/' . $currdate . $extension;
                        if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) {
                            if (file_exists($src)) 
							{
                                unlink($src);
                            }
                        $result = move_uploaded_file($file['tmp_name'], $src);
//Update sql row according to row id with the url of cropped image
			  			$listing_img="http://www.mblistings.com/images/listimg/mod/" . $currdate . $extension;
						$GLOBALS[ 'listing_img' ];
 					require('../dbcon2.php');
						$GLOBALS[ 'last_id' ];
						  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
						  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						  $sql="UPDATE listings SET listing_img='$listing_img' WHERE id=$this->id";
						  $conn->exec($sql);

					$conn = null;
//Error handling
					if ($result) {
						$this -> src = $src;
						$this -> type = $type;
						$this -> extension = $extension;
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

	private function setDst() {
		$dir = $this -> dstDir;
		if (!file_exists($dir)) {
			mkdir($dir, 0777);
		}
		$this -> dst = $dir . '/' . date('YmdHis') . $this -> extension;
	}
	private function crop($src, $dst, $data) {
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
            private function codeToMessage($code) {
                switch ($code) {
                    case UPLOAD_ERR_INI_SIZE:
                        $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $message = 'The uploaded file was only partially uploaded';
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $message = 'No file was uploaded';
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $message = 'Missing a temporary folder';
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $message = 'Failed to write file to disk';
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $message = 'File upload stopped by extension';
                        break;
                    default:
                        $message = 'Unknown upload error';
                }
                return $message;
            }
            public function getResult() {
                return !empty($this -> data) ? $this -> dst : $this -> src;
            }
            public function getMsg() {
                return $this -> msg;
            }
        }
    $crop = new CropAvatar($_POST['avatar_src'], $_POST['avatar_data'], $_FILES['avatar_file'], $last_id);
        $response = array(
            'state'  => 200,
            'message' => $crop -> getMsg(),
            'result' => $crop -> getResult()
        );
        echo json_encode($response);
		    }
	catch(PDOException $e)
    {
    echo $sql . "<br>" . $e->getMessage();
    }
     $conn = null;
?>