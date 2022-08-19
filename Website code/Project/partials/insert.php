<?php
// session_start();

// if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
//   header("location: ../userlogin.php");
//   exit;
// }


// header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
//Creating Array for JSON response
$response = array();
 
// Check if we got the field from the user
if (isset($_GET['device_no']) && isset($_GET['temp']) && isset($_GET['hum']) && isset($_GET['moisture'])) {
    
    include '_dbconnect.php';
    $device_no = $_GET['device_no'];
    $temp = $_GET['temp'];
    $hum = $_GET['hum'];
    $moisture = $_GET['moisture'];

    // Include data base connect class
    // Connecting to database 
 
    // Fire SQL query to insert data in parameters
    $insert = "INSERT INTO parameters (device_no,temp,hum,moisture,datetime) VALUES ('$device_no','$temp','$hum','$moisture', current_timestamp())";
    $result = mysqli_query($conn, $insert);
 
    // Check for succesfull execution of query
    if ($result) {
        // successfully inserted 
        $response["success"] = 1;
        $response["message"] = "parameters successfully inserted.";
 
        // Show JSON response
        echo json_encode($response);
    } else {
        // Failed to insert data in database
        $response["success"] = 0;
        $response["message"] = "Something has been wrong";
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // Show JSON response
    echo json_encode($response);
}
?>