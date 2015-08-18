<?php
class SelectList
{
    protected $conn;
 
        public function __construct()
        {
            $this->DbConnect();
        }
 
        protected function DbConnect()
        {
	   		include('../dbcon2.php');
	       	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			if ($conn->connect_error) 
			{
    			die("Connection failed: " . $conn->connect_error);
			}
			return TRUE;  
			     
		}
 
        public function ShowTitle()
        {
			$connect = $this->conn; 
            $stmt = $connect->prepare('SELECT * FROM listings');
			$stmt->execute();
        	$stmt->setFetchMode(PDO::FETCH_ASSOC);
        	$iterator = new IteratorIterator($stmt);
        	foreach ($iterator as $row) 
			{
                $title .= '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
            }
            return $title;

        }	    
		 public function ShowAddress()
        {
            $stmt = $conn->prepare('SELECT * FROM listings');
			$stmt->execute();
        	$stmt->setFetchMode(PDO::FETCH_ASSOC);
        	$iterator = new IteratorIterator($stmt);
        	foreach ($iterator as $row) 
			{
                $address .= '<option value="' . $row['id'] . '">' . $row['address'] . '</option>';
            }
            return $address;

        }	  
}
$opt = new SelectList();
?>