<?php
$src=$_POST['avatar_src'];
$data=$_POST['avatar_data'];
$modDir = '../images/listimg/orig';
$origDir = '../images/listimg/mod';
$type = exif_imagetype($_FILES["avatar_file"]);
$extension = image_type_to_extension($type);
$data = json_decode(stripslashes($data));
$type=exif_imagetype($file['tmp_name']);
							if ($type) 
							{
								$mod = $modDir;
								if (!file_exists($mod)) 
								{
									mkdir($mod, 0777);
								}
								$currdate=date('YmdHis');
								$src = $mod . '/' . $currdate . $extension;
								if ($type == IMAGETYPE_GIF || $type == IMAGETYPE_JPEG || $type == IMAGETYPE_PNG) 
								{
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
								  $last_id = $conn->lastInsertId();
								  $conn = null;
								}
							}
				$dir = $origDir;
				if (!file_exists($dir)) 
				{
					mkdir($dir, 0777);
				}
				$dst = $dir . '/' . $currdate . $extension;
			

				if (!empty($src) && !empty($dst) && !empty($data)) 
				{
					switch ($type) 
					{
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
					if (!$src_img) 
					{
						$msg = "Failed to read the image file";
						return;
					}
					$dst_img = imagecreatetruecolor(220, 220);
					$result = imagecopyresampled($dst_img, $src_img, 0, 0, $data -> x, $data -> y, 220, 220, $data -> width, $data -> height);
					if ($result) 
					{
						switch ($type) 
						{
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
						if (!$result) 
						{
							$msg = "Failed to save the cropped image file";
						}
					} else 
						{
						$msg = "Failed to crop the image file";
						}
					imagedestroy($src_img);
					imagedestroy($dst_img);
				}
			
						switch ($code) 
						{
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
					
						return !empty($data) ? $dst : $src;
						return $msg;
$_POST['avatar_src'];
$_POST['avatar_data'];
$_FILES['avatar_file'];
				$response = array(
					'state'  => 200,
					'message' => $crop -> getMsg(),
					'result' => $crop -> getResult(),
					'last_id' => $crop -> getLast_id()
				);
				echo json_encode($response);

		?>