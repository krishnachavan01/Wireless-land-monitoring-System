<?php
session_start();

if(!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin']!=true){
  header("location: adminlogin.php");
  exit;
}

include 'partials/_dbconnect.php';

$showAlert = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $farmname = $_POST["Farm"];
    $device_no = $_POST["device_no"];
    // echo $username;
    $existsuser = "SELECT * FROM `users` WHERE `username` = '$username'";
     $resultuser = mysqli_query($conn, $existsuser);
     $numExistRow = mysqli_num_rows($resultuser);
    //  echo $numExistRow;
    if($numExistRow == 1){
        $existsdevice = "Select * FROM `devicelink` WHERE 'device_no' = '$device_no'";
        $resultdevice = mysqli_query($conn, $existsdevice);
        $numExistRows = mysqli_num_rows($resultdevice);
        if($numExistRows == 0){
            $sql = "INSERT INTO `devicelink` (`Farm`, `device_no`, `username`) VALUES ('$farmname', '$device_no', '$username')";
            $result = mysqli_query($conn, $sql);
            if ($result){
                $showAlert = true;
            }
            else{
                $showError = "This Device No. Already Exists.";
            }
        }
    }
    else{
        $showError = "User does not exist.";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Devices</title>
    
    <!-- Bootstrap CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
    rel="stylesheet">
    
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/manageusers.css">
    <link rel="stylesheet" href="CSS/managedevices.css">

</head>
<body>
    
    <?php require 'partials/_navbar.php' ?>

    <h1 class="h-primary centre"> Add New Device</h1>
    <?php
    if($showAlert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong> Device No. '.$device_no.' is now added to '.$username.' account.
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    if($showError){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
             <strong>Error!</strong>  '.$showError.'
             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
    ?>

    <div id="newdevice">
            <form action="/project/managedevices.php" method="post">
                <div class="input">
                    <label for="username">User Name: </label>
                    <input type="text" name="username" id="username" placeholder="Enter User Name">
                </div>
                <div class="input">
                    <label for="Farm">Farm Name: </label>
                    <input type="text" name="Farm" id="Farm" placeholder="Enter Farm Name">
                </div>
                <div class="input">
                    <label for="device_no">Device No: </label>
                    <input type="number" name="device_no" id="device_no" placeholder="Enter Device No">
                </div>
                <div class="input">
                    <button type="submit" class="bn">Add</button>
                </div>
            </form>
    </div>

    <table>
          <thead>
            <tr>
              <th>Farm Name</th>
              <th>Device No</th>
              <th>User</th>
              </tr>
              </thead>
              <tbody>
        <?php   
                $sql = "SELECT * FROM `devicelink`";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                
                if($num > 0){
                  
                  while($row = mysqli_fetch_assoc($result)){
                   
                  //   echo "<br>";
                  //  echo "device no". $row['device_no'];
                echo   '<tr>
                     <td>'.$row['Farm'].'</td> 
                     <td>'.$row['device_no'].'</td>
                     <td>'.$row['username'].'</td>
                   </tr>';
                    
                  }
              }
              ?>
          </tbody>
        </table>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>
</html>