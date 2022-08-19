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
    $sr_no = $_POST["SrNo"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $cpassword = $_POST["cpassword"];
    $role = $_POST["role"];

    if($password == $cpassword){
        $update = "UPDATE `users` SET `password` = '$password' WHERE `users`.`SrNo` = '$sr_no'";
        $result = mysqli_query($conn, $update);
        if ($result){
            $showAlert = true;
        }
    }
   else{
            $showError = "Passwors do not match";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User Details</title>

    <!-- Bootstrap CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    

    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
    rel="stylesheet">

    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/useredit.css">
    <style>
        div select{
            width: 100%;
            padding: 0.5rem;
            border-radius: 9px;
            font-size: 1.1rem;
        }
    </style>

</head>
<body>

    <?php require 'partials/_navbar.php' ?>
    <div id="useredit">
            <h1 class="h-primary centre"> Edit User Details </h1>

            <?php
    if($showAlert){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong> Your password has changed successfully.
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

            <form action="/project/useredit.php" method="post">
    <?php    
       if(isset($_GET['SrNo'])){
           $sr_no = $_GET['SrNo'];
           $sql = "SELECT * FROM `users` WHERE `SrNo` = '$sr_no'";
           $result = mysqli_query($conn, $sql);
           $num = mysqli_num_rows($result);
           $row = mysqli_fetch_assoc($result);
           if($num == 1){ 
            
         echo  "<input type='hidden' name='SrNo' value=".$row['SrNo']."> 
                <div class='input'>
                    <label for='username'>User Name: </label>
                    <input type='text' name='username' id='username' value=".$row['username']." placeholder='Enter your User Name'>
                </div>
                <div class='input'>
                    <label for='password'>Password: </label>
                    <input type='password' name='password' id='password' placeholder='Enter your Password'>
                </div>
                <div class='input'>
                    <label for='password'>Confirm Password: </label>
                    <input type='password' name='cpassword' id='cpassword' placeholder='Make sure to type same Password'>
                </div>
                <div class='input'>
                    <label for='role'>Role: </label>
                    <select name='role' id='role'>
                        <option value='user' selected>user</option>
                        <option value='admin'>admin</option>
                    </select>
                </div>
                <div class='input'>
                    <button type='submit' class='bn'>Submit</button>
                </div>";
            }
            else{
                echo "No records";
            }
        }
     ?>
            </form>
            </div>
    
            <!-- Option 1: Bootstrap Bundle with Popper -->
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>