<?php
$login = false;
$showError = false;
if($_SERVER["REQUEST_METHOD"] == "POST"){    
    include 'partials/_dbconnect.php';
    $username = $_POST["username"];
    $password = $_POST["password"];

        $sql = "Select * from users where username ='$username' AND password = '$password'";
        // $sql = "Select * from users where username ='$username'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1){
            // while ($row=mysqli_fetch_assoc($result)){
              // if (password_verify($password, $row['password'])){
                $login = true;
                session_start();
                $_SESSION['userloggedin'] = true;
                $_SESSION['username'] = $username;
                header("location: mydevices.php");
              }
              else{
                $showError = "Invalid Credentials";
             }
            // }
        // } 
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Oswald:wght@300&display=swap"
    rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    
    <link rel="stylesheet" href="CSS/nav.css">
    <link rel="stylesheet" href="CSS/utility_class.css">
    <link rel="stylesheet" href="CSS/userlogin.css">
</head>
<body>
    
    <?php require 'partials/_navbar.php' ?>
    <?php
    if($login){
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
             <strong>Success!</strong> You are logged in.
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
    <div id="userlogin">
            <h1 class="h-primary"> User Login </h1>
            <form action="/project/userlogin.php" method="post">
                <div class="input">
                    <label for="username">User Name: </label>
                    <input type="text" name="username" id="username" placeholder="Enter your User Name">
                </div>
                <div class="input">
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" placeholder="Enter your Password">
                </div>
                <div class="input">
                    <button type="submit" class="bn">Login</button>
                </div>
            </form>
    </div>

         <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>