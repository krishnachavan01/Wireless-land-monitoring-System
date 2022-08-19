<?php
session_start();

if(!isset($_SESSION['userloggedin']) || $_SESSION['userloggedin']!=true){
  header("location: userlogin.php");
  exit;
}

include 'partials/_dbconnect.php';
$username = $_SESSION['username'];

// $show = false;
$showError = false;

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $device_no = $_POST["device_no"];
  $sql = "Select * from devicelink where device_no ='$device_no' AND username = '$username'";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);
  if($num == 1){
    $_SESSION['device_no'] = $device_no;
    header("location: parameters.php");
  }
  else{
    $showError = "Device No. ".$device_no." is not link to your account";
 }
} 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weclome</title>

    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
    rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/mydevices.css">
</head>
<body>
    
        <?php require 'partials/_navbar.php' ?>
        <h1 class="h-primary centre">Welcome   <?php echo $username; ?></h1>
        
        <table>
          <thead>
            <tr>
              <th>Farm Name</th>
              <th>Device No.</th>
              <th>Water Pump</th>
              </tr>
              </thead>
              <tbody>
        <?php   
                $sql = "SELECT * FROM `devicelink` WHERE `username` = '$username'";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                
                if($num > 0){
                  
                  while($row = mysqli_fetch_assoc($result)){
                   
                  //   echo "<br>";
                  //  echo "device no". $row['device_no'];
                echo   '<tr>
                     <td>'.$row['Farm'].'</td> 
                     <td>'.$row['device_no'].'</td>
                     <td>'.$row['pump'].'</td>
                   </tr>';
                    
                  }
              }
              ?>
          </tbody>
        </table>
        <?php
        if($showError){
          echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                   <strong>Access Denied!</strong>  '.$showError.'
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
          }
        ?>
        <div id="userlogin">
          <form action="/project/mydevices.php" method="post">
                <div class="input">
                <label for="device_no">Device No</label>
                <input type="text"  id="device_no" name="device_no" placeholder="Enter Device No">
                </div>
                <button type="submit" class="bn">View</button>
            </form>
      </div>
     <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
</body>
</html>