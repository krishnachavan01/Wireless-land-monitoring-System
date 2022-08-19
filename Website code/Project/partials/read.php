<?php

session_start();

// if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
//   header("location: ../userlogin.php");
//   exit;
// }

include '_dbconnect.php';

$device_no = $_SESSION['device_no'];

// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Creating Array for JSON response
$response = array();
 
// Include data base connect class
 // Connecting to database 
 
 // Fire SQL query to get all data from weather
// $read = "SELECT * FROM `parameters`";
$read = "SELECT * FROM `parameters` WHERE `device_no` = $device_no";
$result = mysqli_query($conn, $read);
$rows = mysqli_num_rows($result);
// Check for succesfull execution of query and no results found
if ($rows > 0) {
    
	// Storing the returned array in response
    $response["parameters"] = array();
 
	// While loop to store all the returned response in variable
    while ($row = mysqli_fetch_array($result)) {
        // temperoary user array
        $parameter = array();
        $parameter["id"] = $row["id"];
        $parameter["datetime"] = $row["datetime"];
        $parameter["temp"] = $row["temp"];
		$parameter["hum"] = $row["hum"];
        $parameter["moisture"] = $row["moisture"];
		// Push all the items 
        array_push($response["parameters"], $parameter);
    }
    // On success
    $response["success"] = 1;
 
    // Show JSON response
    echo json_encode($response);
}	
else 
{
    // If no data is found
	$response["success"] = 0;
    $response["message"] = "No parameters data found.";
 
    // Show JSON response
    echo json_encode($response);
}
?>