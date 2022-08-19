<?php
$server = "localhost";
$username = "id18565308_farm_monitor";
$password = "PyuSSCpM78@N";
$database = "id18565308_monitor";

$conn = mysqli_connect($server, $username, $password, $database);
if (!$conn){
//   echo "Success";
// }
// else{
    die("Error". mysqli_connect_error());
}

?>