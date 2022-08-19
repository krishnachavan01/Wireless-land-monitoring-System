<?php
session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location: ../userlogin.php");
  exit;
}
// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['device_no']) && isset($_GET['pump'])) {
 
    $device_no = $_GET['device_no'];
    $pump = $_GET['pump'];
    
 
    // Include data base connect class

	// Connecting to database
    include '_dbconnect.php';
 
	// Fire SQL query to update LED status data by id
    $update = "UPDATE `devicelink` SET `pump` = '$pump' WHERE `devicelink`.`device_no` = $device_no;";
    $result = mysqli_query($conn, $update);
 
    // Check for succesfull execution of query and no results found
    if ($result) {
        // successfully updation of LED status (status)
        $response["success"] = 1;
        $response["message"] = "Water Pump Status successfully updated.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
 
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>