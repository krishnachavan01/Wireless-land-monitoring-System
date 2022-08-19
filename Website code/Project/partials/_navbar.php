<?php

if(isset($_SESSION['adminloggedin']) && $_SESSION['adminloggedin']==true){
    $loggedin = true;
    $admin = true;
    $user = false;
}
elseif(isset($_SESSION['userloggedin']) && $_SESSION['userloggedin']==true){
    $loggedin = true;
    $admin = false;
    $user = true;
}
else{
    $loggedin = false;
    $admin = false;
    $user = false;
}

echo '<nav id="navbar">
        <div id="iot">
            <img src="../project/Images/nav.jpg" alt="loading image">
        </div>
        <div>
            <ul>
                <li><a href="/index.php">Home</a></li>';
                
                if(!$loggedin){
                   echo'
                        <li><a href="/project/userlogin.php">User Login</a></li>
                        <li><a href="/project/adminlogin.php">Admin Login</a></li>';
                    }

                if($admin){
                    echo'
                    <li><a href="/project/registeruser.php">Register User</a></li>
                    <li><a href="/project/manageusers.php">Manage Users</a></li>
                    <li><a href="/project/managedevices.php">Manage Devices</a></li>';
                }

                if($user)
                    echo'
                    <li><a href="/project/mydevices.php">My Devices</a></li>';

                if($loggedin){
                        echo'   
                        <li><a href="/project/logout.php">Logout</a></li>';
                }
              echo   
            '</ul>
        </div>
     </nav>';
?>