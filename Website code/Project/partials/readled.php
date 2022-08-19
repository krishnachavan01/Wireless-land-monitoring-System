<?php
 
//  header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Creating Array for JSON response
$response = array();
 
// Include data base connect class

 // Connecting to database
 include '_dbconnect.php';
 
// Check if we got the field from the user
if (isset($_GET["device_no"])) {
    $device_no = $_GET['device_no'];
   
     // Fire SQL query to get weather data by id
    $sql = "SELECT *FROM devicelink WHERE device_no = '$device_no'";
    $result = mysqli_query($conn, $sql);
	
	//If returned result is not empty
    if (!empty($result)) {

        // Check for succesfull execution of query and no results found
        if (mysqli_num_rows($result) > 0) {
			
			// Storing the returned array in response
            $result = mysqli_fetch_array($result);
			
			// temperoary user array
            $led = array();
            $led["device_no"] = $result["device_no"];
            $led["pump"] = $result["pump"];
          
            $response["success"] = 1;

            $response["led"] = array();
			
			// Push all the items 
            array_push($response["led"], $led);
 
            // Show JSON response
            echo json_encode($response);
        } else {
            // If no data is found
            $response["success"] = 0;
            $response["message"] = "No data on led found";
 
            // Show JSON response
            echo json_encode($response);
        }
    } else {
        // If no data is found
        $response["success"] = 0;
        $response["message"] = "No data on led found";
 
        // Show JSON response
        echo json_encode($response);
    }
} else {
    // If required parameter is missing
    $response["success"] = 0;
    $response["message"] = "Parameter(s) are missing. Please check the request";
 
    // echoing JSON response
    echo json_encode($response);
}
?>