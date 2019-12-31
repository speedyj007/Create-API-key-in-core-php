
<?php

$response = array();

		$server = "localhost";
		$user = "root";
		$pass = "prabeer";
		$db = "just";

		
		
$con = mysqli_connect($server, $user, $pass, $db) or die($$con);

if($con->connect_error)
{
	
	echo "<h2>Something went wrong: </h2>".$con->connect_error;
}



date_default_timezone_set("Asia/Kolkata");
$date = date("Y-m-d h:i:s");


?>