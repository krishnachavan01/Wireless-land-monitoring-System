<?php
session_start();

if(!isset($_SESSION['adminloggedin']) || $_SESSION['adminloggedin']!=true){
  header("location: adminlogin.php");
  exit;
}

include 'partials/_dbconnect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
    rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
    
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/manageusers.css">
</head>
<body>
    
    <?php require 'partials/_navbar.php' ?>

    <table>
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Users</th>
              <th>Role</th>
              <th>Edit</th>
              </tr>
              </thead>
              <tbody>
        <?php   
                $sql = "SELECT * FROM `users`";
                $result = mysqli_query($conn, $sql);
                $num = mysqli_num_rows($result);
                
                if($num > 0){
                  
                  while($row = mysqli_fetch_assoc($result)){
                   
                  //   echo "<br>";
                  //  echo "device no". $row['device_no'];
                echo   '<tr>
                     <td>'.$row['SrNo'].'</td> 
                     <td>'.$row['username'].'</td>
                     <td>'.$row['role'].'</td>
                     <td><button type="submit" class="btn"><a href="/project/useredit.php?SrNo='.$row['SrNo'].'">Edit</a></button></td>
                   </tr>';
                    
                  }
              }
              ?>
          </tbody>
        </table>

</body>
</html>